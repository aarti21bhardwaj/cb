<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Http\Exception\NotFoundException;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Mailer\Email;
use Cake\Routing\Router;
use Cake\I18n\FrozenTime;
use Cake\I18n\Time;
use Cake\Http\Session;
use Cake\Log\Log;
use Cake\Http\Exception\BadRequestException;
use Cake\Collection\Collection;
use Cake\I18n\Date;
use Cake\Database\Expression\QueryExpression;
use Cake\Utility\Text;



/**
 * Tenants Controller
 *
 * @property \App\Model\Table\TenantsTable $Tenants
 *
 * @method \App\Model\Entity\Tenant[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TenantsController extends AppController
{

    public function initialize()
    { 
        $this->_RequestData = $this->request->getData();
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Cookie');
        $this->Auth->allow(['logout','login','notFound','dashboard','forgotPassword','tenantCourseReply','resetPassword','CourseReply']);
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
        if (in_array($action, ['index', 'view','add','edit','delete','updateStatus']) && $user['role']->name === self::SUPER_ADMIN_LABEL) {
        // pr($action); die('in super admin');
            return true;
        }
        else if (in_array($action, ['index','view','edit','delete']) && $user['role']->name === self::TENANT_LABEL) {
        // pr($action); die('in tenant admin');
            return true;
        }
        // All other actions require an id.
        /*if (empty($this->request->getParam('pass.0'))) {
            return $this->redirect(['controller' => 'tenants','action' => 'index']);
        }*/
        return parent::isAuthorized($user);
    }

    public function CourseReply($reply){
      // die('inside');
      $this->loadModel('Courses');
      $transferCourse = $this->request->getSession()->read('transferCourse');
      $this->viewBuilder()->setLayout('login-admin-override');
      $course = $this->Courses->findById($transferCourse->course_id)
                              ->contain(['CourseTypes'])
                              ->first();
     // pr($this->request->getSession()->read('transferCourse'));die();
      if(isset($transferCourse) && !empty($transferCourse)){
        $this->set(compact('transferCourse','reply','course'));
        // $this->Session->delete('TransferCoursesrCourse');  
        // pr($this->session());die;
      }else{
        $this->viewBuilder()->setTemplate('not-found');
      }

    }


    public function tenantCourseReply($courseId,$tenantUuid,$reply)
    {
      
      $this->viewBuilder()->setLayout('login-admin-override');
      // die('ss');
      // pr($courseId);die;
      $this->loadModel('TransferCourses');
      $transferCourse = $this->TransferCourses->findByAssignee_uuid($tenantUuid)
                                              ->where(['course_id' => $courseId])
                                              ->order(['TransferCourses.created' => 'DESC'])
                                              ->first();
                                              // pr($transferCourse);die;
      if(isset($transferCourse) && !empty($transferCourse) && $transferCourse->status == null){
        if($reply == 'accepted'){
      // die('ss');
          $data['status'] = 1;
          $transferCourse = $this->TransferCourses->patchEntity($transferCourse, $data);
          if($this->TransferCourses->save($transferCourse)){
            // $this->Flash->success(__('The course has been Accepted.'));
          }
          // die('here');
          
          // pr($transferCourse);die;
        }elseif($reply == 'declined'){
          $data['status'] = 2;
          $transferCourse = $this->TransferCourses->patchEntity($transferCourse, $data);
          if($this->TransferCourses->save($transferCourse)){
            // $this->Flash->success(__('The course has been Accepted.'));
          }
        }
          $session = new Session();
          $session->write('transferCourse', $transferCourse);
          // pr($this->request->getSession()->read('transferCourse'));die;
          // pr($transferCourse);die('sss');

            return $this->redirect(['controller' => 'Tenants', 'action' => 'courseReply',$reply]);

          

      }else{
          // pr('here');die;
          $this->viewBuilder()->setTemplate('not-found');

        }


    }


    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $loggedInUser = $this->Auth->user();
        // pr($loggedInUser);die();
        if($loggedInUser['role']->name == 'super_admin'){
          if($loggedInUser['role_id'] == 2){
              $tenants = $this->Tenants->findById($loggedInUser['id'])->all();   
          }else{
              $tenants = $this->Tenants->find()->all();
          }
          $this->set(compact('tenants'));
        }else{

          return $this->redirect(['action' => 'edit',$loggedInUser['tenant_id']]);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Tenant id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tenant = $this->Tenants->get($id, [
            'contain' => ['Addons', 'CorporateClients', 'CourseTypeCategories', 'Courses', 'Instructors', 'KeyCategories', 'Locations', 'TenantSettings', 'TrainingSites']
        ]);

        $this->set('tenant', $tenant);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $tenant = $this->Tenants->newEntity();
        // $data = $this->request->getData();


        if ($this->request->is('post')) {
            // $this->request->getData['role_id'] = 2;
            // $this->request->getData['domain_type'] = $this->request->getData['domain_type'];
            $data = $this->request->getData();
            $data['tenant_users'][0]['owner'] = 1;
            // pr($data);die;
            $data['tenant_users'][0]['role_id'] = 2;
            $data['tenant_users'][0]['status'] = 1;
            $data['tenant_themes'][0]['color'] = 2;
            $data['tenant_themes'][0]['logo_name'] = 'default-img.jpeg';
            $data['tenant_themes'][0]['logo_path'] = 'webroot/img/';
            $data['tenant_config_settings'][0]['course_description'] = 1;
            $data['tenant_config_settings'][0]['instructor_bidding'] = 1;
            $data['tenant_config_settings'][0]['card_print'] = 1;
            $data['tenant_config_settings'][0]['location_notes'] = 1;
            $data['tenant_config_settings'][0]['class_details'] = 1;
            $data['tenant_config_settings'][0]['remaining_seats'] = 1;
            $data['tenant_config_settings'][0]['promocode'] = 1;
            $data['tenant_settings'][0]['enable_training_site_module'] = 1;
            $data['tenant_settings'][0]['enable_corporate_module'] = 1;
            $data['tenant_settings'][0]['enable_aed_pm_module'] = 1;
            $data['tenant_settings'][0]['shop_menu_visible'] = 1;
            $data['tenant_settings'][0]['aed_pm_module_url'] = 'https://www.aedpmdemo.com/login';
            $data['tenant_settings'][0]['key_management'] = 1;
            $data['tenant_settings'][0]['allow_duplicate_emails'] = 1;
            $data['tenant_settings'][0]['enable_payment_email'] = 1;
            // pr($data);die;
            // $url = Router::url([
            //       'controller' => 'tenants',
            //       'action' => 'login',
            //       // '_method' => 'POST',
            //   ]);

            $url = Router::url('/', true);
            $test = explode("//", $url);
            $test2 = explode('/',$test[1]);
            $data['domain_type'] = $test[0]."//".$data['domain_type'].".".$test2[0].'/tenants/login';
            // $data['domain_type'] = "http://".$data['domain_type'].".classb.twinspark.co/tenants/login";
            // $data['domain_type'] = "http://".$data['domain_type'].".classb.twinspark.co/tenants/login";
            if (!isset($data['uuid'])) {
              $data['uuid'] = $this->_cryptographicString('alnum',6);
            }
            // pr($data); die();
            $tenant = $this->Tenants->patchEntity($tenant, $data, ['associated' => ['TenantSettings','TenantUsers','CourseTypeCategories','CourseTypeCategories.CourseTypes']]);
            // pr($tenant);die;
            // $test = $this->Tenants->save($tenant);
            if ($this->Tenants->save($tenant, ['associated' => ['TenantUsers','CourseTypeCategories','CourseTypeCategories.CourseTypes','TenantSettings']])) {
              // pr($tenant);die('dis guy is saved bruh');
                $this->Flash->success(__('The tenant has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
            $this->Flash->error(__('The tenant could not be saved. Please, try again.'));
            }
            // pr($tenant->errors()); die('ssss');
        }
        $roles = $this->Tenants->Roles->find('list', ['limit' => 200]);
        $this->set(compact('tenant', 'roles'));
    }

    /*Unique Id generator*/

    private function _cryptographicString( $type = 'alnum', $length = 6 )
    {
      switch ( $type ) {
        case 'alnum':
        $pool = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        break;
        case 'alpha':
        $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        break;
        case 'hexdec':
        $pool = '0123456789abcdef';
        break;
        case 'numeric':
        $pool = '0123456789';
        break;
        case 'nozero':
        $pool = '123456789';
        break;
        case 'distinct':
        $pool = '2345679ACDEFHJKLMNPRSTUVWXYZ';
        break;
        default:
        $pool = (string) $type;
        break;
      }
      $crypto_rand_secure = function ( $min, $max ) {
        $range = $max - $min;
        if ( $range < 0 ) return $min; // not so random...
        $log    = log( $range, 2 );
        $bytes  = (int) ( $log / 8 ) + 1; // length in bytes
        $bits   = (int) $log + 1; // length in bits
        $filter = (int) ( 1 << $bits ) - 1; // set all lower bits to 1
        do {
          $rnd = hexdec( bin2hex( openssl_random_pseudo_bytes( $bytes ) ) );
          $rnd = $rnd & $filter; // discard irrelevant bits
        } while ( $rnd >= $range );
        return $min + $rnd;
      };
      $token = "";
      $max   = strlen( $pool );
      for ( $i = 0; $i < $length; $i++ ) {
        $token .= $pool[$crypto_rand_secure( 0, $max )];
      }
      return $token;
    }

    /**
     * Edit method
     *
     * @param string|null $id Tenant id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        // pr($this->Auth->user());die();
        $loggedInUser = $this->Auth->user();
         if(!$id){
            $id = $loggedInUser['tenant_id'];
        }
        $tenant = $this->Tenants->get($id, [
            'contain' => []
        ]);

        $oldImageName = $tenant->image_name;
        $path = Configure::read('ImageUpload.unlinkPathForTenantsImages');

        if ($this->request->is(['patch', 'post', 'put'])) {
            $loggedInUser = $this->Auth->User();
            $tenant = $this->Tenants->patchEntity($tenant, $this->_RequestData);
            if ($this->Tenants->save($tenant)) {
                if(empty($this->_RequestData['image_name']['tmp_name'])){
                    unset($this->_RequestData['image_name']);
                    $oldImageName ='';
                }
                if(!empty($oldImageName)){
                    $filePath = $path . '/'.$oldImageName;
                    if($filePath != '' && file_exists( $filePath ) ){
                        unlink($filePath);
                    }
                }
                $this->Flash->success(__('The tenant has been saved.'));
                return $this->redirect(['action' => 'edit',$id]);
            }
            $this->Flash->error(__('The tenant could not be saved. Please, try again.'));
        }
        $roles = $this->Tenants->Roles->find('list', ['limit' => 200]);
        $this->set(compact('tenant', 'roles','loggedInUser'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Tenant id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tenant = $this->Tenants->get($id);
        if ($this->Tenants->delete($tenant)) {
            // pr($tenant);die();
            $this->Flash->success(__('The tenant has been deleted.'));
        } else {
            $this->Flash->error(__('The tenant could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    // public function notFound(){
    //   $this->viewBuilder()->setLayout('popup-view');
    // }

      public function login(){
          $this->viewBuilder()->setLayout('login-admin-override');
          $this->loadModel('Tenants');
          $url = Router::url('/', true);
          if($url == "http://localhost/classbyte/"){
            $domainType = 'cmc.classbyte.twinspark.co/tenants/login';
            // $domainType = 'http://dallas.classbyte.twinspark.co/tenants/login';
          }else{
            $domainType = "http://$_SERVER[HTTP_HOST]";
          }
          $tenantData = $this->Tenants->find()
                                      ->where(['domain_type LIKE' => '%'.$domainType.'%'])
                                      ->contain(['TenantSettings'])
                                      ->first();
         
          if(isset($tenantData) && !empty($tenantData)){
            $this->set(compact('tenantData'));
          }else{
              $this->viewBuilder()->setTemplate('not-found');            
          }

          if ($this->request->is('post')) {
              $this->loadModel('Roles');
              $user = $this->Auth->identify();
              // pr($user);die;
               if(!empty($tenantData->tenant_settings) && isset($tenantData->tenant_settings[0]->enable_training_site_module) && $tenantData->tenant_settings[0]->enable_training_site_module !=1 && isset($user['training_site_id']) && $user['training_site_id']){
                $this->Flash->error('Training Site module has been disabled. Please contact your tenant.');
                 return null;
               }
              $this->Cookie->write('loginAction', ['controller' => 'Tenants', 'action' => 'login']);
              
              if ($user && ($user['tenant_id'] == $tenantData->id)) {
                // die('in if');
              if($user['status'] != 1){
                // pr($user);die;
                $this->Flash->error('You have been disabled by your tenant. Please contact your tenant!');
                    return null;
              }
                  $user['role']= $query = $this->Roles->find('RolesById',['role' =>$user['role_id']])->select(['name','label'])->first();
              // pr($query); die();

                  $tenantDisabled = $this->Tenants->findById($user['tenant_id'])->first();
                  // pr($query->center_name); die();
                  if($tenantDisabled->status != 1) {
                    $this->Flash->error('Your Tenant has been disabled, Please contact Super Admin');
                    return null;
                  }

                  $this->Auth->setUser($user);
                  if( !empty($query) && $query->name == 'tenant'){
                      $this->redirect(['controller' => 'tenants','action' => 'dashboard']);
                  }
                  if( !empty($query) && $query->name == 'user'){
                      $this->redirect(['controller' => 'tenants','action' => 'dashboard']);
                  }
              }elseif($user){
                // die('else');
                $this->Flash->error('You do not belong to this tenant. Please contact Superadmin!');
                $this->redirect(['controller' => 'tenants','action' => 'login']);
              }elseif(!$user){
                $this->Flash->error('Please enter correct email or password!');
                    return null;
              }
          }
      }

    public function forgotPassword(){
      
      if($this->Auth->user()){
        $this->Flash->error("UNAUTHORIZED REQUEST");
        $this->redirect(['action' => 'logout']);
      }
      // pr('here');die;
      $this->viewBuilder()->setLayout('login-admin-override');
      // $domainType = "http://$_SERVER[HTTP_HOST]";
      $url = Router::url('/', true);
          if($url == "http://localhost/classbyte/"){
            $domainType = 'cmc.classbyte.twinspark.co/tenants/login';
            // $domainType = 'http://dallas.classbyte.twinspark.co/tenants/login';
          }else{
            $domainType = "http://$_SERVER[HTTP_HOST]";
          }
      // $domainType = 'http://dallas.classbyte.twinspark.co/tenants/login';
      // $domainType = 'mi.classbyte.twinspark.co';
      $tenantData = $this->Tenants->find()
                                  ->where(['domain_type LIKE' => '%'.$domainType.'%'])
                                  ->first();
      
      if ($this->request->is('post')) {
        $email = $this->_RequestData['email'];
        $tenantUsers = $this->Tenants->TenantUsers->find('all')
                                                  ->where(['email' => $email, 'tenant_id' => $tenantData->id])
                                                  ->first();
        if(!$tenantUsers){
          return $this->Flash->error(__("This email doesn't exist for this tenant."));
        }
        $this->loadModel('TenantResetPasswordHashes');
        $hashResetPassword = $this->TenantResetPasswordHashes->find()->where(['tenant_user_id' => $tenantUsers->id])->first();
         if(empty($hashResetPassword)){
          $resetPwdHash = $this->_createResetPasswordHash($tenantUsers->id);
        }else{
          $resetPwdHash = $hashResetPassword->hash;
          $time = new Time($hashResetPassword->created);
          if(!$time->wasWithinLast(1)){
            $this->TenantResetPasswordHashes->delete($hashResetPassword);
            $resetPwdHash =$this->_createResetPasswordHash($tenantUsers->id);
          }
        }
        $url = Router::url('/', true);
        $url = $url.'tenants/resetPassword/?reset-token='.$resetPwdHash;
        $emailBody = '<p><span style="font-weight: 400;">Hi '.$tenantUsers->first_name.',<br /></span><span style="font-weight: 400;"><br /></span><span style="font-weight: 400;">We have received a request to reset your password. Please use the following link to reset your password '.$url.'.<br /></span><span style="font-weight: 400;">If you did not request this password change, you can contact us at '.$tenantData->email.'.<br /><br /></span><span style="font-weight: 400;">Thank you,</span><span style="font-weight: 400;"><br /></span><span style="font-weight: 400;">ClassByte Support Team</span></p>';

        $email = new Email('default');
        $email->setTo($tenantUsers->email)
              ->emailFormat('html')
              ->setSubject('Reset Password Link')
              ->send($emailBody);

        $this->Flash->success(__('Please check your email to verify yourself and change your password'));
        $this->redirect(['action' => 'login']);

       }
    }

    protected function _createResetPasswordHash($tenantUserId){
      
        $this->loadModel('TenantResetPasswordHashes');
        $resetPasswordrequestData = $this->TenantResetPasswordHashes->find()
                                                                    ->where(['tenant_user_id' =>$tenantUserId ])
                                                                    ->first();
        if($resetPasswordrequestData){
            return $resetPasswordrequestData->hash;
        }
        $hasher = new DefaultPasswordHasher();
        $reqData = ['tenant_user_id'=>$tenantUserId,'hash'=> $hasher->hash($tenantUserId)];
        $createPasswordhash = $this->TenantResetPasswordHashes->newEntity($reqData);
        $createPasswordhash = $this->TenantResetPasswordHashes->patchEntity($createPasswordhash,$reqData);
        if($this->TenantResetPasswordHashes->save($createPasswordhash)){
          return $createPasswordhash->hash;
      }else{
        Log::write('error','error in creating resetpassword hash for user id '.$tenantUserId);
        Log::write('error',$createPasswordhash);
      }
        return false;
    }

    public function resetPassword(){
        $this->viewBuilder()->setLayout('login-admin-override');
        $resetToken = $this->request->getQuery('reset-token');
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

          $this->loadModel('TenantResetPasswordHashes');
          $checkExistPasswordHash = $this->TenantResetPasswordHashes->find()->where(['hash'=>$uuid])->first();

          if(!$checkExistPasswordHash){
            $this->Flash->error(__('INVALID RESET PASSWORD'));
            $this->redirect(['action' => 'login']);
            return;
          }
           $user = $this->Tenants->TenantUsers->findById($checkExistPasswordHash->tenant_user_id )->first();
           if(!$user){
            $this->Flash->error(__("User Doesn't exist."));
            $this->redirect(['action' => 'login']);
            return;
           }
           $reqData = ['password'=>$password];
           $hasher = new DefaultPasswordHasher();

           $user = $this->Tenants->TenantUsers->patchEntity($user, $reqData);
            if($this->Tenants->TenantUsers->save($user)){
                $data =array();
                $data['status']=true;
                $data['data']['id']=$user->id;

                $this->TenantResetPasswordHashes->delete($checkExistPasswordHash);

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
        $this->Auth->logout();
        return $this->redirect(['controller' => 'tenants','action' => 'login']);
    }

    public function dashboard(){
      $tenant_id = $this->Auth->user('tenant_id');
      $user = $this->Auth->user();
      $this->loadModel("Instructors");
      $this->loadModel("Students");
      $this->loadModel("Courses");
      $this->loadModel("Payments");
      $this->loadModel("CourseStudents");
      $this->loadModel('InstructorQualifications');
      $this->loadComponent('DashboardRefresh');
      $todayDate = FrozenTime::now();
      $oneMonthStudents = $this->Students->find()->where(['created >=' => $todayDate->subDays(30),'tenant_id' => $tenant_id])->count();
      // pr($oneMonthStudents);die;
      $twoMonthStudents = $this->Students->find()->where(['created <=' => $todayDate->subDays(30),'created >=' => $todayDate->subDays(60),'tenant_id' => $tenant_id])->count();
      $oneMonthCourses = $this->Courses->find()->where(['created >=' => $todayDate->subDays(30),'tenant_id' => $tenant_id, 'status' => 'publish'])->count();
      $twoMonthCourses = $this->Courses->find()->where(['created <=' => $todayDate->subDays(30),'created >=' => $todayDate->subDays(60),'tenant_id' => $tenant_id,'status' => 'publish','OR' => [ ['created <=' => $todayDate->subDays(30),'created >=' => $todayDate->subDays(60),'tenant_id' => $tenant_id,'status' => 'confirmed'] ] ])->count();
      $query = $this->Payments->find()->contain(['Transactions']);
      $profitOneMonth = $query->select(['sum' => $query->func()->sum("Transactions.amount")])->where(['tenant_id' => $tenant_id, 'Payments.created >=' => $todayDate->subDays(30)])->extract('sum')->first();
      $profitTwoMonth = $query->select(['sum' => $query->func()->sum("Transactions.amount")])->where(['tenant_id' => $tenant_id, 'Payments.created >=' => $todayDate->subDays(30),'OR' => [ ['Payments.created <=' => $todayDate->subDays(30),'Payments.created >=' => $todayDate->subDays(60),'tenant_id' => $tenant_id] ] ])->extract('sum')->first();
      $fetchData['expiringThreeMonths'] = $this->DashboardRefresh->fetchData($user,$tenant_id,'expiringThreeMonths');
      $fetchData['expiringToday'] = $this->DashboardRefresh->fetchData($user,$tenant_id,'expiringToday');
      $fetchData['pendingQualifications'] = $this->DashboardRefresh->fetchData($user,$tenant_id,'pendingQualifications');
      $fetchData['courseDates'] = $this->DashboardRefresh->fetchData($user,$tenant_id,'courseDates');
      $fetchData['courseInstructors'] = $this->DashboardRefresh->fetchData($user,$tenant_id,'courseInstructors');
      $fetchData['incompleteCheckout'] = $this->DashboardRefresh->fetchData($user,$tenant_id,'incompleteCheckout');
      if(isset($fetchData['expiringThreeMonths']['expiringThreeMonths'])){
        $expiringThreeMonths = $fetchData['expiringThreeMonths']['expiringThreeMonths'];
        $expiringThreeMonths = $this->_unsetKey($expiringThreeMonths);
        
      }
      if(isset($fetchData['expiringToday']['expiringToday'])){
        $expiringToday = $fetchData['expiringToday']['expiringToday'];
        $expiringToday = $this->_unsetKey($expiringToday);
        
      }
      if(isset($fetchData['pendingQualifications']['pendingQualifications'])){
        $pendingQualifications = $fetchData['pendingQualifications']['pendingQualifications'];
        $pendingQualifications = $this->_unsetKey($pendingQualifications);
        
      }
      if(isset($fetchData['courseDates'])){
        $courseDates = $fetchData['courseDates']['courseDates'];
        $location = $fetchData['courseDates']['location'];
        $courseDates = $this->_unsetKey($courseDates);
        
      }
      if(isset($fetchData['courseInstructors'])){
        $courseInstructors = $fetchData['courseInstructors']['courseInstructors'];
        $courses = $fetchData['courseInstructors']['courses'];
        $instructorsData = $fetchData['courseInstructors']['instructorsData'];
        $courseInstructors = $this->_unsetKey($courseInstructors);
      }
      if(isset($fetchData['incompleteCheckout'])){
        $incompleteCheckout = $fetchData['incompleteCheckout']['incompleteCheckout'];
        $count = $fetchData['incompleteCheckout']['count'];
        $incompleteCheckout = $this->_unsetKey($incompleteCheckout);
      }

      $tenantData = $this->Tenants->find()
                              ->where(['id' => $user['tenant_id']])
                              ->first();
                              // pr($tenantData);die;

     $this->set(compact('count','instructorsData','courses','location','courseDates','location','courses','courseInstructors','incompleteCheckout','pendingQualifications','oneMonthStudents', 'twoMonthStudents','loggedInUser','oneMonthCourses','twoMonthCourses','profitOneMonth','profitTwoMonth','expiringThreeMonths','todayDate','expiringToday','tenantData'));
    }
    private function _unsetKey($data){
      foreach ($data as $key => $value) {
        if(empty($value)){
          unset($data[$key]);
        }
      }
      return $data;
      // unset($courseDates['expiringToday']);
    }

    // function return course clashes on same date
    private function _clashCourseData($courseLists){
      // pr('haha');pr($courseLists);die;
        $data = [];
        for ($i=0; $i < count($courseLists) - 1 ; $i++) {

          if($courseLists[$i]->end_time > $courseLists[$i + 1]->start_time){
              if(!isset($data[$courseLists[$i]->course_id])){
                $data[$courseLists[$i]->course_id] = $courseLists[$i];
              }
              
              $data[$courseLists[$i+1]->course_id] = $courseLists[$i + 1];
              // pr($data);die;
          }
        }
        // pr($data);die;
       return $data;      
      $profitTwoMonth = $query->select(['sum' => $query->func()->sum("Transactions.amount")])->where(['tenant_id' => $tenant_id, 'Payments.created >=' => $todayDate->subDays(30)])->orWhere(['Payments.created <=' => $todayDate->subDays(30),'Payments.created >=' => $todayDate->subDays(60),'tenant_id' => $tenant_id])->extract('sum')->first();
      // pr($profitTwoMonth);die;
      $incompleteCheckout = $this->Courses->findByTenantId($tenant_id)
                                          ->
     
     $this->set(compact('oneMonthStudents', 'twoMonthStudents','loggedInUser','oneMonthCourses','twoMonthCourses','profitOneMonth','profitTwoMonth'));
    }

    public function updateStatus($id = null)
    {

        $query = $this->request->getAttribute('params')['pass'];
        $tenant_id = $query[0];
        $this->request->allowMethod(['post']);
        $tenant = $this->Tenants->get($tenant_id);
        if($tenant){
          $status = $query[1];
          if($status == 1){
            $status = 0;
          }else if($status == 0){
            $status = 1;
          }
          $tenantData['status'] = $status;
          $tenant = $this->Tenants->patchEntity($tenant, $tenantData);
          $tenant = $this->Tenants->save($tenant);
            if($tenant){
              $this->Flash->success(__('Status updated'));
            }else{
              $this->Flash->error(__('Please, try again.'));
            }
        }
        return $this->redirect(['action' => 'index']);
    }
}
