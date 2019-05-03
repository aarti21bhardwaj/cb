<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;


/**
 * IndexSettings Controller
 *
 * @property \App\Model\Table\IndexSettingsTable $IndexSettings
 *
 * @method \App\Model\Entity\IndexSetting[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class IndexSettingsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
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
        else if (in_array($action, ['index','view','edit','delete','add']) && $user['role']->name === self::TENANT_LABEL) {
        // pr($action); die('in tenant admin');
            return true;
        }
        // All other actions require an id.
        /*if (empty($this->request->getParam('pass.0'))) {
            return $this->redirect(['controller' => 'tenants','action' => 'index']);
        }*/
        return parent::isAuthorized($user);
    }
    public function index()
    {
        $this->loadModel('Courses');
        $this->loadModel('Students');

        $studentMeta = Configure::read('Students');
        $courseMeta = Configure::read('Courses');

        $this->loadModel('TenantUsers');
        // $indexSettings = $this->paginate($this->IndexSettings);
        // pr($indexSettings);
        // pr($meta);
        $loggedInUser = $this->Auth->user();
        $addButtonDisable = false;


        $indexSettings = $this->IndexSettings->findByFor_id($loggedInUser['id'])
                                             ->all();
        // pr(sizeof($indexSettings));die;
        // pr($indexSettings[0]);die;
        // $difference = array_diff($meta, $array2);

        if($indexSettings && sizeof($indexSettings) == 2){
            $addButtonDisable = true;
        }


        $this->set(compact('indexSettings','addButtonDisable','studentMeta','courseMeta'));
    }

    /**
     * View method
     *
     * @param string|null $id Index Setting id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $indexSetting = $this->IndexSettings->get($id, [
            'contain' => []
        ]);

        $this->set('indexSetting', $indexSetting);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->loadModel('Courses');
        $indexName =['Courses','Students'];
        // $indexName = ['Courses','Students','Instructors','Locations','TrainingSites','CorporateClients'];
        // pr($indexName);die;
        $meta = Configure::read('Courses');
        $loggedInUser = $this->Auth->user();
        $dataPresent = $this->IndexSettings->findByFor_id($loggedInUser['id'])->toArray();
        if($dataPresent && sizeof($dataPresent) == 1){
            // pr(sizeof($dataPresent));die;
            if($dataPresent[0]->index_name == "Courses"){
               $indexName = ['Students'];
               $meta = Configure::read('Students');
            }else{
               $indexName = ['Courses']; 
               $meta = Configure::read('Courses');
            }
            // pr($indexName);die;
        }elseif($dataPresent && sizeof($dataPresent) == 2){
            throw new Exception("Page Not Found");
        }


        $indexSetting = $this->IndexSettings->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['for_id'] = $loggedInUser['id'];
            $data['for_name'] = $loggedInUser['role']->name;
            if($loggedInUser['role']->name){
                $data['for_name'] = $loggedInUser['role']->name.'_'.'user';   
            }
            $indexSetting = $this->IndexSettings->patchEntity($indexSetting, $data);
            if ($this->IndexSettings->save($indexSetting)) {
                // pr($indexSetting);die('saved');
                $this->Flash->success(__('The index setting has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            // pr($indexSetting);die('nahi hua be');
            $this->Flash->error(__('The index setting could not be saved. Please, try again.'));
        }
        // pr($meta);die;
        // $fors = $this->IndexSettings->Fors->find('list', ['limit' => 200]);
        $this->set(compact('indexSetting','meta','indexName'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Index Setting id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $indexSetting = $this->IndexSettings->get($id);
        $loggedInUser = $this->Auth->user();
        // pr($indexSetting->index_name);die;
        $indexName =['Courses','Students'];
         // $indexName = ['Courses','Students','Instructors','Locations','TrainingSites','CorporateClients'];
        $meta = Configure::read('Courses');
        if($indexSetting->index_name == 'Students'){
            $meta = Configure::read('Students');
            
        }
         // pr(json_decode($meta));die;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $data['for_id'] = $loggedInUser['id'];
            $data['for_name'] = $loggedInUser['role']->name;
            if($loggedInUser['role']->name){
                $data['for_name'] = $loggedInUser['role']->name.'_'.'user';   
            }
            $indexSetting = $this->IndexSettings->patchEntity($indexSetting, $data);
            if ($this->IndexSettings->save($indexSetting)) {
                $this->Flash->success(__('The index setting has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The index setting could not be saved. Please, try again.'));
        }
        $this->set(compact('indexSetting','indexName','meta'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Index Setting id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $indexSetting = $this->IndexSettings->get($id);
        if ($this->IndexSettings->delete($indexSetting)) {
            $this->Flash->success(__('The index setting has been deleted.'));
        } else {
            $this->Flash->error(__('The index setting could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
