<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CorporateClientUsers Controller
 *
 * @property \App\Model\Table\CorporateClientUsersTable $CorporateClientUsers
 *
 * @method \App\Model\Entity\CorporateClientUser[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CorporateClientUsersController extends AppController
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
        if (in_array($action, ['index', 'view','add','edit','delete','updateStatus']) && $user['role']->name === self::TENANT_LABEL) {
        // pr($action); die('in super admin');
            return true;
        }
        else if (in_array($action, ['index', 'view','add','edit','delete','dashboard','updateStatus']) && $user['role']->name === self::CLIENT_LABEL) {
        // pr($action); die('in tenant admin');
            return true;
        }
        // All other actions require an id.
        /*if (empty($this->request->getParam('pass.0'))) {
            return $this->redirect(['controller' => 'tenants','action' => 'index']);
        }*/
        return parent::isAuthorized($user);
    }

    
    public function dashboard(){
       
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $loggedInUser = $this->Auth->user();
        $this->loadModel('CorporateClients');

        if($loggedInUser['role']->name == self::CLIENT_LABEL){
          $corporateClientUsers = $this->CorporateClientUsers->find()
                                      ->contain(['CorporateClients', 'Roles'])
                                      ->where(['CorporateClientUsers.corporate_client_id ='=>$loggedInUser['corporate_client_id']])
                                      ->all()
                                      ->toArray();
      }elseif($loggedInUser['role']->name == self::TENANT_LABEL){
        $corporateClientUsers = $this->CorporateClientUsers->find()
                                      ->contain(['CorporateClients', 'Roles'])
                                      ->where(['CorporateClients.tenant_id ='=>$loggedInUser['tenant_id']])
                                        ->all()
                                      ->toArray();
                                      // pr($corporateClientUsers); die();

      }

        $this->set(compact('corporateClientUsers','loggedInUser'));
    }


    /**
    **For Clickable Status Toggle in Index**

    **/
     public function updateStatus($id = null)
    {

        $query = $this->request->getAttribute('params')['pass'];
        $corporate_client_user_id = $query[0];
        $this->request->allowMethod(['post']);
        $corporateClientUser = $this->CorporateClientUsers->get($corporate_client_user_id);
        if($corporateClientUser){
          $status = $query[1];
          if($status == 1){
            $status = 0;
          }else if($status == 0){
            $status = 1;
          }
          $corporateClientUser['status'] = $status;
          // $tenant = $this->Tenants->patchEntity($tenant, $tenantData);
          $corporateClientUser = $this->CorporateClientUsers->save($corporateClientUser);
            if($corporateClientUser){
              $this->Flash->success(__('Status updated'));
            }else{
              $this->Flash->error(__('Please, try again.'));
            }
        }
        return $this->redirect(['action' => 'index']);
    }

    /**
     * View method
     *
     * @param string|null $id Corporate Client User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $corporateClientUser = $this->CorporateClientUsers->get($id, [
            'contain' => ['CorporateClients', 'Roles']
        ]);

        $this->set('corporateClientUser', $corporateClientUser);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $corporateClientUser = $this->CorporateClientUsers->newEntity();
        $loggedInUser = $this->Auth->user();
        if ($this->request->is('post')) {
            if($loggedInUser['role']->name == 'corporate_client'){
                $this->_RequestData['corporate_client_id'] = $loggedInUser['corporate_client_id'];
            }
            $this->_RequestData['role_id'] = 3;
            $corporateClientUser = $this->CorporateClientUsers->patchEntity($corporateClientUser, $this->_RequestData);
            if ($this->CorporateClientUsers->save($corporateClientUser)) {
                $this->Flash->success(__('The corporate client user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The corporate client user could not be saved. Please, try again.'));
        }
        if($loggedInUser['role']->name == self::TENANT_LABEL){
        $corporateClients = $this->CorporateClientUsers->CorporateClients->find()
                                                ->where(['tenant_id' => $loggedInUser['tenant_id']])
                                                ->all()
                                                ->combine('id','name')
                                                ->toArray();
        }
         
        
        $roles = $this->CorporateClientUsers->Roles->find('list', ['limit' => 200]);
        $this->set('loggedInUser', $loggedInUser);
        $this->set(compact('corporateClientUser', 'corporateClients', 'roles'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Corporate Client User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $corporateClientUser = $this->CorporateClientUsers->get($id, [
            'contain' => []
        ]);

        $loggedInUser = $this->Auth->user();
        // pr($loggedInUser);die;
        
        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->loadModel('CorporateClients');
             if($loggedInUser['role']->name == 'corporate_client'){
                $this->_RequestData['corporate_client_id'] = $loggedInUser['corporate_client_id'];
            }
            $this->_RequestData['role_id'] = 3;
            $corporateClientUser = $this->CorporateClientUsers->patchEntity($corporateClientUser, $this->_RequestData);
            if ($this->CorporateClientUsers->save($corporateClientUser)) {
                $this->Flash->success(__('The corporate client user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The corporate client user could not be saved. Please, try again.'));
        }
        if($loggedInUser['role']->name == self::TENANT_LABEL){
        $corporateClients = $this->CorporateClientUsers->CorporateClients->find()
                                                ->where(['tenant_id' => $loggedInUser['tenant_id']])
                                                ->all()
                                                ->combine('id','name')
                                                ->toArray();
        }
        $roles = $this->CorporateClientUsers->Roles->find('list', ['limit' => 200]);
        $this->set('loggedInUser', $loggedInUser);
        $this->set(compact('corporateClientUser', 'corporateClients', 'roles'));
    }
    

    /**
     * Delete method
     *
     * @param string|null $id Corporate Client User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $corporateClientUser = $this->CorporateClientUsers->get($id);
        if ($this->CorporateClientUsers->delete($corporateClientUser)) {
            $this->Flash->success(__('The corporate client user has been deleted.'));
        } else {
            $this->Flash->error(__('The corporate client user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
