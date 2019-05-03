<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CourseDisplayTypes Controller
 *
 * @property \App\Model\Table\CourseDisplayTypesTable $CourseDisplayTypes
 *
 * @method \App\Model\Entity\CourseDisplayType[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CourseDisplayTypesController extends AppController
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
        // $this->paginate = [
        //     'contain' => ['Courses', 'DisplayTypes']
        // ];
        $courseDisplayTypes = $this->CourseDisplayTypes->find()->contain(['Courses.CourseTypes', 'DisplayTypes'])->all();

        $this->set(compact('courseDisplayTypes'));
    }

    /**
     * View method
     *
     * @param string|null $id Course Display Type id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $courseDisplayType = $this->CourseDisplayTypes->get($id, [
            'contain' => ['Courses', 'DisplayTypes']
        ]);

        $this->set('courseDisplayType', $courseDisplayType);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $courseDisplayType = $this->CourseDisplayTypes->newEntity();
        if ($this->request->is('post')) {
            $courseDisplayType = $this->CourseDisplayTypes->patchEntity($courseDisplayType, $this->request->getData());
            if ($this->CourseDisplayTypes->save($courseDisplayType)) {
                $this->Flash->success(__('The course display type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The course display type could not be saved. Please, try again.'));
        }
        $courses = $this->CourseDisplayTypes->Courses->find()->contain(['CourseTypes'])->all()->combine('id','course_type.name')->toArray();
        // pr($courseTypes);die;
        $displayTypes = $this->CourseDisplayTypes->DisplayTypes->find('list', ['limit' => 200]);
        $this->set(compact('courseDisplayType', 'courses', 'displayTypes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Course Display Type id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $courseDisplayType = $this->CourseDisplayTypes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $courseDisplayType = $this->CourseDisplayTypes->patchEntity($courseDisplayType, $this->request->getData());
            if ($this->CourseDisplayTypes->save($courseDisplayType)) {
                $this->Flash->success(__('The course display type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The course display type could not be saved. Please, try again.'));
        }
        $courses = $this->CourseDisplayTypes->Courses->find()->contain(['CourseTypes'])->all()->combine('id','course_type.name')->toArray();        
        $displayTypes = $this->CourseDisplayTypes->DisplayTypes->find('list', ['limit' => 200]);
        $this->set(compact('courseDisplayType', 'courses', 'displayTypes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Course Display Type id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $courseDisplayType = $this->CourseDisplayTypes->get($id);
        if ($this->CourseDisplayTypes->delete($courseDisplayType)) {
            $this->Flash->success(__('The course display type has been deleted.'));
        } else {
            $this->Flash->error(__('The course display type could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
