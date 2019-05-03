<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Addons Controller..
 *
 * @property \App\Model\Table\AddonsTable $Addons
 *
 * @method \App\Model\Entity\Addon[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AddonsController extends AppController
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
        if (in_array($action, ['index', 'view','add','edit','delete','updateStatus']) && $user['role']->name === self::SUPER_ADMIN_LABEL) {
        // pr($action); die('in super admin');
            return true;
        }
        else if (in_array($action, ['index','view','add','edit','delete','updateStatus']) && $user['role']->name === self::TENANT_LABEL) {
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
        if($loggedInUser['role']->name == self::TENANT_LABEL){
          $addons = $this->Addons->find()
                                              ->contain(['Tenants', 'KeyCategories'])
                                              ->where(['Addons.tenant_id ='=>$loggedInUser['tenant_id']])
                                              ->all()
                                              ->toArray();
        }else if($loggedInUser['role']->name == self::SUPER_ADMIN_LABEL){
        $addons = $this->Addons
                                    ->find()
                                    ->contain(['Tenants', 'KeyCategories'])
                                    ->all();
        }
        $this->set('loggedInUser', $loggedInUser);
        $this->set(compact('addons'));
    }

    /**
     * View method
     *
     * @param string|null $id Addon id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $addon = $this->Addons->get($id, [
            'contain' => ['Tenants', 'KeyCategories']
        ]);
        

        $this->set('addon', $addon);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $loggedInUser = $this->Auth->user();
            $tenantId = $loggedInUser['tenant_id'];
            $this->loadModel('TenantSettings');
            $tenantSetting = $this->TenantSettings->findByTenantId($tenantId)->first();
            // pr($tenantSetting);die;
        $addon = $this->Addons->newEntity();
        $loggedInUser = $this->Auth->user();
        if ($this->request->is('post')) {
            $this->_RequestData['tenant_id'] = $loggedInUser['tenant_id'];
            // pr($this->request->getData());die;
            $addon = $this->Addons->patchEntity($addon, $this->_RequestData);
            if ($this->Addons->save($addon)) {
                $this->Flash->success(__('The addon has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The addon could not be saved. Please, try again.'));
        }

        if($loggedInUser['role']->name == self::TENANT_LABEL){
            $tenants = $this->Addons->Tenants->find()
                                                ->where(['id'=>$loggedInUser['tenant_id']])
                                                ->all()
                                                ->combine('id','center_name')
                                                ->toArray();

            $keyCategories = $this->Addons->KeyCategories->find()
                                                        ->where(['tenant_id'=>$loggedInUser['tenant_id']])
                                                        ->all()
                                                        ->combine('id','name')
                                                        ->toArray();
            
        }else {
            $tenants = $this->CorporateClients->Tenants->find()->all()->combine('id','center_name')->toArray();
            $keyCategories = $this->Addons->KeyCategories->find()->all()->combine('id','name')->toArray();
        }

        $this->set('loggedInUser', $loggedInUser);
        $this->set(compact('addon', 'tenants', 'keyCategories','tenantSetting'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Addon id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $addon = $this->Addons->get($id, [
            'contain' => []
        ]);
            $loggedInUser = $this->Auth->user();
            $tenantId = $loggedInUser['tenant_id'];
            $this->loadModel('TenantSettings');
            $tenantSetting = $this->TenantSettings->findByTenantId($tenantId)->first();

        if ($this->request->is(['patch', 'post', 'put'])) {
            $addon = $this->Addons->patchEntity($addon, $this->_RequestData);
            if ($this->Addons->save($addon)) {
                $this->Flash->success(__('The addon has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The addon could not be saved. Please, try again.'));
        }

        if($loggedInUser['role']->name == self::TENANT_LABEL){
            $tenants = $this->Addons->Tenants->find()
                                                ->where(['id'=>$loggedInUser['tenant_id']])
                                                ->all()
                                                ->combine('id','center_name')
                                                ->toArray();

            $keyCategories = $this->Addons->KeyCategories->find()
                                                        ->where(['tenant_id'=>$loggedInUser['tenant_id']])
                                                        ->all()
                                                        ->combine('id','name')
                                                        ->toArray();
        }else {
            $tenants = $this->CorporateClients->Tenants->find()->all()->combine('id','center_name')->toArray();
            $keyCategories = $this->Addons->KeyCategories->find()->all()->combine('id','name')->toArray();
        }
        
        $this->set('loggedInUser', $loggedInUser);
        $this->set(compact('addon', 'tenants', 'keyCategories','tenantSetting'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Addon id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $addon = $this->Addons->get($id);
        if ($this->Addons->delete($addon)) {
            $this->Flash->success(__('The addon has been deleted.'));
        } else {
            $this->Flash->error(__('The addon could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
        public function updateStatus($id = null)
    {
        $query = $this->request->getAttribute('params')['pass'];
        // pr($query); die();
        $addon_id = $query[0];
        $this->request->allowMethod(['post']);
        $addon = $this->Addons->get($addon_id);
        // pr($query);die;
        if($addon){
          $option_status = $query[1];
          if($option_status == 1){
            $option_status = 0;
          }else if($option_status == 0){
            $option_status = 1;
          }
          // pr($option_status);die;
          $addonData['option_status'] = $option_status;
          $addon = $this->Addons->patchEntity($addon, $addonData);
          // pr($addon);die;
          $addon = $this->Addons->save($addon);
            if($addon){
              $this->Flash->success(__('Status updated'));
            }else{
              $this->Flash->error(__('Please, try again.'));
            }
        }
        return $this->redirect(['action' => 'index']);
    }
}
