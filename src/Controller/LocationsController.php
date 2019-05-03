<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Locations Controller..
 *
 * @property \App\Model\Table\LocationsTable $Locations
 *
 * @method \App\Model\Entity\Location[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LocationsController extends AppController
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
        if (in_array($action, ['index', 'view','add','edit','delete']) && $user['role']->name === self::SUPER_ADMIN_LABEL) {
        // pr($action); die('in super admin');
            return true;
        }
        else if (in_array($action, ['index','view','add','edit','delete','thankYou']) && $user['role']->name === self::TENANT_LABEL) {
        // pr($action); die('in tenant admin');
            return true;
        }
         else if (in_array($action, ['index', 'view','add','edit','delete','thankYou']) && $user['role']->name === self::CLIENT_LABEL) {
        // pr($action); die('in tenant admin');
            return true;
        }
         else if (in_array($action, ['index', 'view','add','edit','delete','thankYou']) && $user['role']->name === self::INSTRUCTOR_LABEL) {
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
        // pr($loggedInUser);die;
        $trainingSiteOwner = "";
        if($loggedInUser['role']->name == self::TENANT_LABEL){
          
          $locations = $this->Locations->findByTenantId($loggedInUser['tenant_id'])
                                              ->contain(['Tenants', 'TrainingSites', 'CorporateClients'])
                                              ->all()
                                              ->toArray();
        }else if($loggedInUser['role']->name == self::SUPER_ADMIN_LABEL){
        $locations = $this->Locations->find()
                                        ->contain(['Tenants', 'TrainingSites','CorporateClients'])
                                        ->all();
        }
         else if($loggedInUser['role']->name == self::CLIENT_LABEL){
        $locations = $this->Locations
                                    ->find()
                                    ->contain(['Tenants', 'TrainingSites', 'CorporateClients'])
                                    ->where(['Locations.corporate_client_id ='=>$loggedInUser['corporate_client_id']])
                                    ->all()
                                    ->toArray();
        }
        if($loggedInUser['role']->name == self::TENANT_LABEL && $loggedInUser['role']->label == 'TRAINING SITE OWNER' ){
          $locations = $this->Locations->find()
                                              ->contain(['Tenants', 'TrainingSites', 'CorporateClients'])
                                              ->where(['Locations.training_site_id ='=>$loggedInUser['training_site_id']])
                                              ->all()
                                              ->toArray();

        }

        $this->set('loggedInUser', $loggedInUser);
        $this->set('trainingSiteOwner', $trainingSiteOwner);
        $this->set(compact('locations','loggedInUser'));
    }

    /**
     * View method
     *
     * @param string|null $id Location id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        // $data = $this->request->getData();
        // pr($data);die();
        $loggedInUser = $this->Auth->user();
        if($loggedInUser['role']->name !== 'corporate_client'){

        }
        $location = $this->Locations->get($id, [
            'contain' => ['Tenants', 'TrainingSites', 'CorporateClients', 'Courses']
        ]);
        
        $this->set('loggedInUser', $loggedInUser);
        $this->set('location', $location);
    }
    public function thankYou(){
      $this->viewBuilder()->setLayout('popup-view');
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($variable = null)
    {   
        if($variable){
        $this->viewBuilder()->setLayout('popup-view');

        }
        $location = $this->Locations->newEntity();
        $loggedInUser = $this->Auth->user();
        if ($this->request->is('post')) {
          $this->_RequestData['status'] = 1;
          // pr($this->_RequestData);die;
          if($loggedInUser['role']->name == 'corporate_client'){
                $this->_RequestData['corporate_client_id'] = $loggedInUser['corporate_client_id'];
                $this->_RequestData['tenant_id'] = $loggedInUser['corporate_client']['tenant_id'];
                $this->_RequestData['training_site_id'] = $loggedInUser['corporate_client']['training_site_id'];
                // pr();die();
            }elseif($loggedInUser['role']->name == 'tenant' && $loggedInUser['role']->label != 'TRAINING SITE OWNER'){
              $this->_RequestData['tenant_id'] = $loggedInUser['tenant_id'];
            }elseif($loggedInUser['role']->name == 'tenant' && $loggedInUser['role']->label == 'TRAINING SITE OWNER'){
              $this->_RequestData['tenant_id'] = $loggedInUser['tenant_id'];
              $this->_RequestData['training_site_id'] = $loggedInUser['training_site_id'];
            }

            if($loggedInUser['role']->name == 'tenant'){
                $this->_RequestData['tenant_id'] = $loggedInUser['tenant_id'];
            }
            $this->_RequestData['status'] = 1;
            // pr($this->request->getData());die;
            $location = $this->Locations->patchEntity($location, $this->_RequestData);
            // pr($location);die;
            if ($this->Locations->save($location)) {
                if(!$variable){
                $this->Flash->success(__('The location has been saved.'));
                return $this->redirect(['action' => 'index']);
              }else{
                return $this->redirect(['action' => 'thankYou']);
              }
                  
            }
            $this->Flash->error(__('The location could not be saved. Please, try again.'));
        }

        if($loggedInUser['role']->name == self::TENANT_LABEL){
            
            $tenants = $this->Locations->Tenants->find()
                                                ->where(['id'=>$loggedInUser['tenant_id']])
                                                ->all()
                                                ->combine('id','center_name')
                                                ->toArray();
        
            $trainingSites = $this->Locations->TrainingSites->find()
                                                            ->where(['tenant_id'=>$loggedInUser['tenant_id']])
                                                            ->all()
                                                            ->combine('id','name')
                                                            ->toArray();
            
            $corporateClients = $this->Locations->CorporateClients->find()
                                                                  ->where(['tenant_id'=>$loggedInUser['tenant_id']])
                                                                  ->all()
                                                                  ->combine('id','name')
                                                                  ->toArray();
                  
        }elseif($loggedInUser['role']->name == self::CLIENT_LABEL){
            
            $tenants = $this->Locations->Tenants->find()
                                                ->where(['id'=>$loggedInUser['corporate_client']['tenant_id']])
                                                ->all()
                                                ->combine('id','center_name')
                                                ->toArray();

            $trainingSites = $this->Locations->TrainingSites->find()
                                                            ->where(['id'=>$loggedInUser['corporate_client']['training_site_id']])
                                                            ->all()
                                                            ->combine('id','name')
                                                            ->toArray();

            $corporateClients = $this->Locations->CorporateClients->find()
                                                                  ->where(['id'=>$loggedInUser['corporate_client_id']])
                                                                  ->all()
                                                                  ->combine('id','name')
                                                                  ->toArray();
            
           

            }elseif($loggedInUser['role']->name == self::INSTRUCTOR_LABEL){
            
            $tenants = $this->Locations->Tenants->find()
                                                ->where(['id'=>$loggedInUser['tenant_id']])
                                                ->all()
                                                ->combine('id','center_name')
                                                ->toArray();

            $trainingSites = $this->Locations->TrainingSites->find()
                                                            ->where(['id'=>$loggedInUser['training_site_id']])
                                                            ->all()
                                                            ->combine('id','name')
                                                            ->toArray();

            $corporateClients = $this->Locations->CorporateClients->find()
                                                                  ->where(['tenant_id'=>$loggedInUser['tenant_id']])
                                                                  ->all()
                                                                  ->combine('id','name')
                                                                  ->toArray();
            
           

            }else if($loggedInUser['role']->name == self::SUPER_ADMIN_LABEL) {
            $tenants = $this->Locations->Tenants->find()->all()->combine('id','center_name')->toArray();
            $trainingSites = $this->Locations->TrainingSites->find()->all()->combine('id','name')->toArray();
            $corporateClients = $this->Locations->CorporateClients->find()->all()->combine('id','name')->toArray();
            
        }if($loggedInUser['role']->name == 'tenant' && $loggedInUser['role']->label == 'TRAINING SITE OWNER'){
          
          $corporateClients = $this->Locations->CorporateClients->find()
                                                                  ->where(['training_site_id'=>$loggedInUser['training_site_id']])
                                                                  ->all()
                                                                  ->combine('id','name')
                                                                  ->toArray();

        }
        $this->set('loggedInUser', $loggedInUser);
        $this->set(compact('location', 'tenants', 'trainingSites', 'corporateClients'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Location id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $loggedInUser = $this->Auth->user();
        $location = $this->Locations->get($id, [
            'contain' => []
        ]);
        // pr($location);die;
        if ($this->request->is(['patch', 'post', 'put'])) {
          if($loggedInUser['role']->name == 'corporate_client'){
                $this->_RequestData['corporate_client_id'] = $loggedInUser['corporate_client_id'];
                $this->_RequestData['tenant_id'] = $loggedInUser['corporate_client']['tenant_id'];
            }

            $location = $this->Locations->patchEntity($location, $this->_RequestData);
            if ($this->Locations->save($location)) {
                $this->Flash->success(__('The location has been saved.'));

                return $this->redirect(['action' => 'edit',$id]);
            }
            $this->Flash->error(__('The location could not be saved. Please, try again.'));
        }
        
        // pr($loggedInUser['role']->name); die('ss');
        if($loggedInUser['role']->name == self::TENANT_LABEL){
            if(isset($loggedInUser['training_site_id']) && $loggedInUser['training_site_id']){
                $trainingSiteOwner = $loggedInUser['training_site_id'];
            }else{
                $trainingSiteOwner = null;
            }
            $tenants = $this->Locations->Tenants->find()
                                                ->where(['id'=>$loggedInUser['tenant_id']])
                                                ->all()
                                                ->combine('id','center_name')
                                                ->toArray();
            $trainingSites = $this->Locations->TrainingSites->find()
                                                        ->where(['tenant_id'=>$loggedInUser['tenant_id']])
                                                        ->all()
                                                        ->combine('id','name')
                                                        ->toArray();
            $corporateClients = $this->Locations->CorporateClients->find()
                                                                  ->where(['tenant_id'=>$loggedInUser['tenant_id']])
                                                                  ->all()
                                                                  ->combine('id','name')
                                                                  ->toArray();

        $this->set('trainingSiteOwner', $trainingSiteOwner);
        }elseif($loggedInUser['role']->name == self::CLIENT_LABEL){
            
            $tenants = $this->Locations->Tenants->find()
                                                ->where(['id'=>$loggedInUser['corporate_client']['tenant_id']])
                                                ->all()
                                                ->combine('id','center_name')
                                                ->toArray();
                                                
            $trainingSites = $this->Locations->TrainingSites->find()
                                                            ->where(['id'=>$loggedInUser['corporate_client']['training_site_id']])
                                                            ->all()
                                                            ->combine('id','name')
                                                            ->toArray();

            $corporateClients = $this->Locations->CorporateClients->find()
                                                                  ->where(['id'=>$loggedInUser['corporate_client_id']])
                                                                  ->all()
                                                                  ->combine('id','name')
                                                                  ->toArray();
            
           

            }else if($loggedInUser['role']->name == self::SUPER_ADMIN_LABEL)  {
            $tenants = $this->Locations->Tenants->find()->all()->combine('id','center_name')->toArray();
            $trainingSites = $this->Locations->TrainingSites->find()->all()->combine('id','name')->toArray();
            $corporateClients = $this->Locations->CorporateClients->find()->all()->combine('id','name')->toArray();
            
        }if($loggedInUser['role']->name == self::TENANT_LABEL && $loggedInUser['role']->label == 'TRAINING SITE OWNER'){
          // pr('here');
            if(isset($loggedInUser['training_site_id']) && $loggedInUser['training_site_id']){
                $trainingSiteOwner = $loggedInUser['training_site_id'];
            }
            
            $corporateClients = $this->Locations->CorporateClients->find()
                                                                  ->where(['training_site_id'=>$loggedInUser['training_site_id']])
                                                                  ->all()
                                                                  ->combine('id','name')
                                                                  ->toArray();
                                                                  
        $this->set('trainingSiteOwner', $trainingSiteOwner);
        }
        $this->set('loggedInUser', $loggedInUser);
        $this->set(compact('location', 'tenants', 'trainingSites', 'corporateClients'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Location id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $location = $this->Locations->get($id);
        if ($this->Locations->delete($location)) {
            $this->Flash->success(__('The location has been deleted.'));
        } else {
            $this->Flash->error(__('The location could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
