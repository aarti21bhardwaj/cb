<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;

/**
 * KeyInventories Controller
 *
 * @property \App\Model\Table\KeyInventoriesTable $KeyInventories
 *
 * @method \App\Model\Entity\KeyInventory[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class KeyInventoriesController extends AppController
{
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
        $keyInventories = $this->KeyInventories->find()
                                              ->contain([
                                                        'KeyCategories'=> function($q) use($loggedInUser){
                                                            return $q->where(['tenant_id'=> $loggedInUser['tenant_id']]);
                                                        }])
                                              ->all();

        $keyCategories = $this->KeyInventories->KeyCategories->find()
                                                        ->where(['KeyCategories.tenant_id'=>$loggedInUser['tenant_id']])
                                                        ->all()
                                                        ->combine('id','name')
                                                        ->toArray();
        
        $this->set(compact('keyInventory', 'keyCategories','keyInventories'));
        
    }           
    public  function add(){
        $loggedInUser = $this->Auth->user();    
        $keyCategories = $this->KeyInventories->KeyCategories->find()
                                                        ->where(['KeyCategories.tenant_id'=>$loggedInUser['tenant_id']])
                                                        ->all()
                                                        ->combine('id','name')
                                                        ->toArray();
        if ($this->request->is('post')) {
            
            $keyCodes = preg_split("/[\s,]+/",$this->request->getData('name'));
            
            $reqData = [];
            foreach ($keyCodes as $key => $value) {
                $reqData[] = [
                                'key_category_id' => $this->request->getData('key_category_id'),
                                'name' => $value
                            ];
            }
            $keyInventories = $this->KeyInventories->newEntities($reqData);
            $keyInventories = $this->KeyInventories->patchEntities($keyInventories, $reqData);
            if ($this->KeyInventories->saveMany($keyInventories)) {
                $this->Flash->success(__('The key inventories have been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The key inventories could not be saved. Please, try again.'));
        }
        $this->set(compact('keyInventory','keyCategories'));

    }

    /**
     * Edit method
     *
     * @param string|null $id Key Inventory id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $keyInventory = $this->KeyInventories->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $keyInventory = $this->KeyInventories->patchEntity($keyInventory, $this->request->getData());
            if ($this->KeyInventories->save($keyInventory)) {
                $this->Flash->success(__('The key inventory has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The key inventory could not be saved. Please, try again.'));
        }
        $keyCategories = $this->KeyInventories->KeyCategories->find('list', ['limit' => 200]);
        $this->set(compact('keyInventory', 'keyCategories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Key Inventory id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $keyInventory = $this->KeyInventories->get($id);
        if ($this->KeyInventories->delete($keyInventory)) {
            $this->Flash->success(__('The key inventory has been deleted.'));
        } else {
            $this->Flash->error(__('The key inventory could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
