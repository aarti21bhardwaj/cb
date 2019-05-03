<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * QualificationTypes Controller
 *
 * @property \App\Model\Table\QualificationTypesTable $QualificationTypes
 *
 * @method \App\Model\Entity\QualificationType[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class QualificationTypesController extends AppController
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
        $qualificationTypes = $this->QualificationTypes->find()->contain(['Qualifications'])->all();

        $this->set(compact('qualificationTypes'));
    }

    /**
     * View method
     *
     * @param string|null $id Qualification Type id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $qualificationType = $this->QualificationTypes->get($id, [
            'contain' => ['Qualifications', 'InstructorQualifications']
        ]);

        $this->set('qualificationType', $qualificationType);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $qualificationType = $this->QualificationTypes->newEntity();
        if ($this->request->is('post')) {
            $qualificationType = $this->QualificationTypes->patchEntity($qualificationType, $this->request->getData());
            if ($this->QualificationTypes->save($qualificationType)) {
                $this->Flash->success(__('The qualification type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The qualification type could not be saved. Please, try again.'));
        }
        $qualifications = $this->QualificationTypes->Qualifications->find('list', ['limit' => 200]);
        $this->set(compact('qualificationType', 'qualifications'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Qualification Type id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $qualificationType = $this->QualificationTypes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $qualificationType = $this->QualificationTypes->patchEntity($qualificationType, $this->request->getData());
            if ($this->QualificationTypes->save($qualificationType)) {
                $this->Flash->success(__('The qualification type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The qualification type could not be saved. Please, try again.'));
        }
        $qualifications = $this->QualificationTypes->Qualifications->find('list', ['limit' => 200]);
        $this->set(compact('qualificationType', 'qualifications'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Qualification Type id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $qualificationType = $this->QualificationTypes->get($id);
        if ($this->QualificationTypes->delete($qualificationType)) {
            $this->Flash->success(__('The qualification type has been deleted.'));
        } else {
            $this->Flash->error(__('The qualification type could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
