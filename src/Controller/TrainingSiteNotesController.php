<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * TrainingSiteNotes Controller
 *
 * @property \App\Model\Table\TrainingSiteNotesTable $TrainingSiteNotes
 *
 * @method \App\Model\Entity\TrainingSiteNote[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TrainingSiteNotesController extends AppController
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
    public function index($id = null)
    {
        // pr($id);die;
        $this->viewBuilder()->setLayout('popup-view');
        $this->set('training_site_id', $id);
        // pr($id);die;
        if($id) {
        $trainingSiteNotes = $this->TrainingSiteNotes->find()
                                                     ->where(['training_site_id' => $id])
                                                     ->all()
                                                     ->toArray();

            $this->set('instructor_id', $id);  
        }     
                
        $this->set(compact('trainingSiteNotes','trainingSites'));
    }

    
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($id = null)
    {
        $this->viewBuilder()->setLayout('popup-view');
        if($id)
        {
            $this->set('training_site_id',$id);
        }
        $trainingSiteNote = $this->TrainingSiteNotes->newEntity();
        // pr($trainingSiteNote);die;
        if ($this->request->is('post')) {
            if(!isset($this->_RequestData['training_site_id'])){
                $this->_RequestData['training_site_id'] = $id;
            }
            $trainingSiteNote = $this->TrainingSiteNotes->patchEntity($trainingSiteNote, $this->_RequestData);
            if ($this->TrainingSiteNotes->save($trainingSiteNote)) {
                $this->Flash->success(__('The training site note has been saved.'));
                if($id){
                return $this->redirect(['action' => 'index',$id]);
                } else {
                 return $this->redirect(['action' => 'index']);   
                }    
                // return $this->redirect(['controller' => 'TrainingSites','action' => 'view',$id]);
                // }else{
                // return $this->redirect(['controller' => 'TrainingSites','action' => 'view',$id]);    
                // }
            }
            $this->Flash->error(__('The training site note could not be saved. Please, try again.'));
        }
/*        $trainingSites = $this->TrainingSiteNotes->TrainingSites->find()
                                                                ->all()
                                                                ->where('training_site_id' => $id)
                                                                ->combine('id','name')
                                                                ->toArray();*/
            $trainingSites = $this->TrainingSiteNotes->TrainingSites->get($id);

        // pr($trainingSites); die();
        $this->set(compact('trainingSiteNote', 'trainingSites'));
        $this->set('training_site_id',$id);
    }

    /**
     * Edit method
     *
     * @param string|null $id Training Site Note id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null, $training_site_id = null)
    {
        
        
        $this->viewBuilder()->setLayout('popup-view');
        $trainingSiteNote = $this->TrainingSiteNotes->get($id, [
            'contain' => []
        ]);
        if($id)
        { 
            $this->set('training_site_id',$id);
            
            
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            
            $trainingSiteNote = $this->TrainingSiteNotes->patchEntity($trainingSiteNote, $this->_RequestData);
            if ($this->TrainingSiteNotes->save($trainingSiteNote)) {
                $this->Flash->success(__('The training site note has been saved.'));
                    if($id){

                return $this->redirect(['controller' => 'TrainingSites','action' => 'view',$training_site_id]);
                    } else{
                return $this->redirect(['action' => 'index']);

                    }
            }
            $this->Flash->error(__('The training site note could not be saved. Please, try again.'));
        }
        $trainingSites = $this->TrainingSiteNotes->TrainingSites->get($training_site_id);
        // $trainingSites = $this->TrainingSiteNotes->TrainingSites->find('list', ['limit' => 200]);
        $this->set('id',$id);
        $this->set(compact('trainingSiteNote', 'trainingSites'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Training Site Note id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null, $training_site_id = null)
    {
        // pr('note id');
        // pr($id);
        // pr('training site id');
        // pr($training_site_id);die;
        $this->request->allowMethod(['post', 'delete']);
        $trainingSiteNote = $this->TrainingSiteNotes->get($id);
        if ($this->TrainingSiteNotes->delete($trainingSiteNote)) {
            $this->Flash->success(__('The training site note has been deleted.'));
            if($training_site_id){
                return $this->redirect(['action' => 'index',$training_site_id]);
                }else{
                return $this->redirect(['action' => 'index']);    
                }
        } else {
            $this->Flash->error(__('The training site note could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
