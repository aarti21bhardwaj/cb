<?php
namespace App\Controller;

use Cake\I18n\Time;
Time::setToStringFormat('yyyy/MM/dd HH:mm');
use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Routing\Router;

/**
 * InstructorQualifications Controller
 *
 * @property \App\Model\Table\InstructorQualificationsTable $InstructorQualifications
 *
 * @method \App\Model\Entity\InstructorQualification[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InstructorQualificationsController extends AppController
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
        //     'contain' => ['Instructors', 'Qualifications', 'QualificationTypes']
        // ];
        // $instructorQualifications = $this->paginate($this->InstructorQualifications);
        // pr($id);
        if($id) {
         $instructorQualifications = $this->InstructorQualifications->findByInstructorId($id)->contain(['Instructors', 'Qualifications', 'QualificationTypes'])->all();  
        } else {            
         $instructorQualifications = $this->InstructorQualifications->find()->contain(['Instructors', 'Qualifications', 'QualificationTypes'])->all();
        }

        $this->set('instructor_id', $id);          
        $this->set(compact('instructorQualifications','Instructors'));
    }

    /**
     * View method
     *
     * @param string|null $id Instructor Qualification id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('popup-view');
        $instructorQualification = $this->InstructorQualifications->get($id, [
            'contain' => ['Instructors', 'Qualifications', 'QualificationTypes']
        ]);

        $this->set('instructorQualification', $instructorQualification);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($id = null, $type = null)
    {   

        $this->viewBuilder()->setLayout('popup-view');
        if($id) {
            $this->set('instructor_id',$id);          
        } 
        $instructorQualification = $this->InstructorQualifications->newEntity();
        // pr($instructorQualification);
        if ($this->request->is('post')) {
            if(!isset($this->_RequestData['instructor_id'])){
                $this->_RequestData['instructor_id'] = $id;
            }
            $requestData = $this->_RequestData;
            if(isset($requestData) && !empty($requestData['document_name']) && $requestData['document_name']['type'] == 'application/pdf'){                
            $requestData['expiry_date'] = new Time($requestData['expiry_date']);
            $requestData['last_monitored'] = new Time($requestData['last_monitored']);
            $instructorQualification = $this->InstructorQualifications->patchEntity($instructorQualification, $requestData);
            if ($this->InstructorQualifications->save($instructorQualification)) {
                $this->Flash->success(__('The instructor qualification has been saved.'));
                if($id){
                    return $this->redirect(['action' => 'index',$id]);
                }else{
                    return $this->redirect(['action' => 'index']);
                }

            }
            $this->Flash->error(__('The instructor qualification could not be saved. Please, try again.'));
            }else{
                $this->Flash->error(__('Select Pdf File'));
            }
        }
        // $instructors = $this->InstructorQualifications->Instructors->find('list', ['limit' => 200]);
        $instructors = $this->InstructorQualifications->Instructors->find()
                                                ->all()
                                                ->combine('id','first_name')
                                                ->toArray();
        $qualifications = $this->InstructorQualifications->Qualifications->find('list', ['limit' => 200]);
        $qualificationTypes = $this->InstructorQualifications->QualificationTypes->find('list', ['limit' => 200]);
        $this->set(compact('instructorQualification', 'instructors', 'qualifications', 'qualificationTypes'));
        $this->set('instructor_id', $id);   
    }

    /**
     * Edit method
     *
     * @param string|null $id Instructor Qualification id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null, $instructor_id = null)
    {
        $this->viewBuilder()->setLayout('popup-view');   
        $instructorQualification = $this->InstructorQualifications->get($id, [
            'contain' => []
        ]);
        if($this->Auth->user('role_id') == 1){
            $is_admin = true;
            $this->set('is_admin',$is_admin);
        }

        $oldImageName = $instructorQualification->document_name;
        $path = Configure::read('ImageUpload.unlinkPathForInstructorsFiles');

        if ($this->request->is(['patch', 'post', 'put'])) {
           $requestData = $this->_RequestData;
           
           // pr($this->request->getData());die;
           if(isset($requestData) && !empty($requestData['document_name']) && $requestData['document_name']['type'] == 'application/pdf'){
                $requestData['expiry_date'] = new Time($requestData['expiry_date']);
                $requestData['last_monitored'] = new Time($requestData['last_monitored']);
                // pr($requestData);die;
                $instructorQualification = $this->InstructorQualifications->patchEntity($instructorQualification, $requestData);
                if ($this->InstructorQualifications->save($instructorQualification)) {
                // pr($instructorQualification);die();

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

                    $this->Flash->success(__('The instructor qualification has been saved.'));

                    if($id){
                        return $this->redirect(['action' => 'index',$instructor_id]);
                    }else{
                        return $this->redirect(['action' => 'index']);
                    }

                }
                $this->Flash->error(__('The instructor qualification could not be saved. Please, try again.'));
           }else{
                $this->Flash->error(__('Select Pdf File'));
           }
        }
        // $instructors = $this->InstructorQualifications->Instructors->find('list', ['limit' => 200]);
        $instructors = $this->InstructorQualifications->Instructors->find()
                                                ->all()
                                                ->combine('id','first_name')
                                                ->toArray();
        $qualifications = $this->InstructorQualifications->Qualifications->find('list', ['limit' => 200]);
        $qualificationTypes = $this->InstructorQualifications->QualificationTypes->find('list', ['limit' => 200]);
        $this->set('id', $id);  
        $this->set(compact('instructorQualification', 'instructors', 'qualifications', 'qualificationTypes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Instructor Qualification id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null, $instructor_id = null)
    {
        // pr($instructor_ids); die();
        $this->viewBuilder()->setLayout('popup-view');
        $this->request->allowMethod(['post', 'delete']);
        $instructorQualification = $this->InstructorQualifications->get($id);
        if ($this->InstructorQualifications->delete($instructorQualification))
         {
            if($id){
                    return $this->redirect(['action' => 'index',$instructor_id]);
                }else{
                    return $this->redirect(['action' => 'index']);
                }
            $this->Flash->success(__('The instructor qualification has been deleted.'));
        } else {
            $this->Flash->error(__('The instructor qualification could not be deleted. Please, try again.'));
        return $this->redirect(['action' => 'index',$instructor_id]);

        }       
    }   
}
