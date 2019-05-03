<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Routing\Router;

/**
 * CourseDocuments Controller
 *
 * @property \App\Model\Table\CourseDocumentsTable $CourseDocuments
 *
 * @method \App\Model\Entity\CourseDocument[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CourseDocumentsController extends AppController
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
       if($id){

        $courseDocuments = $this->CourseDocuments->findByCourseId($id)->contain(['Courses'])->all();
       } else {

        $courseDocuments = $this->CourseDocuments->find()->contain(['Courses'])->all();
       }


        $this->set(compact('courseDocuments','Courses'));
        $this->set('course_id',$id);
    }

    /**
     * View method
     *
     * @param string|null $id Course Document id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $courseDocument = $this->CourseDocuments->get($id, [
            'contain' => ['Courses']
        ]);

        $this->set('courseDocument', $courseDocument);
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
            $this->set('course_id',$id);
                }
        
        $courseDocument = $this->CourseDocuments->newEntity();
        if ($this->request->is('post')) {
            if(!isset($this->_RequestData['course_id'])){
            // pr($this->request->getData);die;
                $this->_RequestData['course_id'] = $id;
            }
            $courseDocument = $this->CourseDocuments->patchEntity($courseDocument, $this->_RequestData);
            if ($this->CourseDocuments->save($courseDocument)) {
                $this->Flash->success(__('The course document has been saved.'));
                if($id){
                return $this->redirect(['action' => 'index',$id]);
                }
                else{
                return $this->redirect(['action' => 'index']);    
                }
            }
            $this->Flash->error(__('The course document could not be saved. Please, try again.'));
        }
        $courses = $this->CourseDocuments->Courses->find('list', ['limit' => 200]);
        $this->set('course_id',$id);
        $this->set(compact('courseDocument', 'courses'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Course Document id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $courseDocument = $this->CourseDocuments->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $courseDocument = $this->CourseDocuments->patchEntity($courseDocument, $this->_RequestData);
            if ($this->CourseDocuments->save($courseDocument)) {
                $this->Flash->success(__('The course document has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The course document could not be saved. Please, try again.'));
        }
        $courses = $this->CourseDocuments->Courses->find('list', ['limit' => 200]);
        $this->set(compact('courseDocument', 'courses'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Course Document id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null, $course_id = null)
    {
        $this->viewBuilder()->setLayout('popup-view');
        $this->request->allowMethod(['post', 'delete']);
        $courseDocument = $this->CourseDocuments->get($id);
        if ($this->CourseDocuments->delete($courseDocument)) {
            if($id){
                    return $this->redirect(['action' => 'index',$course_id]);
                }else{
                    return $this->redirect(['action' => 'index']);
                    // pr($instructorApplication);die();
                }
            $this->Flash->success(__('The course document has been deleted.'));
        } else {
            $this->Flash->error(__('The course document could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index',$course_id]);
    }
}
