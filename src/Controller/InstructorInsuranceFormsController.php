<?php
namespace App\Controller;

use Cake\I18n\Time;
use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Routing\Router;

/**
 * InstructorInsuranceForms Controller
 *
 * @property \App\Model\Table\InstructorInsuranceFormsTable $InstructorInsuranceForms
 *
 * @method \App\Model\Entity\InstructorInsuranceForm[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InstructorInsuranceFormsController extends AppController
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
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index($id = null)
    {
        $this->viewBuilder()->setLayout('popup-view');
        // $this->paginate = [
        //     'contain' => ['Instructors']
        // ];
        // $instructorInsuranceForms = $this->paginate($this->InstructorInsuranceForms);
        // // $instructorInsuranceForms = $this->InstructorInsuranceForms->find()->contain(['Instructors'])->all();
        if($id) {
        $instructorInsuranceForms = $this->InstructorInsuranceForms->findByInstructorId($id)->contain(['Instructors'])->all();
        } else {
        $instructorInsuranceForms = $this->InstructorInsuranceForms->find()->contain(['Instructors'])->all();
        // $this->set('instructor_id');    
        }

        $this->set('instructor_id', $id);  
        $this->set(compact('instructorInsuranceForms','Instructors'));
    }

    /**
     * View method
     *
     * @param string|null $id Instructor Insurance Form id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('popup-view');
        $instructorInsuranceForm = $this->InstructorInsuranceForms->get($id, [
            'contain' => ['Instructors']
        ]);

        $this->set('instructorInsuranceForm', $instructorInsuranceForm);
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
        $instructorInsuranceForm = $this->InstructorInsuranceForms->newEntity();
        if ($this->request->is('post')) {
            $requestData = $this->_RequestData;
            if(!isset($requestData['instructor_id'])){
            // pr($this->request->getData);die;
                $requestData['instructor_id'] = $id;
            }
            if(isset($requestData) && !empty($requestData['document_name']) && $requestData['document_name']['type'] == 'application/pdf'){    
            $requestData['date'] = new Time($requestData['date']);
            $instructorInsuranceForm = $this->InstructorInsuranceForms->patchEntity($instructorInsuranceForm,  $requestData);
            // pr($requestData);die();
            if ($this->InstructorInsuranceForms->save($instructorInsuranceForm)) {
                $this->Flash->success(__('The instructor insurance form has been saved.'));

              if($id){
                    return $this->redirect(['action' => 'index',$id]);
                }else{
                    return $this->redirect(['action' => 'index']);
                }
            }
            $this->Flash->error(__('The instructor insurance form could not be saved. Please, try again.'));
            }else{
                $this->Flash->error(__('Select Pdf File'));
            }
        }
        $instructors = $this->InstructorInsuranceForms->Instructors->find()->all()->combine('id','first_name')->toArray();
        $this->set(compact('instructorInsuranceForm', 'instructors'));
        // $this->set('instructor_id',$id);
    }

    /**
     * Edit method
     *
     * @param string|null $id Instructor Insurance Form id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null, $instructor_id = null)
    {
        $this->viewBuilder()->setLayout('popup-view');
        $instructorInsuranceForm = $this->InstructorInsuranceForms->get($id, [
            'contain' => []
        ]);
        // pr($instructorInsuranceForm->date);die;
        if($this->Auth->user('role_id') == 1){
            $is_admin = true;
            $this->set('is_admin',$is_admin);
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $requestData = $this->_RequestData;
            // pr($requestData);die;
             if(isset($requestData) && !empty($requestData['document_name']) && $requestData['document_name']['type'] == 'application/pdf'){ 
                    $requestData['date'] = new Time($requestData['date']);
                    $instructorInsuranceForm = $this->InstructorInsuranceForms->patchEntity($instructorInsuranceForm, $requestData);
                    if ($this->InstructorInsuranceForms->save($instructorInsuranceForm)) {
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
                        $this->Flash->success(__('The instructor insurance form has been saved.'));
                        if($id){

                        return $this->redirect(['action' => 'index',$instructor_id]);
                        }
                        else{

                        return $this->redirect(['action' => 'index']);

                        }
                    }
                    $this->Flash->error(__('The instructor insurance form could not be saved. Please, try again.'));
                }else{
                    $this->Flash->error(__('Select Pdf File'));
                }
        }
        $instructors = $this->InstructorInsuranceForms->Instructors->find('list', ['limit' => 200]);
        $this->set(compact('instructorInsuranceForm', 'instructors'));
        $this->set('id',$id);
    }

    /**
     * Delete method
     *
     * @param string|null $id Instructor Insurance Form id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null, $instructor_id = null)
    {
        $this->viewBuilder()->setLayout('popup-view');
        $this->request->allowMethod(['post', 'delete']);
        $instructorInsuranceForm = $this->InstructorInsuranceForms->get($id);
        if ($this->InstructorInsuranceForms->delete($instructorInsuranceForm)) {
            if($id){
                    return $this->redirect(['action' => 'index',$instructor_id]);
                }else{
                    return $this->redirect(['action' => 'index']);
                }
            $this->Flash->success(__('The instructor insurance form has been deleted.'));
        } else {
            $this->Flash->error(__('The instructor insurance form could not be deleted. Please, try again.'));
        return $this->redirect(['action' => 'index',$instructor_id]);
        }

    }
}
