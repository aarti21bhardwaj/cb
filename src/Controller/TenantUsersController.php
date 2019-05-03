<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Collection\Collection;

/**
 * TenantUsers Controller
 *
 * @property \App\Model\Table\TenantUsersTable $TenantUsers
 *
 * @method \App\Model\Entity\TenantUser[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TenantUsersController extends AppController
{

    public function initialize()
    {
        $this->_RequestData = $this->request->getData();
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->Auth->allow([]);
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
        else if (in_array($action, ['add','index','view','edit','delete','updateStatus']) && $user['role']->name === self::TENANT_LABEL) {
        // pr($action); die('in tenant admin');
            return true;
        }
        else if (in_array($action, ['index','view']) && $user['role']->name === self::USER_LABEL) {
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
            if($loggedInUser['role']->name == self::SUPER_ADMIN_LABEL){
              $tenantUsers =   $this->TenantUsers->find('all',
                ['contain' => ['Roles', 'Tenants']] );
            }
            else if($loggedInUser['role']->name == self::TENANT_LABEL){
              $tenantUsers =  $this->TenantUsers->find('all',
                [
                'contain' => ['Roles', 'Tenants'],
                'conditions' => ['tenant_id =' => $this->Auth->user('tenant_id'),'Roles.name <>'=>self::SUPER_ADMIN_LABEL]
                ])->toArray();
              // pr($tenantUsers); die();
            }
            else {
              $tenantUsers =  $this->TenantUsers->find('all',
                [
                'contain' => ['Roles', 'Tenants'],
                'conditions' => ['tenant_id =' => $this->Auth->user('tenant_id'), 'Roles.name'=>self::USER_LABEL]
                ]);
            }

        $this->set(compact('tenantUsers'));
    }

    /**
     * View method
     *
     * @param string|null $id Tenant User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tenantUser = $this->TenantUsers->get($id, [
            'contain' => ['Tenants', 'Roles']
        ]);

        $this->set('tenantUser', $tenantUser);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $loggedInUser = $this->Auth->user();
        // pr($loggedInUser['role']->name); die();
        $tenantUser = $this->TenantUsers->newEntity();
        if ($this->request->is('post')) {
            if($loggedInUser['role']->name == 'tenant'){
                $this->_RequestData['tenant_id'] = $loggedInUser['tenant_id'];
            }
            $this->_RequestData['role_id'] = 2;
            $tenantUser = $this->TenantUsers->patchEntity($tenantUser, $this->_RequestData);
            // pr($tenantUser); die();
            if ($this->TenantUsers->save($tenantUser)) {
                $this->Flash->success(__('The tenant user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tenant user could not be saved. Please, try again.'));
        }

        if($loggedInUser['role']->name == self::SUPER_ADMIN_LABEL){
            $tenants = $this->TenantUsers->Tenants->find()->all()->combine('id','center_name')->toArray();
            $trainingSites = $this->TenantUsers->TrainingSites->find()->all()->combine('id','name')->toArray();

            // $tenantSites = $this->TenantUsers->TrainingSites->find()->all()->groupBy('tenant_id')->map(function($value, $key){
            //                                 $temp = (new Collection($value))->combine('id', 'name');
            //                                 return $temp->toArray();
            //                               })->toArray();

            // pr($tenantSites); die('ss');
        }else {
            $tenants = $this->TenantUsers->Tenants->find()
                                                ->where(['id'=>$loggedInUser['tenant_id']])
                                                ->all()
                                                ->combine('id','center_name')
                                                ->toArray();

            $trainingSites = $this->TenantUsers->TrainingSites->find()->where(['tenant_id' => $loggedInUser['tenant_id']])->all()->combine('id','name')->toArray();

            /*$tenantSites = $this->TenantUsers->Tenants->find()
                                                  ->where(['tenant_id' => $loggedInUser['tenant_id']])
                                                  ->all()->groupBy('tenant_id')->map(function($value, $key){
                                                    $temp = (new Collection($value))->combine('id', 'name');
                                                    return $temp->toArray();
                                                  })->toArray();*/

        }

        // $roles = $this->TenantUsers->Roles->find('list', ['limit' => 200]);
        $this->set(compact('tenantUser', 'tenants', 'roles','loggedInUser','trainingSites'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Tenant User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $loggedInUser = $this->Auth->user();
        $tenantUser = $this->TenantUsers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            if($loggedInUser['role'] == 'tenant'){
                $this->_RequestData['tenant_id'] = $loggedInUser['tenant_id'];
            }
            $this->_RequestData['role_id'] = 2;
            $tenantUser = $this->TenantUsers->patchEntity($tenantUser, $this->_RequestData);
            if ($this->TenantUsers->save($tenantUser)) {
                $this->Flash->success(__('The tenant user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tenant user could not be saved. Please, try again.'));
        }
        if($loggedInUser['role']->name == self::SUPER_ADMIN_LABEL){
            $tenants = $this->TenantUsers->Tenants->find()->all()->combine('id','center_name')->toArray();
            $trainingSites = $this->TenantUsers->TrainingSites->find()->all()->combine('id','name')->toArray();
        }else {
            $tenants = $this->TenantUsers->Tenants->find()
                                                ->where(['id'=>$loggedInUser['tenant_id']])
                                                ->all()
                                                ->combine('id','center_name')
                                                ->toArray();

            $trainingSites = $this->TenantUsers->TrainingSites->find()->where(['tenant_id' => $loggedInUser['tenant_id']])->all()->combine('id','name')->toArray();
        }
        // $roles = $this->TenantUsers->Roles->find('list', ['limit' => 200]);
        $this->set(compact('tenantUser', 'tenants', 'roles','loggedInUser','trainingSites'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Tenant User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tenantUser = $this->TenantUsers->get($id);
        if ($this->TenantUsers->delete($tenantUser)) {
            // pr($tenantUser);die();
            $this->Flash->success(__('The tenant user has been deleted.'));
        } else {
            $this->Flash->error(__('The tenant user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function updateStatus($id = null)
    {
        $query = $this->request->getAttribute('params')['pass'];
        // pr($query); die();
        $tenant_user_id = $query[0];
        $this->request->allowMethod(['post']);
        $tenantUser = $this->TenantUsers->get($tenant_user_id);
        if($tenantUser){
          $status = $query[1];
          if($status == 1){
            $status = 0;
          }else if($status == 0){
            $status = 1;
          }
          $tenantData['status'] = $status;
          $tenantUser = $this->TenantUsers->patchEntity($tenantUser, $tenantData);
          $tenantUser = $this->TenantUsers->save($tenantUser);
            if($tenantUser){
              $this->Flash->success(__('Status updated'));
            }else{
              $this->Flash->error(__('Please, try again.'));
            }
        }
        return $this->redirect(['action' => 'index']);
    }

}
