<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Routing\Router;

/**
 * InstructorReferences Controller
 *
 * @property \App\Model\Table\InstructorReferencesTable $InstructorReferences
 *
 * @method \App\Model\Entity\InstructorReference[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InstructorReferencesController extends AppController
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
        // $instructorReferences = $this->paginate($this->InstructorReferences);
        if($id) {
         $instructorReferences = $this->InstructorReferences->findByInstructorId($id)->contain(['Instructors'])->all();            
            $this->set('instructor_id', $id);
        } else {            
         $instructorReferences = $this->InstructorReferences->find()->contain(['Instructors'])->all();
        }
        $this->set('instructor_id', $id);
        $this->set(compact('instructorReferences','Instructors'));
    }

    /**
     * View method
     *
     * @param string|null $id Instructor Reference id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->viewBuilder()->setLayout('popup-view');
        // $instructorReference = $this->InstructorReferences->get($id, [
        //     'contain' => ['Instructors']
        // ]);

        // $this->set('instructorReference', $instructorReference);

        $instructorReference = $this->InstructorReferences->find()->contain(['Instructors'])->all();
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
        $instructorReference = $this->InstructorReferences->newEntity();
        if ($this->request->is('post')) {
            if(!isset($this->_RequestData['instructor_id'])){
            // pr($this->request->getData);die;
                $this->_RequestData['instructor_id'] = $id;
            }
            $instructorReference = $this->InstructorReferences->patchEntity($instructorReference, $this->_RequestData);
            if ($this->InstructorReferences->save($instructorReference)) {
                $this->Flash->success(__('The instructor reference has been saved.'));
                if($id){
                    return $this->redirect(['action' => 'index',$id]);
                }else{
                    return $this->redirect(['action' => 'index']);
                }
            }
            $this->Flash->error(__('The instructor reference could not be saved. Please, try again.'));
        }
        // $instructors = $this->InstructorReferences->Instructors->find('list', ['limit' => 200]);
        $instructors= $this->InstructorReferences->Instructors->find()->all()->combine('id','first_name')->toArray();
        
        $this->set(compact('instructorReference', 'instructors'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Instructor Reference id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null, $instructor_id = null)
    {
        $this->viewBuilder()->setLayout('popup-view');
        // pr($id);die();
        $instructorReference
         = $this->InstructorReferences->get($id, [
            'contain' => []
        ]);
         if($this->Auth->user('role_id') == 1){
            $is_admin = true;
            $this->set('is_admin',$is_admin);
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $instructorReference = $this->InstructorReferences->patchEntity($instructorReference, $this->_RequestData);
            if ($this->InstructorReferences->save($instructorReference)) {
                $this->Flash->success(__('The instructor reference has been saved.'));
                // pr($id);die();
                if($id){
                // pr($instructorReference);die();

                return $this->redirect(['action' => 'index', $instructor_id]);
                }
                return $this->redirect(['action' => 'index']);

            }
            $this->Flash->error(__('The instructor reference could not be saved. Please, try again.'));
        }
                $instructors= $this->InstructorReferences->Instructors->find()->all()->combine('id','first_name')->toArray();        
                $this->set(compact('instructorReference', 'instructors'));
                // $this->set('id',$id);
                $this->set('Instructor_id',$id);
    }

    /**
     * Delete method
     *
     * @param string|null $id Instructor Reference id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null, $instructor_id = null)
    {
        $this->viewBuilder()->setLayout('popup-view');
        $this->request->allowMethod(['post', 'delete']);
        $instructorReference = $this->InstructorReferences->get($id);
        if ($this->InstructorReferences->delete($instructorReference)) {
            if($id){
                // pr($instructorReference);die();

                return $this->redirect(['action' => 'index', $instructor_id]);
                }
                return $this->redirect(['action' => 'index']);

            $this->Flash->success(__('The instructor reference has been deleted.'));
        } else {
            $this->Flash->error(__('The instructor reference could not be deleted. Please, try again.'));
        return $this->redirect(['action' => 'index',$instructor_id]);
        }

    }
}
