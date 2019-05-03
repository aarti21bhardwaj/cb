<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CourseTypeQualifications Controller
 *
 * @property \App\Model\Table\CourseTypeQualificationsTable $CourseTypeQualifications
 *
 * @method \App\Model\Entity\CourseTypeQualification[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CourseTypeQualificationsController extends AppController
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
        
        $courseTypeQualifications = $this->CourseTypeQualifications->find()->contain(['CourseTypes','Qualifications'])->all();

        $this->set(compact('courseTypeQualifications'));
    }

    /**
     * View method
     *
     * @param string|null $id Course Type Qualification id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $courseTypeQualification = $this->CourseTypeQualifications->get($id, [
            'contain' => ['CourseTypes', 'Qualifications']
        ]);

        $this->set('courseTypeQualification', $courseTypeQualification);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $courseTypeQualification = $this->CourseTypeQualifications->newEntity();
        if ($this->request->is('post')) {
            $courseTypeQualification = $this->CourseTypeQualifications->patchEntity($courseTypeQualification, $this->request->getData());
            if ($this->CourseTypeQualifications->save($courseTypeQualification)) {
                $this->Flash->success(__('The course type qualification has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The course type qualification could not be saved. Please, try again.'));
        }
        $courseTypes = $this->CourseTypeQualifications->CourseTypes->find('list', ['limit' => 200]);
        $qualifications = $this->CourseTypeQualifications->Qualifications->find('list', ['limit' => 200]);
        $this->set(compact('courseTypeQualification', 'courseTypes', 'qualifications'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Course Type Qualification id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $courseTypeQualification = $this->CourseTypeQualifications->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $courseTypeQualification = $this->CourseTypeQualifications->patchEntity($courseTypeQualification, $this->request->getData());
            if ($this->CourseTypeQualifications->save($courseTypeQualification)) {
                $this->Flash->success(__('The course type qualification has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The course type qualification could not be saved. Please, try again.'));
        }
        $courseTypes = $this->CourseTypeQualifications->CourseTypes->find('list', ['limit' => 200]);
        $qualifications = $this->CourseTypeQualifications->Qualifications->find('list', ['limit' => 200]);
        $this->set(compact('courseTypeQualification', 'courseTypes', 'qualifications'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Course Type Qualification id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $courseTypeQualification = $this->CourseTypeQualifications->get($id);
        if ($this->CourseTypeQualifications->delete($courseTypeQualification)) {
            $this->Flash->success(__('The course type qualification has been deleted.'));
        } else {
            $this->Flash->error(__('The course type qualification could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
