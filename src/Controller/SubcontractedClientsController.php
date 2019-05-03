<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Router;
/**
 * SubcontractedClients Controller
 *
 * @property \App\Model\Table\SubcontractedClientsTable $SubcontractedClients
 *
 * @method \App\Model\Entity\SubcontractedClient[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SubcontractedClientsController extends AppController
{

    public function initialize()
    {
        $this->_RequestData = $this->request->getData();
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->Auth->allow(['corporate']);
    }

    public function isAuthorized($user)
    {
        // pr($user['role']->name); die('ss');
        $action = $this->request->getParam('action');
        // pr($action); die();

        // The add and index actions are always allowed.
        if (in_array($action, ['index', 'view','add','edit','delete']) && $user['role']->name === self::SUPER_ADMIN_LABEL) {
        // pr($action); die('in super admin');
            return true;
        }
        else if (in_array($action, ['index', 'view','add','edit','delete']) && $user['role']->name === self::TENANT_LABEL) {
        // pr($action); die('in tenant admin');
            return true;
        }
        else if (in_array($action, ['index', 'view','add','edit','delete']) && $user['role']->name === self::CLIENT_LABEL) {
        // pr($action); die('in tenant admin');
            return true;
        }
        // All other actions require an id.
        /*if (empty($this->request->getParam('pass.0'))) {
            return $this->redirect(['controller' => 'tenants','action' => 'index']);
        }*/
        return parent::isAuthorized($user);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $loggedInUser = $this->Auth->user();
        if($loggedInUser['role']->name == self::CLIENT_LABEL){
        $subcontractedClients = $this->SubcontractedClients->find()
                                                           ->matching('CorporateClients', function($q) use($loggedInUser){
                                                            return $q->where(['tenant_id' => $loggedInUser['corporate_client']['tenant_id']]);
                                                           })
                                                           ->contain(['TrainingSites', 'CorporateClients'])
                                                           ->all();
        }if($loggedInUser['role']->name == self::TENANT_LABEL){
        $subcontractedClients = $this->SubcontractedClients->find()
                                                           ->matching('CorporateClients', function($q) use($loggedInUser){
                                                            return $q->where(['CorporateClients.tenant_id' => $loggedInUser['tenant_id']]);
                                                           })
                                                           ->contain(['TrainingSites', 'CorporateClients'])
                                                           ->all();
        } else {
        $subcontractedClients = $this->SubcontractedClients->find()
                                                           ->matching('CorporateClients', function($q)use($loggedInUser){
                                                            return $q->where(['tenant_id' => $loggedInUser['tenant_id']]);
                                                           })
                                                           ->contain(['TrainingSites', 'CorporateClients'])->all();
        }
        if($loggedInUser['role']->name == self::TENANT_LABEL && $loggedInUser['role']->label == 'TRAINING SITE OWNER' ){
          $subcontractedClients = $this->SubcontractedClients->find()
                                                           ->matching('CorporateClients', function($q) use($loggedInUser){
                                                            return $q->where(['CorporateClients.training_site_id' => $loggedInUser['training_site_id']]);
                                                           })
                                                           ->contain(['TrainingSites', 'CorporateClients'])
                                                           ->all();
        }
        $this->set('loggedInUser', $loggedInUser);
        $this->set(compact('subcontractedClients'));
    }

    /**
     * View method
     *
     * @param string|null $id Subcontracted Client id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $subcontractedClient = $this->SubcontractedClients->get($id, [
            'contain' => ['TrainingSites', 'CorporateClients', 'Students']
        ]);

        $this->set('subcontractedClient', $subcontractedClient);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $subcontractedClient = $this->SubcontractedClients->newEntity();
        $loggedInUser = $this->Auth->user();
        // pr($loggedInUser); die();
        if ($this->request->is('post')) {
            $data = $this->_RequestData;
            // pr($data);die();

            if($loggedInUser['training_site_id'] && isset($loggedInUser['training_site_id'])){
                // pr('in here');die;
                $data['training_site_id'] = $loggedInUser['training_site_id'];
            }
            // pr($data);die;
            // pr('getData');
            // pr($this->_RequestData);die;
            // die('outside');
            $subcontractedClient = $this->SubcontractedClients->patchEntity($subcontractedClient, $data);
            // pr($subcontractedClient);die('ho gaya');
            $tenant = $this->Tenants->findById($loggedInUser['tenant_id'])->first();
            // $getTenantDomain = explode('/', $tenant->domain_type);
            $host = $this->request->host();
            $corporateUrl = $host."/subcontracted-clients/corporate"."/";
            if($data['web_page'] == 1){
                $subcontractedClient->web_url = $corporateUrl;
            }
            // pr($subcontractedClient->web_url);die;
            if ($this->SubcontractedClients->save($subcontractedClient)) {
                $this->Flash->success(__('The subcontracted client has been saved.'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The subcontracted client could not be saved. Please, try again.'));
        }
        if($loggedInUser['role']->name == self::TENANT_LABEL){
        $trainingSites = $this->SubcontractedClients->TrainingSites->find()
                                                ->where(['TrainingSites.tenant_id' => $loggedInUser['tenant_id']])
                                                ->all()
                                                ->combine('id','name')
                                                ->toArray();
                                                // pr($trainingSites); die('ss');
        $corporateClients = $this->SubcontractedClients->CorporateClients->find()
                                                ->where(['CorporateClients.tenant_id' => $loggedInUser['tenant_id']])
                                                ->all()
                                                ->combine('id','name')
                                                ->toArray();
        }else if($loggedInUser['role']->name == self::SUPER_ADMIN_LABEL)  {
            $trainingSites = $this->SubcontractedClients->TrainingSites->find()
                                                ->all()
                                                ->combine('id','name')
                                                ->toArray();
                                                // pr($trainingSites); die('ss');
        $corporateClients = $this->SubcontractedClients->CorporateClients->find()
                                                ->all()
                                                ->combine('id','name')
                                                ->toArray();
        }

       
        // pr($corporateUrl);die();
        $this->set(compact('subcontractedClient', 'trainingSites', 'corporateClients','loggedInUser'));
    }

    public function corporate($id = null ,$uid = null )
    {
     // pr($cid);
     // pr($uid); die();
        # 
    $checkSubcontractedClientExists = $this->SubcontractedClients
                                                ->findById($id)
                                                // ['domain_type LIKE' => '%'.$domainType.'%']
                                                ->where(['web_id =' =>$uid])
                                                ->first();
                                   // pr($checkSubcontractedClientExists->web_id); die();             
    if(!isset($checkSubcontractedClientExists)  ){
        $this->Flash->error(__('Incorrect url, please try again !'));
        return $this->redirect(['controller'=>'Students','action' => 'login']);
    }
    // pr($cc); die();

    $this->viewBuilder()->setLayout('student-layout');
    $this->loadModel('Tenants');
    $url = Router::url('/', true);
    if($url == "http://localhost/classbyte/"){
    $domainType = 'cmc.classbyte.twinspark.co/tenants/login';
    }else{
    $domainType = "http://$_SERVER[HTTP_HOST]";
    }
    // $domainType = "http://$_SERVER[HTTP_HOST]";
    // $domainType = 'cmc.classbyte.twinspark.co/tenants/login';
    $tenant = $this->Tenants->find()->where(['domain_type LIKE' => '%'.$domainType.'%'])->first();
    $subcontractedClient = $this->SubcontractedClients->findById($id)->first();
    // pr($subcontractedClient);die();
    if(!isset($tenant) && empty($tenant)){
    throw new NotFoundException(__('Tenant Not Found'));
    }

    $this->loadModel('Courses');
    
    $courses = $this->Courses->find()
                             ->matching('CorporateClients.SubcontractedClients',function ($q)  use ($id){
                                 return $q->where([
                                     'SubcontractedClients.id'=>$id
                                 ]);
                             })
                             ->contain(['CourseTypes','Locations'])
                             ->toArray();
                    // pr($courses);die();
    $this->loadModel('CourseStudents');
    $courseStudent = $this->CourseStudents->find()
                                          ->contain(['Courses'])
                                          ->matching('Courses.CorporateClients.SubcontractedClients',function ($q)  use ($id){
                                 return $q->where([
                                     'SubcontractedClients.id'=>$id
                                 ]);
                             })
                                          // ->extract('Courses')
                                          // ->toArray();
                                          ->count();
    // pr($courseStudent);die;                                                               
    $this->set(compact('courses','subcontractedClient','courseStudent'));
    }
    /**
     * Edit method
     *
     * @param string|null $id Subcontracted Client id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $loggedInUser = $this->Auth->user();
        $subcontractedClient = $this->SubcontractedClients->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            // pr($this->request->getData());die();
            // pr($this->request->getData(['web_id']));die();
            // pr($urlId);die();
            // pr($subcontractedClient->web_url);die();
            $data = $this->request->getData();
            $urlId = $this->request->getData('web_id');
            // $urlWeb = $this->request->getData(['web_url']);
            // pr($this->request->getData()); die();
            $tenant = $this->Tenants->findById($loggedInUser['tenant_id'])->first();
            // $getTenantDomain = explode('/', $tenant->domain_type);
            $host = $this->request->host();
            $corporateUrl = $host."/subcontracted-clients/corporate/".$id."/".$urlId;
            $subcontractedClient = $this->SubcontractedClients->patchEntity($subcontractedClient, $this->request->getData());

            if($data['web_page'] == 1){
                $subcontractedClient->web_url = $corporateUrl;
            }
            if ($this->SubcontractedClients->save($subcontractedClient)) {
                $this->Flash->success(__('The subcontracted client has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The subcontracted client could not be saved. Please, try again.'));
        }

        if($loggedInUser['role']->name == self::TENANT_LABEL){
        $trainingSites = $this->SubcontractedClients->TrainingSites->find()
                                                ->where(['TrainingSites.tenant_id' => $loggedInUser['tenant_id']])
                                                ->all()
                                                ->combine('id','name')
                                                ->toArray();
                                                // pr($trainingSites); die('ss');
        $corporateClients = $this->SubcontractedClients->CorporateClients->find()
                                                ->where(['CorporateClients.tenant_id' => $loggedInUser['tenant_id']])
                                                ->all()
                                                ->combine('id','name')
                                                ->toArray();
        }else if($loggedInUser['role']->name == self::SUPER_ADMIN_LABEL)  {
            $trainingSites = $this->SubcontractedClients->TrainingSites->find()
                                                ->all()
                                                ->combine('id','name')
                                                ->toArray();
                                                // pr($trainingSites); die('ss');
        $corporateClients = $this->SubcontractedClients->CorporateClients->find()
                                                ->all()
                                                ->combine('id','name')
                                                ->toArray();
        }
        $this->set(compact('subcontractedClient', 'trainingSites', 'corporateClients','loggedInUser'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Subcontracted Client id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $subcontractedClient = $this->SubcontractedClients->get($id);
        if ($this->SubcontractedClients->delete($subcontractedClient)) {
            $this->Flash->success(__('The subcontracted client has been deleted.'));
        } else {
            $this->Flash->error(__('The subcontracted client could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
