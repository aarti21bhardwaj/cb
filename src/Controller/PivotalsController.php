<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Pivotals Controller
 *
 * @property \App\Model\Table\PivotalsTable $Pivotals
 *
 * @method \App\Model\Entity\Pivotal[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PivotalsController extends AppController
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
        $pivotals = $this->Pivotals->find()->contain(['KeyCategories'])->all();
        $this->set(compact('pivotals'));
    }

    /**
     * View method
     *
     * @param string|null $id Pivotal id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $pivotal = $this->Pivotals->get($id, [
            'contain' => ['KeyCategories']
        ]);

        $this->set('pivotal', $pivotal);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $pivotal = $this->Pivotals->newEntity();
        if ($this->request->is('post')) {
            $pivotal = $this->Pivotals->patchEntity($pivotal, $this->request->getData());
            if ($this->Pivotals->save($pivotal)) {
                $this->Flash->success(__('The pivotal has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pivotal could not be saved. Please, try again.'));
        }
        $keyCategories = $this->Pivotals->KeyCategories->find('list', ['limit' => 200]);
        $this->set(compact('pivotal', 'keyCategories'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Pivotal id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $pivotal = $this->Pivotals->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $pivotal = $this->Pivotals->patchEntity($pivotal, $this->request->getData());
            if ($this->Pivotals->save($pivotal)) {
                $this->Flash->success(__('The pivotal has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The pivotal could not be saved. Please, try again.'));
        }
        $keyCategories = $this->Pivotals->KeyCategories->find('list', ['limit' => 200]);
        $this->set(compact('pivotal', 'keyCategories'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Pivotal id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $pivotal = $this->Pivotals->get($id);
        if ($this->Pivotals->delete($pivotal)) {
            $this->Flash->success(__('The pivotal has been deleted.'));
        } else {
            $this->Flash->error(__('The pivotal could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
