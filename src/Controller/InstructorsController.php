<?php
namespace App\Controller;

use Cake\I18n\Time;
use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Http\Exception\NotFoundException;
use Cake\Mailer\Email;
use Cake\Http\Session;
use Cake\Log\Log;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Event\Event;
use Cake\Utility\Text;

/**
 * Instructors Controller
 *
 * @property \App\Model\Table\InstructorsTable $Instructors
 *
 * @method \App\Model\Entity\Instructor[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InstructorsController extends AppController
{

    public function initialize()
    {
        $this->_RequestData = $this->request->getData();
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Cookie');
        $this->Auth->allow(['logout','login','register','notFound','dashboard','forgotPassword','resetPassword','restore','verifyEmail','updateStatus']);

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
        if (in_array($action, ['index', 'view','add','edit','delete','login','viewCourse']) && $user['role']->name === self::SUPER_ADMIN_LABEL) {
        // pr($action); die('in super admin');
            return true;
        }

        else if (in_array($action, ['index', 'view','add','edit','delete','login','forgotPassword','viewCourse','roster','notes','courseHistory','printRoster','updateStatus','restore']) && $user['role']->name === self::TENANT_LABEL) {
        // pr($action); die('in tenant admin');
            return true;
        }
         else if (in_array($action, ['index', 'view','add','edit','courseHistory','delete','login','forgotPassword','viewCourse','roster','notes','printRoster','updateStatus']) && $user['role']->name === self::INSTRUCTOR_LABEL) {
        // pr($action); die('in tenant admin');
            return true;
        }
        // All other actions require an id.
        /*if (empty($this->request->getParam('pass.0'))) {
            return $this->redirect(['controller' => 'tenants','action' => 'index']);
        }*/
        return parent::isAuthorized($user);
    }
   
    public function index()
    {

      $loggedInUser = $this->Auth->user();
      if($loggedInUser['role']->name == self::TENANT_LABEL){
        $instructors = $this->Instructors->find('withTrashed')
                                            // ->withTrashed()
                                            ->where(['Instructors.tenant_id ='=>$loggedInUser['tenant_id']])
                                            // ->contain(['InstructorQualifications','InstructorApplications','InstructorInsuranceForms'])
                                            ->all()
                                            ->toArray();
                                            // pr($instructors);die;

      }else if($loggedInUser['role']->name == self::SUPER_ADMIN_LABEL){
        $instructors = $this->Instructors
                                    ->find()
                                    ->contain(['Tenants', 'TrainingSites', 'Roles'])
                                    ->all();
      }
      else if($loggedInUser['role']->name == self::INSTRUCTOR_LABEL){
        $instructors = $this->Instructors->find()
                                        ->where(['Instructors.id'=>$loggedInUser['id']]) 
                                        ->contain(['Tenants', 'TrainingSites', 'Roles','InstructorQualifications','InstructorApplications','InstructorInsuranceForms'])
                                        ->all()
                                        ->toArray();

      }
      if($loggedInUser['role']->name == self::TENANT_LABEL && $loggedInUser['role']->label == 'TRAINING SITE OWNER'){
        $instructors = $this->Instructors->find('withTrashed')
                                            // ->withTrashed()
                                            ->where(['Instructors.training_site_id ='=>$loggedInUser['training_site_id']])
                                            ->contain(['Tenants', 'TrainingSites', 'Roles','InstructorQualifications','InstructorApplications','InstructorInsuranceForms'])
                                            ->all()
                                            ->toArray();
                                            // pr($instructors);die;

      }
      $this->set('loggedInUser', $loggedInUser);
      $this->set(compact('instructors'));
    }

    /**
     * View method
     *
     * @param string|null $id Instructor id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $instructor = $this->Instructors->get($id, [
            'contain' => ['Tenants', 'TrainingSites', 'Roles']
        ]);

        $this->set('instructor', $instructor);
    }

    /**
     * Add method..
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $instructor = $this->Instructors->newEntity();
        $loggedInUser = $this->Auth->user();
        if ($this->request->is('post')) {
            $data = $this->_RequestData;
            $data['role_id'] = 4;
            $data['tenant_id'] = $loggedInUser['tenant_id'];
            if($loggedInUser['role']->name == 'tenant' && $loggedInUser['role']->label == 'TRAINING SITE OWNER'){
              $data['training_site_id'] = $loggedInUser['training_site_id'];
            }
            $data['token'] = Text::uuid();
            $instructor = $this->Instructors->patchEntity($instructor, $data);
          // pr($data);die;
            if ($this->Instructors->save($instructor)) {

              // pr($instructor);die;

                $this->AccountCreationNotificationInstructor($instructor,$data);

                $this->Flash->success(__('The instructor has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The instructor could not be saved. Please, try again.'));
        }
        if($loggedInUser['role']->name == self::TENANT_LABEL){
            $tenants = $this->Instructors->Tenants->find()
                                                ->where(['id'=>$loggedInUser['tenant_id']])
                                                ->all()
                                                ->combine('id','center_name')
                                                ->toArray();

        }else {
            $tenants = $this->Instructors->Tenants->find()->all()->combine('id','center_name')->toArray();
        }
        $this->set('loggedInUser', $loggedInUser);

        // $tenants = $this->Instructors->Tenants->find()->all()->combine('id','center_name')->toArray();
        // $trainingSites = $this->Instructors->TrainingSites->find('list', ['limit' => 200]);
        $trainingSites = $this->Instructors->TrainingSites->find()
                                                ->contain('tenants','TrainingSites','Instructors')
                                                ->where(['TrainingSites.tenant_id'=>$loggedInUser['tenant_id']])
                                                ->all()
                                                ->combine('id','name')
                                                ->toArray();
                                                
        $roles = $this->Instructors->Roles->find('list', ['limit' => 200]);
        $this->set(compact('instructor', 'tenants', 'trainingSites', 'roles'));
    }

    public function register(){
      $this->viewBuilder()->setLayout('popup-view');
      $this->loadModel('Tenants');
      $loggedInUser = $this->Auth->user();
      // pr($loggedInUser);die;
      $url = Router::url('/', true);
          if($url == "http://localhost/classbyte/"){
            $domainType = 'cmc.classbyte.twinspark.co/tenants/login';
          }else{
            $domainType = "http://$_SERVER[HTTP_HOST]";
          }
          $tenantData = $this->Tenants->find()->where(['domain_type LIKE' => '%'.$domainType.'%'])->contain(['TrainingSites'])->first();
          // pr($tenantData);die;
          if(isset($tenantData) && !empty($tenantData)){
              $this->set(compact('tenantData'));
          }else{
             throw new NotFoundException(__('Page Not Found'));
          }
      $this->loadModel('TrainingSites');
      // $tenantData = $this->Tenants->find()->where(['domain_type LIKE' => "%".$host."%"])->contain(['TrainingSites'])->first();
      if(isset($tenantData) && !empty($tenantData)){
          $instructor = $this->Instructors->newEntity();
          $host = $this->request->host();
          // pr($host);die;
            if ($this->request->is('post')) {
              $data = $this->_RequestData;

              $data['token'] = Text::uuid();
              $data['role_id'] = 4;
              $data['tenant_id'] = $tenantData->id;
              $data['status'] = 1;
              $instructor = $this->Instructors->patchEntity($instructor, $data);
              $trainingSite = $this->TrainingSites->findById($data['training_site_id'])
                                                    ->first();
              if ($this->Instructors->save($instructor)) {
                 $url = Router::url('/', true);
                 $emailData = [
                'name' => $data['first_name']." ".$data['last_name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'confirm_url' => $url."instructors/verify-email/".$instructor->token,
                'training_site_name' => $trainingSite->name,
                'training_site_phone' => $trainingSite->contact_phone,
                'server_name' => $url."/instructors/login/",
                'training_site_email'=> $trainingSite->contact_email,
                'username' => $data['email']
               ];
                $event = new Event('account_confirmation_instructor', $this, [
               'hashData' => $emailData,
               'tenant_id' => $data['tenant_id']
                ]);
                $this->getEventManager()->dispatch($event);

                  $this->Flash->success(__('The instructor has been saved. Please verify your email through your email account.'));
                  return $this->redirect(['action' => 'register']);
              }
              // pr('hahah');die;

              $this->Flash->error(__('The instructor could not be saved. Please, try again.'));
          }
          $trainingSites = $this->TrainingSites->findByTenantId($tenantData->id)
                                               ->all()
                                               ->combine('id','name')
                                               ->toArray();
          $this->set(compact('tenantData','instructor','trainingSites'));
      }else{
         throw new NotFoundException(__('You are accessing some wrong page, Please contact admin'));
      }

    }

    public function verifyEmail($token = null){
      if($token){
        $instructor = $this->Instructors->find()
                                        ->where(['Instructors.token' => $token])
                                        ->first();                                
        if(!$instructor->is_verified){
          $data  = ['is_verified' => 1] ;
          $instructor = $this->Instructors->patchEntity($instructor, $data);
          if ($this->Instructors->save($instructor)) {
              $this->Flash->success(__('Email has been verified successfully!'));
              return $this->redirect(['controller'=>'Instructors','action' => 'login']);
          }else{
              $this->Flash->error(__('The email could not be verfied. Please, try again.')); 
          }
        }else{
            $this->Flash->success(__('Email Already verified'));
            return $this->redirect(['controller'=>'Instructors','action' => 'login']);
        }

      }else{
        $this->viewBuilder()->setLayout('login-admin-override');
         if ($this->request->is('post')) {
            $data = $this->request->getData();
            $email = $data['email'];
            // pr($email);die;
            $instructor = $this->Instructors->find()
                                            ->where(['Instructors.email' => $email])
                                            ->first();
                                            // pr($instructor);die;
            if(!empty($instructor) && isset($instructor)){

            $token = $instructor->token;

           // pr($token);
            $url = Router::url('/', true);
            $url = $url."instructors/verify-email/".$token;
            // pr($data);
            $emailBody = '<p><span style="font-weight: 400;">Hi '.$instructor->first_name.',<br /><br /></span><span style="font-weight: 400;">Please confirm this is your correct email address. Clicking on this link will allow you to successfully sign in '.$url.'.<br /><br /></span><span style="font-weight: 400;">Thank you,<br /></span><span style="font-weight: 400;">ClassByte Support Team</span></p>';

            $email = new Email('default');
            $email->setTo($instructor->email)
                  ->emailFormat('html')
                  ->setSubject('Verify Email')
                  ->send('To verify your email please click in the link: '.$url);
              // pr($email);die;

        $this->Flash->success(__('An email with a link has been sent to you. Click on the link to verify.'));
          return $this->redirect(['controller'=>'Instructors','action' => 'login']);
      }else{
        $this->Flash->error(__('Invalid email provided'));
      }

       }
      }
    }

    /**
     * CourseHistory method
     *
     * @param string|null $id Instructor id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function courseHistory($id = null){
      $loggedInUser = $this->Auth->user();
      $this->loadModel('CourseInstructors');
      $history = $this->CourseInstructors->find()
                                     ->where(['instructor_id' => $id])
                                     ->contain(['Courses'=> function($q) {
                                                              return $q->where(['Courses.status IN' => 'publish']);}
                                                ,'Courses.Locations','Courses.CourseDates','Courses.CourseTypes'])
                                     ->all()
                                     ->toArray();
                                     // pr($history); die();
      $this->set(compact('history'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Instructor id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
         if(!$id){
            $id = $this->Auth->user('id');
        }
        $instructor = $this->Instructors->get($id, [
            'contain' => []
        ]);
        // pr($instructor); die();

        $oldImageName = $instructor->image_name;
        $path = Configure::read('ImageUpload.unlinkPathForInstructorsImages');
        if ($this->request->is(['patch', 'post', 'put'])) {
            $instructor = $this->Instructors->patchEntity($instructor, $this->_RequestData);
            if ($this->Instructors->save($instructor)) {

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
                $this->Flash->success(__('The instructor has been saved.'));

                return $this->redirect(['action' => 'edit']);
            }
            $this->Flash->error(__('The instructor could not be saved. Please, try again.'));
        }
        $loggedInUser = $this->Auth->user();
        if($loggedInUser['role']->name == self::TENANT_LABEL){
            $tenants = $this->Instructors->Tenants->find()
                                                ->where(['id'=>$loggedInUser['tenant_id']])
                                                ->all()
                                                ->combine('id','center_name')
                                                ->toArray();
            
        }else {
            $tenants = $this->Instructors->Tenants->find()->all()->combine('id','center_name')->toArray();
        }
        $this->set('loggedInUser', $loggedInUser);

        // $tenants = $this->Instructors->Tenants->find()->all()->combine('id','center_name')->toArray();
        // $trainingSites = $this->Instructors->TrainingSites->find('list', ['limit' => 200]);
        $trainingSites = $this->Instructors->TrainingSites->find()
                                                ->contain('tenants','TrainingSites','Instructors')
                                                ->where(['TrainingSites.tenant_id'=>$loggedInUser['tenant_id']])
                                                ->all()
                                                ->combine('id','name')
                                                ->toArray();
        $roles = $this->Instructors->Roles->find('list', ['limit' => 200]);
        $this->set(compact('instructor', 'tenants', 'trainingSites', 'roles','loggedInUser'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Instructor id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {   

        $this->request->allowMethod(['post', 'delete','get']);
        $instructor = $this->Instructors->get($id);
        if ($this->Instructors->delete($instructor)) {
            $this->Flash->success(__('The instructor has been deleted.'));
        } else {
            $this->Flash->error(__('The instructor could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * restore method
     *
     * @param string|null $id Instructor id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function restore($id = null)
    {
      // pr($id); die();
         $this->request->allowMethod(['post', 'put']);
        //must add 'withTrashed' to find the deleted data
        $instructor = $this->Instructors->find('withTrashed')->where(['id =' => $id])->first();
        // pr($instructor);die;
        if ($this->Instructors->restoreTrash($instructor)) {
            $this->Flash->success(__('Instructor has been restored.'));
        } else {
            $this->Flash->error(__('Instructor could not be restored. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);

    }
    //  public function notFound(){
    //   $this->viewBuilder()->setLayout('popup-view');
    // }


    public function login(){
        // die('sss');
 
        $this->viewBuilder()->setLayout('login-admin-override');


            $this->loadModel('Roles');
            $this->loadModel('Tenants');
            $url = Router::url('/', true);
            if($url == "http://localhost/classbyte/"){
            $domainType = 'cmc.classbyte.twinspark.co/tenants/login';  
            } else {
            $domainType = "http://$_SERVER[HTTP_HOST]";
            }

            $tenantData = $this->Tenants->find()
                                        ->where(['domain_type LIKE' => '%'.$domainType.'%'])
                                        ->first();

            if(isset($tenantData) && !empty($tenantData)){
                $this->set(compact('tenantData'));
            }else{
            $this->viewBuilder()->setTemplate('not-found');
            }
        if ($this->request->is('post')) {
            // pr($tenantData);die();
            $user = $this->Auth->identify();
            $this->Cookie->write('loginAction', ['controller' => 'Instructors', 'action' => 'login']);
            
          // pr($user); die();
              // pr($user['tenant_id']); die();
            

              if ($user && ($user['tenant_id'] == $tenantData->id)) {
               
                  $user['role']= $query = $this->Roles->find('RolesById',['role' =>$user['role_id']])->select(['name','label'])->first();

               // if($domainType && $domainType->'tenant_id')   

               $tenantDisabled = $this->Tenants->findById($user['tenant_id'])->first();
                  // pr($query->center_name); die();
               // pr($tenantDisabled);die();
                  if($tenantDisabled->status != 1) {
                    $this->Flash->error('This Tenant has been disabled, Please contact your Tenant for details');
                    return null;
                  }

                  // if instructor belongs to that tenant and check the status of instructor

              $instructorDisabled = $this->Instructors->findById($user['id'])->first();
              // pr($user['id']);die();
              // pr($user);die();
                  if($instructorDisabled->status != 1){
                    $this->Flash->error('You have been disabled by your Tenant.Please contact your Tenant for details');
                    return null;
                  } 

                  $url = $this->request->host();
                  if($instructorDisabled->is_verified != 1){
                    $this->Flash->error('Your email has not yet been verified. click <a href="verify-email">here</a> to verify your email.', ['escape' => false]);

                    return null;
                  }   

                  // pr('here');die;

                $this->Auth->setUser($user);
                if(!empty($query) && $query->name == 'instructor'){
                  $this-> redirect(['controller'=> 'instructors' , 'action' => 'dashboard']);
                } else {
                  // pr('here');die;
                  $this->Flash->error('Please enter correct email or password!');
                  $this->redirect(['controller' => 'instructors' , 'action' => 'login']);
                }

              }elseif($user){
                $this->Flash->error('You do not belong to this tenant. Please contact Superadmin!');
                    return null;

              }elseif(!$user){
                // pr('else');die('else');
                $this->Flash->error('Please enter correct email or password!');
                $this->redirect(['controller' => 'Instructors','action' => 'login']);
              }    

        //     if ($user) {
        //         $user['role']= $query = $this->Roles->find('RolesById',['role' =>$user['role_id']])->select(['name','label'])->first();
        //         $this->Auth->setUser($user);

        //     if( !empty($query) && $query->name == 'super_admin'){
        //         $this->redirect(['controller' => 'instructors',
        //           'action' => 'index'
        //           ]);
        //     }
        //     else if( !empty($query) && $query->name == 'tenant'){
        //         $this->redirect(['controller' => 'instructors',
        //           'action' => 'index'
        //           ]);
        //       }
        //     }else{
        //       $this->Flash->error('Unable to identify you.');
        //       $this->redirect(['controller' => 'instructors','action' => 'login']);
        //     }
        }
    }

     public function forgotPassword(){
      if($this->Auth->user()){
        $this->Flash->error("UNAUTHORIZED REQUEST");
        $this->redirect(['action' => 'logout']);
      }
      $this->viewBuilder()->setLayout('login-admin-override');
      // $domainType = "http://$_SERVER[HTTP_HOST]";
       // $domainType = 'cmc.classbyte.twinspark.co/tenants/login';
      // $domainType = 'http://dallas.classbyte.twinspark.co/tenants/login';
      $url = Router::url('/', true);
          if($url == "http://localhost/classbyte/"){
            $domainType = 'cmc.classbyte.twinspark.co/tenants/login';
            // $domainType = 'http://dallas.classbyte.twinspark.co/tenants/login';
          }else{
            $domainType = "http://$_SERVER[HTTP_HOST]";
          }
          
      if ($this->request->is('post')) {
        $email = $this->_RequestData['email'];
        $instructors = $this->Instructors->find()
                                        ->where(['Instructors.email' => $email])
                                        ->contain(['Tenants' => function($q) use($domainType){
                                          return $q->where(['domain_type LIKE' => '%'.$domainType.'%']);
                                        }])
                                        ->first(); 
        if(!$instructors){
          return $this->Flash->error(__("This email doesn't exist for this instructor."));
        }
        $this->loadModel('InstructorResetPasswordHashes');
        $hashResetPassword = $this->InstructorResetPasswordHashes->find()->where(['instructor_id' => $instructors->id])->first();
         if(empty($hashResetPassword)){
          $resetPwdHash = $this->_createResetPasswordHash($instructors->id);
        }else{
          $resetPwdHash = $hashResetPassword->hash;
          $time = new Time($hashResetPassword->created);
          if(!$time->wasWithinLast(1)){
            $this->InstructorResetPasswordHashes->delete($hashResetPassword);
            $resetPwdHash =$this->_createResetPasswordHash($instructors->id);
          }
        }
        $url = Router::url('/', true);
        $url = $url.'instructors/resetPassword/?reset-token='.$resetPwdHash;
        $emailBody = '<p><span style="font-weight: 400;">Hi '.$instructors->first_name.',<br /></span><span style="font-weight: 400;"><br /></span><span style="font-weight: 400;">We have received a request to reset your password. Please use the following link to reset your password '.$url.'.<br /></span><span style="font-weight: 400;">If you did not request this password change, you can contact us at '.$instructors->tenant->email.'.<br /><br /></span><span style="font-weight: 400;">Thank you,</span><span style="font-weight: 400;"><br /></span><span style="font-weight: 400;">ClassByte Support Team</span></p>';
        $email = new Email('default');
        
        $email->setTo($instructors->email)
              ->emailFormat('html')
              ->setSubject('Reset Password Link')
              ->send($emailBody);

        $this->Flash->success(__('Please check your email to verify yourself and change your password'));
        $this->redirect(['action' => 'login']);

       }
    }

    protected function _createResetPasswordHash($instructorId){
      
        $this->loadModel('InstructorResetPasswordHashes');
        $resetPasswordrequestData = $this->InstructorResetPasswordHashes->find()
                                                                    ->where(['instructor_id' =>$instructorId ])
                                                                    ->first();
        if($resetPasswordrequestData){
            return $resetPasswordrequestData->hash;
        }
        $hasher = new DefaultPasswordHasher();
        $reqData = ['instructor_id'=>$instructorId,'hash'=> $hasher->hash($instructorId)];
        $createPasswordhash = $this->InstructorResetPasswordHashes->newEntity($reqData);
        $createPasswordhash = $this->InstructorResetPasswordHashes->patchEntity($createPasswordhash,$reqData);
        if($this->InstructorResetPasswordHashes->save($createPasswordhash)){
          return $createPasswordhash->hash;
      }else{
        Log::write('error','error in creating resetpassword hash for user id '.$instructorId);
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

          $this->loadModel('InstructorResetPasswordHashes');
          $checkExistPasswordHash = $this->InstructorResetPasswordHashes->find()->where(['hash'=>$uuid])->first();

          if(!$checkExistPasswordHash){
            $this->Flash->error(__('INVALID RESET PASSWORD'));
            $this->redirect(['action' => 'login']);
            return;
          }
           $user = $this->Instructors->findById($checkExistPasswordHash->instructor_id )->first();
           if(!$user){
            $this->Flash->error(__("User Doesn't exist."));
            $this->redirect(['action' => 'login']);
            return;
           }
           $reqData = ['password'=>$password];
           $hasher = new DefaultPasswordHasher();

           $user = $this->Instructors->patchEntity($user, $reqData);
            if($this->Instructors->save($user)){
                $data =array();
                $data['status']=true;
                $data['data']['id']=$user->id;
                $this->Flash->success("Password reset successfully");

                $this->InstructorResetPasswordHashes->delete($checkExistPasswordHash);
                
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
        return $this->redirect(['controller' => 'instructors','action' => 'login']);
    }

    public function dashboard(){
      $this->loadModel('Courses');
      $this->loadModel('CourseInstructors');
      $loggedInUser = $this->Auth->user();
      $course_instructor = $this->CourseInstructors->find()
                                   ->contain(['Courses.Tenants','Courses','Courses.Locations','Courses.CourseTypes','Courses.CourseDates'])
                                   ->where(['CourseInstructors.instructor_id'=>$loggedInUser['id']])
                                   ->order(['Courses.created' => 'DESC'])
                                   ->all()
                                   ->toArray();

     //\
      // pr($course_instructor);die;


      $instructors = $this->Instructors->find()
                                            ->where(['id ='=>$loggedInUser['id']])
                                            ->contain(['InstructorQualifications','InstructorApplications','InstructorInsuranceForms'])
                                            ->first()
                                            ->toArray();
                                            // pr($instructors);die;

      $this->set(compact('course_instructor','loggedInUser','instructors'));

    }

    public function viewCourse($id = null)
    {

        $this->loadmodel('Tenants');
        $this->loadmodel('Courses');
        $this->loadmodel('CourseDates');
        $this->loadModel('TrainingSites');
        $this->loadModel('CourseStudents');
        $loggedInUser = $this->Auth->user();
        // pr($loggedInUser);die();
        // pr($id);die();
        $this->viewBuilder()->setLayout('default-override');
        $course = $this->Courses->get($id, [
            'contain' => ['Tenants', 'Locations', 'TrainingSites', 'CorporateClients', 'CourseTypeCategories', 'CourseTypes', 'CourseAddons', 'CourseDates', 'CourseDisplayTypes','CourseStudents.Students','CourseInstructors.instructors']
        ]);
        // pr($course);die();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            $course = $this->Courses->patchEntity($course,$data );
            if ($this->Courses->save($course)) {
                $this->Flash->success(__('The Note has been saved.'));

                return $this->redirect(['action' => 'viewCourse',$id]);
            }
            $this->Flash->error(__('The Note could not be saved. Please, try again.'));
        }
        $domain = $course['tenant']['domain_type'];
        $url = $this->Tenants
                            ->find()
                            ->select('domain_type')
                            ->where(['id'=>$loggedInUser['tenant_id']])
                            ->first();
                            // pr($url['domain_type']);die;
        $courseDates =  $this->CourseDates->findByCourseId($course->id)
                                          ->all()
                                          ->toArray();
        $courseDate =  $courseDates[0];
        // pr($courseDate);die();
        $trainingSites = $this->Courses->findById($id)
                            ->contain('TrainingSites')
                            ->first();
        // pr($ts);die();                    

        // $trainingSites = $this->TrainingSites->find()
                                             // ->where(['id'=>$course['training_site_id']] )
                                             // ->all()
                                             // ->toArray();
        // pr($trainingSites);die();                                     
        if($loggedInUser['role_id'] == 3){
        $CourseStudents = $this->CourseStudents->findByCourseId($course->id)
                                               // ->contain('Courses')
                                               // ->where(['Courses.tenant_id' =>$loggedInUser['corporate_client']['tenant_id']])
                                               ->all()
                                               ->toArray();
        } else {

        $CourseStudents = $this->CourseStudents->findByCourseId($course->id)
                                               // ->contain('Courses')
                                               // ->where(['Courses.tenant_id' =>$loggedInUser['tenant_id']])
                                               ->all()
                                               ->toArray(); 
        // pr('in else');                                    
        } 
        // pr($CourseStudents);die();
        // $CourseStudents                                   
        // $trainingSite = $trainingSites[0];
        // pr($trainingSites);die();
        $temp = $url['domain_type'];
        $url=explode("/",$temp);
        $urldomain=$url['0'];

        $this->set('CourseStudents',$CourseStudents);
        $this->set('loggedInUser', $loggedInUser);
        $this->set('course', $course);
        $this->set('courseDate',$courseDate);
        $this->set('trainingSites',$trainingSites);
        $this->set(compact('urldomain'));
    }

    public function updateStatus($id = null)
    {

        $query = $this->request->getAttribute('params')['pass'];
        $instructor_id = $query[0];
        $this->request->allowMethod(['post','get']);
        $instructor = $this->Instructors->get($instructor_id);
        if($instructor){
          $status = $query[1];
          if($status == 1){
            $status = 0;
          }else if($status == 0){
            $status = 1;
          }
          $instructor['status'] = $status;
          // $instructor = $this->Instructors->patchEntity($instructor);
          $instructor = $this->Instructors->save($instructor);
          // pr($status);die();
            if($instructor){
              $this->Flash->success(__('Status updated'));
            }else{
              $this->Flash->error(__('Please, try again.'));
            }
        }
        return $this->redirect(['action' => 'index']);
    }
     public function AccountCreationNotificationInstructor($instructor,$data){

      $this->loadModel('TrainingSites');
      $trainingSiteData = $this->TrainingSites->findById($data['training_site_id'])->first();
      $url = Router::url('/', true);
      $emailData = [ 'first_name' => $data['first_name'],
                      'last_name' => $data['last_name'],
                      'email' => $data['email'],
                      'training_site_name' => $trainingSiteData->name,
                      'confirm_url' => $url."instructors/verify-email/".$instructor->token,
                      'server_name' =>  $url."/instructors/login/",
                      'user_name' => $data['email'],
                      'user_password' => $data['password'],
                      'training_site_phone' => $trainingSiteData->contact_phone,
                      'training_site_email' => $trainingSiteData->contact_email
                    ];
      $event = new Event('account_creation_notification_instructor', $this, [
             'hashData' => $emailData,
             'tenant_id' => $data['tenant_id']
        ]);
        $this->getEventManager()->dispatch($event);
      // pr($data);pr($trainingSiteData);die;

     }
}
