<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * KeyCategories Controller..
 *
 * @property \App\Model\Table\KeyCategoriesTable $KeyCategories
 *
 * @method \App\Model\Entity\KeyCategory[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class KeyCategoriesController extends AppController
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
     * Index method..
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $loggedInUser = $this->Auth->user();
        if($loggedInUser['role']->name == self::TENANT_LABEL){
          $keyCategories = $this->KeyCategories->find()
                                              ->contain(['Tenants'])
                                              ->where(['KeyCategories.tenant_id ='=>$loggedInUser['tenant_id']])
                                              ->all()
                                              ->toArray();
        }else if($loggedInUser['role']->name == self::SUPER_ADMIN_LABEL){
        $keyCategories = $this->KeyCategories
                                    ->find()
                                    ->contain(['Tenants'])
                                    ->all();
        }
        $this->set('loggedInUser', $loggedInUser);
        $this->set(compact('keyCategories'));
    }

    /**
     * View method
     *
     * @param string|null $id Key Category id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $keyCategory = $this->KeyCategories->get($id, [
            'contain' => ['Tenants', 'Addons']
        ]);

        $this->set('keyCategory', $keyCategory);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $keyCategory = $this->KeyCategories->newEntity();
        $loggedInUser = $this->Auth->user();
        if ($this->request->is('post')) {
            $this->_RequestData['tenant_id'] = $loggedInUser['tenant_id'];
            $keyCategory = $this->KeyCategories->patchEntity($keyCategory, $this->_RequestData);
            if ($this->KeyCategories->save($keyCategory)) {
                $this->Flash->success(__('The key category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The key category could not be saved. Please, try again.'));
        }

        // pr($loggedInUser['role']->name); die('ss');
        if($loggedInUser['role']->name == self::TENANT_LABEL){
            $tenants = $this->KeyCategories->Tenants->find()
                                                ->where(['id'=>$loggedInUser['tenant_id']])
                                                ->all()
                                                ->combine('id','center_name')
                                                ->toArray();
        }else {
            $tenants = $this->CorporateClients->Tenants->find()->all()->combine('id','center_name')->toArray();
        }
        $this->set('loggedInUser', $loggedInUser);
        
        // $tenants = $this->KeyCategories->Tenants->find()->all()->combine('id','center_name')->toArray();
        $this->set(compact('keyCategory', 'tenants'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Key Category id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $keyCategory = $this->KeyCategories->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $keyCategory = $this->KeyCategories->patchEntity($keyCategory, $this->_RequestData);
            if ($this->KeyCategories->save($keyCategory)) {
                $this->Flash->success(__('The key category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The key category could not be saved. Please, try again.'));
        }

        $loggedInUser = $this->Auth->user();
        // pr($loggedInUser['role']->name); die('ss');
        if($loggedInUser['role']->name == self::TENANT_LABEL){
            $tenants = $this->KeyCategories->Tenants->find()
                                                ->where(['id'=>$loggedInUser['id']])
                                                ->all()
                                                ->combine('id','center_name')
                                                ->toArray();
        }else {
            $tenants = $this->CorporateClients->Tenants->find()->all()->combine('id','center_name')->toArray();
        }
        $this->set('loggedInUser', $loggedInUser);
        
        // $tenants = $this->KeyCategories->Tenants->find('list', ['limit' => 200]);
        $this->set(compact('keyCategory', 'tenants'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Key Category id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $keyCategory = $this->KeyCategories->get($id);
        if ($this->KeyCategories->delete($keyCategory)) {
            $this->Flash->success(__('The key category has been deleted.'));
        } else {
            $this->Flash->error(__('The key category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
     public function updateStatus($id = null)
    {
        $query = $this->request->getAttribute('params')['pass'];
        // pr($query); die();
        $keyCategory_id = $query[0];
        $this->request->allowMethod(['post']);
        $keyCategory = $this->KeyCategories->get($keyCategory_id);
        if($keyCategory){
          $status = $query[1];
          if($status == 1){
            $status = 0;
          }else if($status == 0){
            $status = 1;
          }
          $keyCategoryData['status'] = $status;
          $keyCategory = $this->KeyCategories->patchEntity($keyCategory, $keyCategoryData);
          $keyCategory = $this->KeyCategories->save($keyCategory);
            if($keyCategory){
              $this->Flash->success(__('Status updated'));
            }else{
              $this->Flash->error(__('Please, try again.'));
            }
        }
        return $this->redirect(['action' => 'index']);
    }
}
