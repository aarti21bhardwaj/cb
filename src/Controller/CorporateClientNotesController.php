<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CorporateClientNotes Controller
 *
 *
 * @method \App\Model\Entity\CorporateClientNote[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CorporateClientNotesController extends AppController
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
    public function index($id = null)
    {
        $this->viewBuilder()->setLayout('popup-view');
         if($id) {
            // pr($id);
         $corporateClientNotes = $this->CorporateClientNotes->findByCorporateClientId($id)->toArray();
         // pr($corporateClientNotes); die('ss');
         $this->set('corporate_client_id', $id);
        } else {            
         $corporateClientNotes = $this->CorporateClientNotes->find()->toArray();
        }

        $this->set(compact('corporateClientNotes'));
        $this->set('id',$id);
    }

    /**
     * View method
     *
     * @param string|null $id Corporate Client Note id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('popup-view');
        $corporateClientNote = $this->CorporateClientNotes->get($id, [
            'contain' => []
        ]);

        $this->set('corporateClientNote', $corporateClientNote);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($id = null)
    {
        $this->viewBuilder()->setLayout('popup-view');
        if($id){
            $this->set('corporate_client_id', $id);
         }

        $corporateClientNote = $this->CorporateClientNotes->newEntity();

        if ($this->request->is('post')) {
            // pr($corporateClientNote);die();
            if(!isset($this->_RequestData['corporate_client_id'])){
               $this->_RequestData['corporate_client_id'] = $id;
            }
            $corporateClientNote = $this->CorporateClientNotes->patchEntity($corporateClientNote, $this->_RequestData);
            if ($this->CorporateClientNotes->save($corporateClientNote)) {
                $this->Flash->success(__('The corporate client note has been saved.'));
                if($id){
                    return $this->redirect(['action' => 'index', $id]);
                }
                else{
                    return $this->redirect(['action' => 'index']);
                }
            }
            $this->Flash->error(__('The corporate client note could not be saved. Please, try again.'));
        }
        $this->set(compact('corporateClientNote', 'corporateClients'));
        $this->set('id',$id);
    }

    /**
     * Edit method
     *
     * @param string|null $id Corporate Client Note id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null, $corporate_client_id = null)
    {
        $this->viewBuilder()->setLayout('popup-view');
        $corporateClientNote = $this->CorporateClientNotes->get($id, [
            'contain' => []
        ]);        
        if($this->Auth->user('role_id') == 1){
            $is_admin = true;
            $this->set('is_admin',$is_admin);
        }
        if ($this->request->is(['patch', 'post', 'put'])) {

            $corporateClientNote = $this->CorporateClientNotes->patchEntity($corporateClientNote, $this->_RequestData);
            if ($this->CorporateClientNotes->save($corporateClientNote)) {
                $this->Flash->success(__('The corporate client note has been saved.'));
                if($id){
                    return $this->redirect(['action' => 'index', $corporate_client_id]);
                }
                else{
                    return $this->redirect(['action' => 'index']);
                }
            }
            $this->Flash->error(__('The corporate client note could not be saved. Please, try again.'));
        }

        $this->set(compact('corporateClientNote'));
        $this->set('id',$id);
    }

    /**
     * Delete method
     *
     * @param string|null $id Corporate Client Note id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null, $corporate_client_id = null)
    {
        $this->viewBuilder()->setLayout('popup-view');
        $this->request->allowMethod(['post', 'delete']);
        $corporateClientNote = $this->CorporateClientNotes->get($id);
        if ($this->CorporateClientNotes->delete($corporateClientNote)) {
            $this->Flash->success(__('The corporate client note has been deleted.'));
            if($id){
                    return $this->redirect(['action' => 'index', $corporate_client_id]);
                }
                else{
                    return $this->redirect(['action' => 'index']);
                }
        } else {
            $this->Flash->error(__('The corporate client note could not be deleted. Please, try again.'));
        return $this->redirect(['action' => 'index']);
        }

    }
    // $this->set('id',$id);
}
