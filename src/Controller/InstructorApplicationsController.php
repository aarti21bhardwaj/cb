<?php
namespace App\Controller;

use Cake\I18n\Time;
use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Routing\Router;

/**
 * InstructorApplications Controller
 *
 * @property \App\Model\Table\InstructorApplicationsTable $InstructorApplications
 *
 * @method \App\Model\Entity\InstructorApplication[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InstructorApplicationsController extends AppController
{
    public function initialize()
    { 
        $this->_RequestData = $this->request->getData();
        parent::initialize();
    }
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
        if (in_array($action, ['index', 'view','add','edit','delete']) && $user['role']->name === self::SUPER_ADMIN_LABEL) {
        // pr($action); die('in super admin');
            return true;
        }
        else if (in_array($action, ['index','view','add','edit','delete']) && $user['role']->name === self::TENANT_LABEL) {
        // pr($action); die('in tenant admin');
            return true;
        }
        else if (in_array($action, ['index', 'view','add','edit','delete']) && $user['role']->name === self::INSTRUCTOR_LABEL) {
        // pr($action); die('in tenant admin');
            return true;
        }
        // All other actions require an id.
        /*if (empty($this->request->getParam('pass.0'))) {
            return $this->redirect(['controller' => 'tenants','action' => 'index']);
        }*/
        return parent::isAuthorized($user);
    }
    public function index($id = null)
    {
        $this->viewBuilder()->setLayout('popup-view');
        // $this->paginate = [
        //     'contain' => ['Instructors']
        // ];
        // $instructorApplications = $this->paginate($this->InstructorApplications);
        if($id) {
            $instructorApplications = $this->InstructorApplications->findByInstructorId($id, [
            'contain' => ['Instructors']
        ])->all();
        // $instructorApplications = $this->InstructorApplications->findByInstructorId($id)->contain(['Instructors'])->all();
        } else {
        $instructorApplications = $this->InstructorApplications->find()->contain(['Instructors'])->all();
        // $this->set('instructor_id');    
        }

        $this->set('instructor_id', $id);  
        $this->set(compact('instructorApplications','Instructors'));
    }

    /**
     * View method
     *
     * @param string|null $id Instructor Application id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('popup-view');
        $instructorApplication = $this->InstructorApplications->get($id, [
            'contain' => ['Instructors']
        ]);

        $this->set('instructorApplication', $instructorApplication);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($id = null)
    {
        $this->viewBuilder()->setLayout('popup-view');
        if($id) {
            $this->set('instructor_id',$id);          
        }
        $instructorApplication = $this->InstructorApplications->newEntity();
        if ($this->request->is('post')) {
            if(!isset($this->_RequestData['instructor_id'])){
            // pr($this->request->getData);die;
                $this->_RequestData['instructor_id'] = $id;
            }
             if(isset($this->_RequestData) && !empty($this->_RequestData['document_name']) && $this->_RequestData['document_name']['type'] == 'application/pdf'){
                $instructorApplication = $this->InstructorApplications->patchEntity($instructorApplication, $this->_RequestData);
                if ($this->InstructorApplications->save($instructorApplication)) {
                    $this->Flash->success(__('The instructor application has been saved.'));

                    if($id){
                        return $this->redirect(['action' => 'index',$id]);
                    }else{
                        return $this->redirect(['action' => 'index']);
                    }
                }
                $this->Flash->error(__('The instructor application could not be saved. Please, try again.'));
             }else{
                $this->Flash->error(__('Select Pdf only'));
             }
        }
        // $instructors = $this->InstructorApplications->Instructors->find('list', ['limit' => 200]);
        $instructors = $this->InstructorApplications->Instructors->find()
                                                ->all()
                                                ->combine('id','first_name')
                                                ->toArray();
        $this->set(compact('instructorApplication', 'instructors'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Instructor Application id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null, $instructor_id = null)
    {
        $this->viewBuilder()->setLayout('popup-view');
        $instructorApplication = $this->InstructorApplications->get($id, [
            'contain' => []

        ]);
         if($this->Auth->user('role_id') == 1){
            $is_admin = true;
            $this->set('is_admin',$is_admin);
        }
        $oldImageName = $instructorApplication->document_name;
        $path = Configure::read('ImageUpload.unlinkPathForInstructorsApplications');
        $path = Router::url('/'.$instructorApplication->document_path.'/'.$instructorApplication->document_name);

        if ($this->request->is(['patch', 'post', 'put'])) {
            if(isset($this->_RequestData) && !empty($this->_RequestData['document_name']) && $this->_RequestData['document_name']['type'] == 'application/pdf'){
                $instructorApplication = $this->InstructorApplications->patchEntity($instructorApplication, $this->_RequestData);
                if ($this->InstructorApplications->save($instructorApplication)) {
                    
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
                    $this->Flash->success(__('The instructor application has been saved.'));
                    if($id){
                    return $this->redirect(['action' => 'index', $instructor_id]);
                    }
                    return $this->redirect(['action' => 'index']);

                }
                $this->Flash->error(__('The instructor application could not be saved. Please, try again.'));
            }else{
                $this->Flash->error(__('Select Pdf only'));
            }
        }
        $instructors = $this->InstructorApplications->Instructors->find('list', ['limit' => 200]);
        $this->set(compact('instructorApplication', 'instructors'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Instructor Application id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null, $instructor_id = null)
    {
        $this->viewBuilder()->setLayout('popup-view');
        // pr('fghjk');
        // pr($id);die;
        $this->request->allowMethod(['post', 'delete']);
        $instructorApplication = $this->InstructorApplications->get($id);
        if ($this->InstructorApplications->delete($instructorApplication)) {
            if($id){
                    return $this->redirect(['action' => 'index',$instructor_id]);
                }else{
                    return $this->redirect(['action' => 'index']);
                    // pr($instructorApplication);die();
                }
            $this->Flash->success(__('The instructor application has been deleted.'));
        } else {
            $this->Flash->error(__('The instructor application could not be deleted. Please, try again.'));
        return $this->redirect(['action' => 'index',$instructor_id]);
        }
            // $this->set(compact('instructorApplication', 'instructors'));
    }   
}
