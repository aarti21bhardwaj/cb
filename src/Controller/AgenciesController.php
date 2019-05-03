<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Agencies Controller
 *
 * @property \App\Model\Table\AgenciesTable $Agencies
 *
 * @method \App\Model\Entity\Agency[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AgenciesController extends AppController
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
            $agencies = $this->paginate($this->Agencies);

        $this->set(compact('agencies'));
    }

    /**
     * View method
     *
     * @param string|null $id Agency id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $agency = $this->Agencies->get($id, [
            'contain' => ['CourseTypes']
        ]);

        $this->set('agency', $agency);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $agency = $this->Agencies->newEntity();
        if ($this->request->is('post')) {
            $agency = $this->Agencies->patchEntity($agency, $this->_RequestData);
            if ($this->Agencies->save($agency)) {
                $this->Flash->success(__('The agency has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The agency could not be saved. Please, try again.'));
        }
        $this->set(compact('agency'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Agency id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $agency = $this->Agencies->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $agency = $this->Agencies->patchEntity($agency, $this->_RequestData);
            if ($this->Agencies->save($agency)) {
                $this->Flash->success(__('The agency has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The agency could not be saved. Please, try again.'));
        }
        $this->set(compact('agency'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Agency id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $agency = $this->Agencies->get($id);
        if ($this->Agencies->delete($agency)) {
            $this->Flash->success(__('The agency has been deleted.'));
        } else {
            $this->Flash->error(__('The agency could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
