<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Collection\Collection;

/**
 * TextClips Controller
 *
 * @property \App\Model\Table\TextClipsTable $TextClips
 *
 * @method \App\Model\Entity\TextClip[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TextClipsController extends AppController
{

    public function initialize()
    {
        $this->_RequestData = $this->request->getData();
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->Auth->allow(['clips']);
    }

    /**
    * This method is authorize User for various actions
    *
    * @param mixed[] $user contains users data .
    * @return void
    **/
    public function isAuthorized($user)
    {
        // pr($user['role']->name); die('ss');
        $action = $this->request->getParam('action');
        // pr($action); die();

        // The add and index actions are always allowed.
        if (in_array($action, ['index', 'view','add','edit','delete','clips']) && $user['role']->name === self::SUPER_ADMIN_LABEL) {
        // pr($action); die('in super admin');
            return true;
        }
        else if (in_array($action, ['add','index','view','edit','delete','clips']) && $user['role']->name === self::TENANT_LABEL) {
        // pr($action); die('in tenant admin');
            return true;
        }
        else if (in_array($action, ['index','view']) && $user['role']->name === self::USER_LABEL) {
        // pr($action); die('in tenant admin');
            return true;
        }
        // All other actions require an id.
        /*if (empty($this->request->getParam('pass.0'))) {
            return $this->redirect(['controller' => 'tenants','action' => 'index']);
        }*/
        return parent::isAuthorized($user);
    }

    public function clips(){
        $loggedInUser = $this->Auth->user();
        if($loggedInUser['role']->name == self::SUPER_ADMIN_LABEL){
            $tenants = $this->TextClips
                                    ->find('all')
                                    ->where(['status' => 1])
                                    ->all()
                                    ->combine('name','description')
                                    ->toArray();
        }else{
            $tenants = $this->TextClips
                                    ->find()
                                    ->where(['tenant_id'=>$loggedInUser['tenant_id'],'status' => 1])
                                    ->all()
                                    ->combine('name','description')
                                    ->toArray();
        }
        $jData = [];
        foreach ($tenants as $key => $value) {
            $jData[] = [
                        'text' => $key,
                        'value' => $value
                        ];
        }
        $this->set('data',$jData);
        $this->set('_serialize', ['data']);
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Tenants']
        ];
        $textClips = $this->paginate($this->TextClips);

        $loggedInUser = $this->Auth->user();
        if($loggedInUser['role']->name == self::TENANT_LABEL){
          $textClips = $this->TextClips->find()
                                              ->contain(['Tenants'])
                                              ->where(['TextClips.tenant_id ='=>$loggedInUser['tenant_id']])
                                              ->all()
                                              ->toArray();
                                              
        }else if($loggedInUser['role']->name == self::SUPER_ADMIN_LABEL){
        $textClips = $this->TextClips
                                    ->find()
                                    ->contain(['Tenants'])
                                    ->all();
        }
        $this->set('loggedInUser', $loggedInUser);

        $this->set(compact('textClips'));
    }

    /**
     * View method
     *
     * @param string|null $id Text Clip id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $textClip = $this->TextClips->get($id, [
            'contain' => ['Tenants']
        ]);

        $this->set('textClip', $textClip);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $loggedInUser = $this->Auth->user();
        $textClip = $this->TextClips->newEntity();
        if ($this->request->is('post')) {
            if($loggedInUser['role']->name == 'tenant'){
                $this->_RequestData['tenant_id'] = $loggedInUser['tenant_id'];
            }
            $textClip = $this->TextClips->patchEntity($textClip, $this->_RequestData);
            if ($this->TextClips->save($textClip)) {
                $this->Flash->success(__('The text clip has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The text clip could not be saved. Please, try again.'));
        }

        if($loggedInUser['role']->name == self::SUPER_ADMIN_LABEL){
            $tenants = $this->TextClips->Tenants->find()->all()->combine('id','center_name')->toArray();
        }else{

            $tenants = $this->TextClips->Tenants->find()
                                                ->where(['id'=>$loggedInUser['tenant_id']])
                                                ->all()
                                                ->combine('id','center_name')
                                                ->toArray();
        }
        $this->set(compact('textClip', 'tenants','loggedInUser'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Text Clip id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $loggedInUser = $this->Auth->user();
        $textClip = $this->TextClips->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            if($loggedInUser['role']->name == 'tenant'){
                $this->_RequestData['tenant_id'] = $loggedInUser['tenant_id'];
            }
            $textClip = $this->TextClips->patchEntity($textClip, $this->_RequestData);
            if ($this->TextClips->save($textClip)) {
                $this->Flash->success(__('The text clip has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The text clip could not be saved. Please, try again.'));
        }
        if($loggedInUser['role']->name == self::SUPER_ADMIN_LABEL){
            $tenants = $this->TextClips->Tenants->find()->all()->combine('id','center_name')->toArray();
        }else{

            $tenants = $this->TextClips->Tenants->find()
                                                ->where(['id'=>$loggedInUser['tenant_id']])
                                                ->all()
                                                ->combine('id','center_name')
                                                ->toArray();
        }
        $this->set(compact('textClip', 'tenants','loggedInUser'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Text Clip id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $textClip = $this->TextClips->get($id);
        if ($this->TextClips->delete($textClip)) {
            $this->Flash->success(__('The text clip has been deleted.'));
        } else {
            $this->Flash->error(__('The text clip could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
