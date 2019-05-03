<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Routing\Router;

/**
 * CorporateClientDocuments Controller
 *
 * @property \App\Model\Table\CorporateClientDocumentsTable $CorporateClientDocuments
 *
 * @method \App\Model\Entity\CorporateClientDocument[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CorporateClientDocumentsController extends AppController
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
         $corporateClientDocuments = $this->CorporateClientDocuments->findByCorporateClientId($id)->toArray();
         // pr($corporateClientDocuments); die('ss');
         $this->set('corporate_client_id', $id);
        } else {            
         $corporateClientDocuments = $this->CorporateClientDocuments->find()->toArray();
        }

        $this->set('id',$id);   
        $this->set(compact('corporateClientDocuments'));
    }

    /**
     * View method
     *
     * @param string|null $id Corporate Client Document id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('popup-view');
        $corporateClientDocument = $this->CorporateClientDocuments->get($id, [
            'contain' => ['CorporateClients']
        ]);

        $this->set('corporateClientDocument', $corporateClientDocument);
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
        $corporateClientDocument = $this->CorporateClientDocuments->newEntity();

        if ($this->request->is('post')) {
            if(!isset($this->_RequestData['corporate_client_id'])){
               $this->_RequestData['corporate_client_id'] = $id;
            }
            $corporateClientDocument = $this->CorporateClientDocuments->patchEntity($corporateClientDocument, $this->_RequestData);
            if ($this->CorporateClientDocuments->save($corporateClientDocument)) {
                $this->Flash->success(__('The corporate client document has been saved.'));

                 if($id){
                    return $this->redirect(['action' => 'index', $id]);
                }
                else{
                    return $this->redirect(['action' => 'index']);
                }
            }
            $this->Flash->error(__('The corporate client document could not be saved. Please, try again.'));
        }
        $corporateClients = $this->CorporateClientDocuments->CorporateClients->find('list', ['limit' => 200]);
        $this->set(compact('corporateClientDocument', 'corporateClients'));
        $this->set('id',$id);

    }

    /**
     * Edit method
     *
     * @param string|null $id Corporate Client Document id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null, $corporate_client_id = null)
    {
        $this->viewBuilder()->setLayout('popup-view');

        $corporateClientDocument = $this->CorporateClientDocuments->get($id, [
            'contain' => []
        ]);
        // if($this->Auth->user('role_id') == 1){
        //     $is_admin = true;
        //     $this->set('is_admin',$is_admin);
        // }
        $oldImageName = $corporateClientDocument->document_name;
        $path = Configure::read('ImageUpload.unlinkPathForCorporateClients');

        if ($this->request->is(['patch', 'post', 'put'])) {
            $corporateClientDocument = $this->CorporateClientDocuments->patchEntity($corporateClientDocument, $this->_RequestData);
            if ($this->CorporateClientDocuments->save($corporateClientDocument)) {

                 if(empty($this->_RequestData['document_name']['tmp_name'])){
                    unset($this->_RequestData['document_name']);
                    $oldImageName ='';
                }
                if(!empty($oldImageName)){
                    $filePath = $path . '/'.$oldImageName;
                    if($filePath != '' && file_exists( $filePath ) ){
                        unlink($filePath);
                    }
                }
                $this->Flash->success(__('The corporate client document has been saved.'));
                if($id){
                    return $this->redirect(['action' => 'index', $corporate_client_id]);
                }
                else{
                    return $this->redirect(['action' => 'index']);
                }
            }
            $this->Flash->error(__('The corporate client document could not be saved. Please, try again.'));
        }
        // $corporateClients = $this->CorporateClientDocuments->CorporateClients->find('list', ['limit' => 200]);
        $this->set(compact('corporateClientDocument', 'corporateClients'));
        $this->set('id',$id);
    }

    /**
     * Delete method
     *
     * @param string|null $id Corporate Client Document id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null, $corporate_client_id = null)
    {
        $this->viewBuilder()->setLayout('popup-view');
        $this->request->allowMethod(['post', 'delete']);
        $corporateClientDocument = $this->CorporateClientDocuments->get($id);
        if ($this->CorporateClientDocuments->delete($corporateClientDocument)) {
            $this->Flash->success(__('The corporate client document has been deleted.'));
            if($id){
                    return $this->redirect(['action' => 'index', $corporate_client_id]);
                }
                else{
                    return $this->redirect(['action' => 'index']);
                }
        } else {
            $this->Flash->error(__('The corporate client document could not be deleted. Please, try again.'));
        return $this->redirect(['action' => 'index']);
        }

    }
}
