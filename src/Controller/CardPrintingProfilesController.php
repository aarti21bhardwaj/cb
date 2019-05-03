<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Collection\Collection;

/**
 * CardPrintingProfiles Controller
 *
 * @property \App\Model\Table\CardPrintingProfilesTable $CardPrintingProfiles
 *
 * @method \App\Model\Entity\CardPrintingProfile[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CardPrintingProfilesController extends AppController
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
        else if (in_array($action, ['index','view','add','edit','delete']) && $user['role']->name === self::TENANT_LABEL) {
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
        $loggedInUser = $this->Auth->user();
        // $cardPrintingProfiles = $this->paginate($this->CardPrintingProfiles);
        $cardPrintingProfiles = $this->CardPrintingProfiles->find()
                                    ->contain(['CardPrintingProfileTrainingSites' => function($q)use($loggedInUser){
                                        return $q->where(['CardPrintingProfileTrainingSites.tenant_id' => $loggedInUser['tenant_id']]);
                                    }])
                                    ->all();


        $this->set('loggedInUser', $loggedInUser);
        $this->set(compact('cardPrintingProfiles','trainingSites'));
    }

    /**
     * View method
     *
     * @param string|null $id Card Printing Profile id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $cardPrintingProfile = $this->CardPrintingProfiles->get($id, [
            'contain' => ['CardPrintingProfileTrainingSites']
        ]);

        $this->set('cardPrintingProfile', $cardPrintingProfile);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $cardPrintingProfile = $this->CardPrintingProfiles->newEntity();
        $loggedInUser = $this->Auth->user();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['tenant_id'] = $loggedInUser['tenant_id'];

            if(!empty($data['card_printing_profile_training_sites'])){
                foreach ($data['card_printing_profile_training_sites'] as $key => $value) {
                    $data['card_printing_profile_training_sites'][] = [
                                                'training_site_id' => $value,
                                                'tenant_id' => $loggedInUser['tenant_id'
                                                ]];
                }
            }
            // pr($data); die('qwerty');

            $cardPrintingProfile = $this->CardPrintingProfiles->patchEntity($cardPrintingProfile, $data);
            // pr($cardPrintingProfile); die('qwerty');
            if ($this->CardPrintingProfiles->save($cardPrintingProfile)) {
                $this->Flash->success(__('The card printing profile has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The card printing profile could not be saved. Please, try again.'));
        }
        $this->loadModel('TrainingSites');
        $trainingSites = $this->TrainingSites->find()->where(['tenant_id' => $loggedInUser['tenant_id']])->all()->combine('id','name')->toArray();
        // pr($trainingSites); die();
        $cardAlignment= [
                                '-8' => '-8' , '-7' => '-7' , '-6' => '-6', '-5' => '-5' , '-4' => '-4', '-3' => '-3', '-2' => '-2', '-1' => '-1', '0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8'
                            ];
        $this->set(compact('cardPrintingProfile','trainingSites','loggedInUser','cardAlignment'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Card Printing Profile id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $cardPrintingProfile = $this->CardPrintingProfiles->get($id, [
            'contain' => ['CardPrintingProfileTrainingSites.TrainingSites']
        ]);

        $cardPrintingProfile->card_printing_profile_training_sites = (new Collection($cardPrintingProfile->card_printing_profile_training_sites))->extract('training_site_id')->toArray();
        $loggedInUser = $this->Auth->user();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $data['tenant_id'] = $loggedInUser['tenant_id'];
            if(!empty($data['card_printing_profile_training_sites'])){
                $trainingSites = [];
                foreach ($data['card_printing_profile_training_sites'] as $key => $value) {
                    $trainingSites[] = [
                                            'training_site_id' => $value,
                                             'tenant_id' => $loggedInUser['tenant_id']
                                        ];
                    $data['card_printing_profile_training_sites'] = $trainingSites;

                } 
            }
            $cardPrintingProfile = $this->CardPrintingProfiles->patchEntity($cardPrintingProfile, $data);
            
            if ($this->CardPrintingProfiles->save($cardPrintingProfile)) {
                $this->Flash->success(__('The card printing profile has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The card printing profile could not be saved. Please, try again.'));

        }
        $this->loadModel('TrainingSites');
        $trainingSites = $this->TrainingSites->find()
        ->select(['id','name'])
        ->all()
        ->combine('id', 'name')
        ->toArray();
        $cardAlignment= [
                                '-8' => '-8' , '-7' => '-7' , '-6' => '-6', '-5' => '-5' , '-4' => '-4', '-3' => '-3', '-2' => '-2', '-1' => '-1', '0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8'
                            ];
        // pr($cardAlignmentLeft);die();                    
        // $cardAlignment= [
        //                         '-8' => '-8' , '-7' => '-7' , '-6' => '-6', '-5' => '-5' , '-4' => '-4', '-3' => '-3', '-2' => '-2', '-1' => '-1', '0' => '0', '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8'
        //                     ];
        $this->set(compact('cardPrintingProfile','trainingSites','loggedInUser','cardAlignment'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Card Printing Profile id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $cardPrintingProfile = $this->CardPrintingProfiles->get($id);
        if ($this->CardPrintingProfiles->delete($cardPrintingProfile)) {
            $this->Flash->success(__('The card printing profile has been deleted.'));
        } else {
            $this->Flash->error(__('The card printing profile could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
