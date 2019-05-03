<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Http\Exception\NotFoundException;
use Cake\Mailer\Email;
use Cake\Http\Session;
use Cake\Log\Log;
use Cake\Auth\DefaultPasswordHasher;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function initialize()
    {
        $this->_RequestData = $this->request->getData();
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Cookie');
        $this->Auth->allow(['logout','login','pop','forgotPassword','resetPassword','exitSuperAdminLogin']);
    }

    /**
    * This method is authorize User for various actions
    *
    * @param mixed[] $user contains users data .
    * @return void
    **/
    public function isAuthorized($user)
    {
        // pr($user['role']->name); die('ss');
        $action = $this->request->getParam('action');
        // pr($action); die();

        // The add and index actions are always allowed.
        if (in_array($action, ['index', 'view','add','edit','delete','loginThroughSuperAdmin','exitSuperAdminLogin']) && $user['role']->name === self::SUPER_ADMIN_LABEL) {
        // pr($action); die('in super admin');
            return true;
        }
        else if (in_array($action, ['view']) && $user['role']->name === self::TENANT_LABEL) {
        // pr($action); die('in tenant admin');
            return true;
        }
        // All other actions require an id.
        /*if (empty($this->request->getParam('pass.0'))) {
            return $this->redirect(['controller' => 'tenants','action' => 'index']);
        }*/
        return parent::isAuthorized($user);
    }

    public function pop()
    {
        // die('ss');
        $this->viewBuilder()->setLayout('popup-view');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $users = $this->Users->find()->contain(['Roles'])->all();
        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
            $user = $this->Users->get($id, [
                'contain' => ['Roles']
            ]);

        $this->set('user', $user);

    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        $data = $this->request->getData();
        $data['role_id'] = 1;

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data = [
                        'role_id' => 1,
                        'first_name' => $data['first_name'],
                        'last_name' => $data['last_name'],
                        'email' => $data['email'],
                        'password' => $data['password'],
                    ];
            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $this->set(compact('user', 'roles'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        if(!$id){
            $id = $this->Auth->user('id');
        }
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            
            $user = $this->Users->patchEntity($user, $this->request->getData());
/*            pr($user);die;
*/            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $loggedInUser = $this->Auth->User();
        $roles = $this->Users->Roles->find('list', ['limit' => 200]);
        $this->set(compact('user', 'roles','loggedInUser'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            // pr($user)die();
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function loginThroughSuperAdmin($tenantId = null){
      if(!$tenantId){
        $this->Flash->error(__('Tenant id is required'));
        return $this->redirect($this->referer());
      }
      $this->loadModel('TenantUsers');
      $tenant = $this->TenantUsers->findByTenantId($tenantId)
                                  ->where(['owner' == '1'])
                                  ->first();
      // pr($tenant);die();
      if(!$tenant || $tenant == null){
        $this->Flash->error(__('Tenant not found'));
        return $this->redirect($this->referer());
      }
      $superAdminUser = $this->Users->findById($this->Auth->user('id'))->first()->toArray();
      // pr($superAdminUser);die();
      // $this->_deleteSession();
      $this-> deleteSession();
      $session = $this->request->getSession();
      $session->write('superAdminUser', $superAdminUser);
      $this->login1($tenant);
    }

    public function login1($user){
      $this->loadModel('Roles');
      $loggedInUser = $this->Auth->user();
      $user['role']=$query = $this->Roles->find('RolesById',['role' =>$user['role_id']])->select(['name','label'])->first();
      // pr($user);die();
      $this->Auth->setUser($user);
      if(!empty($query) && $query->name == 'super_admin'){
        $this->redirect(['controller' => 'tenants',
          'action' => 'index'
        ]);
      } elseif(!empty($query) && $query->name == 'tenant'){
        $this->redirect(['controller' => 'tenants',
          'action' => 'dashboard'
        ]);
      }
    }

    public function login($user = null){
      
        $this->viewBuilder()->setLayout('login-admin-override');
        if ($this->request->is('post')) {

            $user = $this->Auth->identify();
            $this->Cookie->write('loginAction', ['controller' => 'Users', 'action' => 'login']);
            if($user){ 
              $this->login1($user);
            }else{
              $this->Flash->error('Please enter correct email or password!');
              $this->redirect(['controller' => 'users','action' => 'login']);
            }
        }
    }

     public function exitSuperAdminLogin(){
     $session = $this->request->getSession();
     $superAdminUser = $session->read('superAdminUser');
     // pr($superAdminUser); die;
     if(!$superAdminUser){
      $this->Flash->error(__('No super admin user is set.'));
      return $this->redirect($this->referer());
     }
     $this-> deleteSession();
     $this-> login1($superAdminUser);
    }

    private function deleteSession(){
    $user = $this->Auth->user();
    $this->Auth->logout();
   
    $session = $this->request->getSession();
    $session->destroy();
    // pr($session->read('superAdminUser'));
  }

    public function forgotPassword(){
      if($this->Auth->user()){
        $this->Flash->error("UNAUTHORIZED REQUEST");
        $this->redirect(['action' => 'logout']);
      }
      $this->viewBuilder()->setLayout('login-admin-override');
      // $domainType = "http://$_SERVER[HTTP_HOST]";
      // $domainType = 'cmc.classbyte.twinspark.co/tenants/login';
      // $domainType = 'mi.classbyte.twinspark.co';
      // $userData = $this->Users->find()
                                  // ->where(['domain_type LIKE' => '%'.$domainType.'%'])
                                  // ->first();
      
      if ($this->request->is('post')) {
        $email = $this->request->getData('email');
        $users = $this->Users->find('all')
                             ->where(['email' => $email])
                             ->first();
      
        if(!$users){
          return $this->Flash->error(__("This email doesn't exist for this user."));
        }
        $this->loadModel('UsersResetPasswordHashes');
        $hashResetPassword = $this->UsersResetPasswordHashes->find()
                                                            // ->where(['user_id' => $id])     
                                                            ->first();
         if(empty($hashResetPassword)){
          $resetPwdHash = $this->_createResetPasswordHash($users->id);
        }else{
          $resetPwdHash = $hashResetPassword->hash;
          $time = new Time($hashResetPassword->created);
          if(!$time->wasWithinLast(1)){
            $this->UsersResetPasswordHashes->delete($hashResetPassword);
            $resetPwdHash =$this->_createResetPasswordHash($users->id);
          }
        }
        $url = Router::url('/', true);
        $url = $url.'users/resetPassword/?reset-token='.$resetPwdHash;
        $emailBody = '<p><span style="font-weight: 400;">Hi '.$users->first_name.',<br /></span><span style="font-weight: 400;"><br /></span><span style="font-weight: 400;">We have received a request to reset your password. Please use the following link to reset your password '.$url.'.<br /><br /></span><span style="font-weight: 400;">Thank you,</span><span style="font-weight: 400;"><br /></span><span style="font-weight: 400;">ClassByte Support Team</span></p>';
        $email = new Email('default');
        $email->setTo($users->email)
              ->emailFormat('html')
              ->setSubject('Reset Password Link')
              ->send($emailBody);

        $this->Flash->success(__('Please check your email to verify yourself and change your password'));
        $this->redirect(['action' => 'login']);

       }
    }

    protected function _createResetPasswordHash($userId){
      
        $this->loadModel('UsersResetPasswordHashes');
        $resetPasswordrequestData = $this->UsersResetPasswordHashes->find()
                                                                    ->where(['user_id' =>$userId ])
                                                                    ->first();
        if($resetPasswordrequestData){
            return $resetPasswordrequestData->hash;
        }
        $hasher = new DefaultPasswordHasher();
        $reqData = ['user_id'=>$userId,'hash'=> $hasher->hash($userId)];
        $createPasswordhash = $this->UsersResetPasswordHashes->newEntity($reqData);
        $createPasswordhash = $this->UsersResetPasswordHashes->patchEntity($createPasswordhash,$reqData);
        if($this->UsersResetPasswordHashes->save($createPasswordhash)){
          return $createPasswordhash->hash;
      }else{
        Log::write('error','error in creating resetpassword hash for user id '.$userId);
        Log::write('error',$createPasswordhash);
      }
        return false;
    }

    public function resetPassword(){
        $this->viewBuilder()->setLayout('login-admin-override');
        $resetToken = $this->request->query('reset-token');

        if ($this->request->is('post')) {
          $uuid = (isset($this->_RequestData['reset-token']))?$this->_RequestData['reset-token']:'';
          if(!$uuid){
            $this->Flash->error(__('BAD REQUEST'));
            $this->redirect(['action' => 'login']);
            return;
          }
          $password = (isset($this->_RequestData['new_pwd']))?$this->_RequestData['new_pwd']:'';
          if(!$password){
            $this->Flash->error(__('PROVIDE PASSWORD'));
            $this->redirect(['action' => 'resetPassword','?'=>['reset-token'=>$uuid]]);
            return;
          }
          $cnfPassword = (isset($this->_RequestData['cnf_new_pwd']))?$this->_RequestData['cnf_new_pwd']:'';
          if(!$cnfPassword){
            $this->Flash->error(__('CONFIRM PASSWORD'));
            $this->redirect(['action' => 'resetPassword','?'=>['reset-token'=>$uuid]]);
            return;
          }
          if($password !== $cnfPassword){
            $this->Flash->error(__('MISMATCH PASSWORD'));
            $this->redirect(['action' => 'resetPassword','?'=>['reset-token'=>$uuid]]);
            return;
          }

          $this->loadModel('UsersResetPasswordHashes');
          $checkExistPasswordHash = $this->UsersResetPasswordHashes->find()->where(['hash'=>$uuid])->first();

          if(!$checkExistPasswordHash){
            $this->Flash->error(__('INVALID RESET PASSWORD'));
            $this->redirect(['action' => 'login']);
            return;
          }
           $user = $this->Users->findById($checkExistPasswordHash->user_id )->first();
           if(!$user){
            $this->Flash->error(__("User Doesn't exist."));
            $this->redirect(['action' => 'login']);
            return;
           }
           $reqData = ['password'=>$password];
           $hasher = new DefaultPasswordHasher();

           $user = $this->Users->patchEntity($user, $reqData);
            if($this->Users->save($user)){
                $data =array();
                $data['status']=true;
                $data['data']['id']=$user->id;
                $this->Flash->success("Password reset successfully");
                return $this->redirect(['action' => 'login']);
            }else{
                throw new InternalErrorException("Something went wrong, try after some time!");
            }
            $this->set('response',$data);
            $this->set('_serialize', ['response']);
        }

        $this->set('resetToken',$resetToken);
        $this->set('_serialize', ['reset-token']);
    }

    /**
     * Logout method
     * @param null
     * @return \Cake\Http\Response|null Redirects to login.
     */
    public function logout(){
      $loggedInUser = $this->Auth->user();

      if($loggedInUser['role_id'] == 5 && isset($loggedInUser['role_id'])){
        $redirectUrl = ['controller' => 'tenants','action' => 'login'];
      }else{
        $redirectUrl = ['action' => 'login'];
      }

      $this->Auth->logout();
      return $this->redirect($redirectUrl);
    }
}
