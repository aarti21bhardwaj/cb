<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * DisplayTypes Controller
 *
 * @property \App\Model\Table\DisplayTypesTable $DisplayTypes
 *
 * @method \App\Model\Entity\DisplayType[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DisplayTypesController extends AppController
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
        $displayTypes = $this->paginate($this->DisplayTypes);

        $this->set(compact('displayTypes'));
    }

    /**
     * View method
     *
     * @param string|null $id Display Type id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $displayType = $this->DisplayTypes->get($id, [
            'contain' => ['CourseDisplayTypes']
        ]);

        $this->set('displayType', $displayType);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $displayType = $this->DisplayTypes->newEntity();
        if ($this->request->is('post')) {
            $displayType = $this->DisplayTypes->patchEntity($displayType, $this->request->getData());
            if ($this->DisplayTypes->save($displayType)) {
                $this->Flash->success(__('The display type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The display type could not be saved. Please, try again.'));
        }
        $this->set(compact('displayType'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Display Type id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $displayType = $this->DisplayTypes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $displayType = $this->DisplayTypes->patchEntity($displayType, $this->request->getData());
            if ($this->DisplayTypes->save($displayType)) {
                $this->Flash->success(__('The display type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The display type could not be saved. Please, try again.'));
        }
        $this->set(compact('displayType'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Display Type id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $displayType = $this->DisplayTypes->get($id);
        if ($this->DisplayTypes->delete($displayType)) {
            $this->Flash->success(__('The display type has been deleted.'));
        } else {
            $this->Flash->error(__('The display type could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
