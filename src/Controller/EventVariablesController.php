<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * EventVariables Controller
 *
 * @property \App\Model\Table\EventVariablesTable $EventVariables
 *
 * @method \App\Model\Entity\EventVariable[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EventVariablesController extends AppController
{

    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        // pr($action); die();

        // The add and index actions are always allowed.
        if (in_array($action, ['index', 'view','add','edit','delete','privateCourse','roster','removeRoster','notes','printRoster','processCards','aha3Pdf']) && $user['role']->name === self::SUPER_ADMIN_LABEL) {
            return true;
        }
        else if (in_array($action, ['index','view','add','edit','delete','privateCourse','roster','removeRoster','notes','printRoster','addStudentToCourse','register','exportCsv','processCards','aha3Pdf']) && $user['role']->name === self::INSTRUCTOR_LABEL) {
            return true;
        }

        else if (in_array($action, ['index','view','add','edit','delete']) && $user['role']->name === self::TENANT_LABEL) {

            return true;
        }
        else if (in_array($action, ['index','view','add','edit','delete','privateCourse','roster','removeRoster','notes','register','addStudentToCourse','closeCourse','exportCsv','reopenCourse','printRoster','processCards','aha3Pdf']) && $user['role']->name === self::CLIENT_LABEL) {

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
        $this->paginate = [
            'contain' => ['Events']
        ];
        $eventVariables = $this->paginate($this->EventVariables);

        $this->set(compact('eventVariables'));
    }

    /**
     * View method
     *
     * @param string|null $id Event Variable id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $eventVariable = $this->EventVariables->get($id, [
            'contain' => ['Events']
        ]);

        $this->set('eventVariable', $eventVariable);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $eventVariable = $this->EventVariables->newEntity();
        if ($this->request->is('post')) {
            $eventVariable = $this->EventVariables->patchEntity($eventVariable, $this->request->getData());
            if ($this->EventVariables->save($eventVariable)) {
                $this->Flash->success(__('The event variable has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The event variable could not be saved. Please, try again.'));
        }
        $events = $this->EventVariables->Events->find('list', ['limit' => 200]);
        $this->set(compact('eventVariable', 'events'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Event Variable id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $eventVariable = $this->EventVariables->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $eventVariable = $this->EventVariables->patchEntity($eventVariable, $this->request->getData());
            if ($this->EventVariables->save($eventVariable)) {
                $this->Flash->success(__('The event variable has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The event variable could not be saved. Please, try again.'));
        }
        $events = $this->EventVariables->Events->find('list', ['limit' => 200]);
        $this->set(compact('eventVariable', 'events'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Event Variable id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $eventVariable = $this->EventVariables->get($id);
        if ($this->EventVariables->delete($eventVariable)) {
            $this->Flash->success(__('The event variable has been deleted.'));
        } else {
            $this->Flash->error(__('The event variable could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
