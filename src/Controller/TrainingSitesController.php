<?php
namespace App\Controller;
use Cake\I18n\Time;
Time::setToStringFormat('yyyy/MM/dd');

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Collection\Collection;

/**
 * TrainingSites Controller
 *
 * @property \App\Model\Table\TrainingSitesTable $TrainingSites
 *
 * @method \App\Model\Entity\TrainingSite[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TrainingSitesController extends AppController
{
      public function initialize()
    {
        $this->_RequestData = $this->request->getData();
        parent::initialize();
    }
    public function isAuthorized($user)
    {
        // pr($user['role']->name); die('ss');
        $action = $this->request->getParam('action');
        // pr($action); die();

        // The add and index actions are always allowed.
        if (in_array($action, ['index', 'view','add','edit','delete','contract','monitoringform','insurance']) && $user['role']->name === self::SUPER_ADMIN_LABEL) {
        // pr($action); die('in super admin');
            return true;
        }

        else if (in_array($action, ['index','view','add','edit','delete','monitoringform','contract','insurance']) && $user['role']->name === self::TENANT_LABEL) {
        // pr($action); die('in tenant admin');
            return true;
        }
        else if (in_array($action, ['index', 'view','add','edit','delete']) && $user['role']->name === self::INSTRUCTOR_LABEL) {
            return true;
        }

        // All other actions require an id.
        /*if (empty($this->request->getParam('pass.0'))) {
            return $this->redirect(['controller' => 'tenants','action' => 'index']);
        }*/
        return parent::isAuthorized($user);
    }

  

    /**
     * Index method..
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {

        $loggedInUser = $this->Auth->user();
        // pr($id);die();
        $this->loadModel('Instructors');
        $this->loadModel('Courses');

        $instructorCount = [];
        $courseCount = [];
        if($loggedInUser['role']->name == self::TENANT_LABEL){
          $trainingSites = $this->TrainingSites->find()
                                              ->where(['TrainingSites.tenant_id ='=>$loggedInUser['tenant_id']])
                                              ->contain(['Tenants.Courses','TrainingSiteNotes','Instructors' => function($q) use($loggedInUser){
                                                return $q->where(['tenant_id' => $loggedInUser['tenant_id']]);
                                              }])
                                              ->indexBy('id')
                                              ->toArray();
                                              // pr($trainingSites);die;

          if(!empty($trainingSites)){

            $instructorCount = (new Collection($trainingSites))->indexBy('id')
                                                               ->map(function($value){
                                                              return count($value->instructors);
                                                            })
                                                               ->toArray();

            $courseCount = (new Collection($trainingSites))
                                                ->indexBy('id')
                                                ->map(function($value){
                                                  return (new Collection($value->tenant->courses))->countBy('status')->toArray();
                                                })
                                                ->toArray();  
            // pr($courseCount);die();
            // pr($instructorCount);die();      
          }
                     
        }else if($loggedInUser['role']->name == self::SUPER_ADMIN_LABEL){
        $trainingSites = $this->TrainingSites
                                    ->find()
                                    ->contain(['Tenants','TrainingSiteNotes'])
                                    ->all();
        }


        $this->set('loggedInUser', $loggedInUser);
        $this->set(compact('trainingSites','instructorCount','courseCount'));
    }

    /**
     * View method
     *
     * @param string|null $id Training Site id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
      $this->viewBuilder()->setLayout('popup-view');
        $trainingSite = $this->TrainingSites->get($id, [
            'contain' => ['Tenants', 'CorporateClients', 'Courses', 'Instructors', 'Locations']
        ]);

        $this->loadModel('TrainingSiteNotes');
        $trainingSiteNotes = $this->TrainingSiteNotes->find()
                                                     ->where(['training_site_id ='=>$trainingSite['id']])
                                                     ->all()
                                                     ->toArray();
        
        $this->set(compact('trainingSite','trainingSiteNotes'));
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $trainingSite = $this->TrainingSites->newEntity();
        $loggedInUser = $this->Auth->user();
        if ($this->request->is('post')) {
            $this->_RequestData['tenant_id'] = $loggedInUser['tenant_id'];
            $trainingSite = $this->TrainingSites->patchEntity($trainingSite, $this->_RequestData);
            if ($this->TrainingSites->save($trainingSite)) {
                $this->Flash->success(__('The training site has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The training site could not be saved. Please, try again.'));
        }

        if($loggedInUser['role']->name == self::TENANT_LABEL){
            $tenants = $this->TrainingSites->Tenants->find()
                                                ->where(['id'=>$loggedInUser['id']])
                                                ->all()
                                                ->combine('id','center_name')
                                                ->toArray();
            
        }else {
            $tenants = $this->TrainingSites->Tenants->find()->all()->combine('id','center_name')->toArray();
        }
        $this->set('loggedInUser', $loggedInUser);
        // $tenants = $this->TrainingSites->Tenants->find()->all()->combine('id','center_name')->toArray();
        $this->set(compact('trainingSite', 'tenants'));
    }






    public function contract($id = null){
      $this->viewBuilder()->setLayout('popup-view');
      $trainingSite = $this->TrainingSites->get($id, [
            'contain' => []
      ]);
      $oldImageName = $trainingSite->site_contract_name;
        $path = Configure::read('ImageUpload.unlinkPathForTrainingSiteContract');


       $loggedInUser = $this->Auth->user();

        if ($this->request->is(['patch', 'post', 'put'])) {
            // pr($this->request->getData());die('here');
            $trainingSite = $this->TrainingSites->patchEntity($trainingSite, $this->_RequestData);
            if ($this->TrainingSites->save($trainingSite)) {
              if(empty($this->_RequestData['site_contract_name']['tmp_name'])){
              unset($this->_RequestData['site_contract_name']);
                    $oldImageName ='';
                }
                if(!empty($oldImageName)){
                    $filePath = $path . '/'.$oldImageName;
                    if($filePath != '' && file_exists( $filePath ) ){
                        unlink($filePath);
                    }
                }
               $this->Flash->success(__('Contract Document has been saved.'));
                $popupLayout = $this->request->getQuery('layoutType');
               
                    return $this->redirect(['action' => 'view', $trainingSite->id]);
                
            }
            else{$this->Flash->error(__('Contract Document could not be saved. Please, try again.'));
          }
        }
      $this->set(compact('trainingSite', 'tenants'));
    }

    public function insurance($id = null){
      $this->viewBuilder()->setLayout('popup-view');
      $trainingSite = $this->TrainingSites->get($id, [
            'contain' => []
      ]);
      $oldImageName = $trainingSite->site_insurance_name;
        $path = Configure::read('ImageUpload.unlinkPathForTrainingSiteInsurance');


       $loggedInUser = $this->Auth->user();

        if ($this->request->is(['patch', 'post', 'put'])) {
          $requestData = $this->request->getData();
            $requestData['site_insurance_expiry_date'] = new Time($requestData['site_insurance_expiry_date']);
            $trainingSite = $this->TrainingSites->patchEntity($trainingSite,  $requestData);
            if ($this->TrainingSites->save($trainingSite)) {
              if(empty($requestData['site_insurance_name']['tmp_name'])){

              unset($requestData['site_insurance_name']);
                    $oldImageName ='';
                }
                if(!empty($oldImageName)){
                    $filePath = $path . '/'.$oldImageName;
                    if($filePath != '' && file_exists( $filePath ) ){
                        unlink($filePath);
                    }
                }
                $this->Flash->success(__('Insurance Document has been saved.'));
                $popupLayout = $this->request->getQuery('layoutType');
                    return $this->redirect(['action' => 'view', $trainingSite->id]);


            }
            else{$this->Flash->error(__('Insurance Document could not be saved. Please, try again.'));
          }
        }
      $this->set(compact('trainingSite', 'tenants', 'closeIframe'));
    }

    
     public function monitoringform($id = null){
      $this->viewBuilder()->setLayout('popup-view');
      
      $trainingSite = $this->TrainingSites->get($id, [
            'contain' => []
      ]);

      // pr($trainingSite); die();
      $oldImageName = $trainingSite->site_monitoring_name;
      $path = Configure::read('ImageUpload.unlinkPathForTrainingSiteMonitoringForm');


       $loggedInUser = $this->Auth->user();

        if ($this->request->is(['patch', 'post', 'put'])) {
            // pr($this->request->getData());die('here');
          $requestData = $this->request->getData();
            $requestData['site_monitoring_date'] = new Time($requestData['site_monitoring_date']);
            
            $trainingSite = $this->TrainingSites->patchEntity($trainingSite, $requestData);
            if ($this->TrainingSites->save($trainingSite)) {
              if(empty($requestData['site_monitoring_name']['tmp_name'])){
              unset($requestData['site_monitoring_name']);
                    $oldImageName ='';
                }
                if(!empty($oldImageName)){
                    $filePath = $path . '/'.$oldImageName;
                    if($filePath != '' && file_exists( $filePath ) ){
                        unlink($filePath);
                    }
                }
                $this->Flash->success(__('Monitoring Form has been saved.'));

                $popupLayout = $this->request->getQuery('layoutType');
                    return $this->redirect(['action' => 'view', $trainingSite->id]);
            }
            else{$this->Flash->error(__('Monitoring Form could not be saved. Please, try again.'));
          }
        }
      $this->set(compact('trainingSite', 'tenants'));
    }
    
    /**
     * Edit method
     *
     * @param string|null $id Training Site id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $trainingSite = $this->TrainingSites->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $trainingSite = $this->TrainingSites->patchEntity($trainingSite, $this->request->getData());
            if ($this->TrainingSites->save($trainingSite)) {
                $this->Flash->success(__('The training site has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The training site could not be saved. Please, try again.'));
        }
        $loggedInUser = $this->Auth->user();
        if($loggedInUser['role']->name == self::TENANT_LABEL){
            $tenants = $this->TrainingSites->Tenants->find()
                                                ->where(['id'=>$loggedInUser['id']])
                                                ->all()
                                                ->combine('id','center_name')
                                                ->toArray();
            
        }else {
            $tenants = $this->TrainingSites->Tenants->find()->all()->combine('id','center_name')->toArray();
        }
        $this->set('loggedInUser', $loggedInUser);
        // $tenants = $this->TrainingSites->Tenants->find()->all()->combine('id','center_name')->toArray();        
        $this->set(compact('trainingSite', 'tenants'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Training Site id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $trainingSite = $this->TrainingSites->get($id);
        if ($this->TrainingSites->delete($trainingSite)) {
            $this->Flash->success(__('The training site has been deleted.'));
        } else {
            $this->Flash->error(__('The training site could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

}
