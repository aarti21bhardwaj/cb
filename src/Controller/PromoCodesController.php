<?php
namespace App\Controller;

use Cake\I18n\Time;
Time::setToStringFormat('yyyy/MM/dd HH:mm');
use App\Controller\AppController;
use Cake\Collection\Collection;

/**
 * PromoCodes Controller
 *
 * @property \App\Model\Table\PromoCodesTable $PromoCodes
 *
 * @method \App\Model\Entity\PromoCode[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PromoCodesController extends AppController
{

    public function isAuthorized($user)
    {
        // pr($user['role']->name); die('ss');
        $action = $this->request->getParam('action');
        // pr($action); die();

        // The add and index actions are always allowed.
        if (in_array($action, ['index', 'view','add','edit','delete','updateStatus']) && $user['role']->name === self::SUPER_ADMIN_LABEL) {
        // pr($action); die('in super admin');
            return true;
        }
        else if (in_array($action, ['index','view','edit','delete','add','updateStatus']) && $user['role']->name === self::TENANT_LABEL) {
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
        $promoCodes = $this->PromoCodes->find()
                                       ->contain(['Tenants', 'CorporateClients'])
                                       ->where(['PromoCodes.tenant_id' =>$loggedInUser['tenant_id']])
                                       ->all();
        $this->set(compact('promoCodes'));
    }

    /**
     * View method
     *
     * @param string|null $id Promo Code id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $loggedInUser = $this->Auth->user();
        $promoCodes = $this->PromoCodes->findById($id)
                                       ->contain(['Tenants.TenantUsers', 'CorporateClients'])
                                       ->where(['PromoCodes.tenant_id'=>$loggedInUser['tenant_id']])
                                       ->first();
        // pr($promoCodes);die;                               
        $this->set('promoCode', $promoCodes);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $promoCode = $this->PromoCodes->newEntity();
        $loggedInUser = $this->Auth->user();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            // pr($data);die;
            $data['tenant_id'] = $loggedInUser['tenant_id'];
            // pr($data);die;
            $data['start_date'] = new Time($data['start_date']);
            $data['end_date'] = new Time($data['end_date']);
            if(!empty($data['promo_code_course_types'])){
                $courseTypes = [];
                foreach ($data['promo_code_course_types'] as $key => $value) {
                    $courseTypes[] = ['course_type_id' => $value];
                    $data['promo_code_course_types'] = $courseTypes;

                } 
            }
            if(!empty($data['email'])){
                $promoCodeEmails = array_map('trim', explode("\n", $this->request->getData('email')));
                foreach ($promoCodeEmails as $key => $value) {
                    $promoCodeEmails[]= [
                    'email' => $value
                ];
                $data['promo_code_emails'] = $promoCodeEmails;
                }
            }

            $promoCode = $this->PromoCodes->patchEntity($promoCode, $data);
            // pr($promoCode);die;
            if ($this->PromoCodes->save($promoCode)) {
                $this->Flash->success(__('The promo code has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The promo code could not be saved. Please, try again.'));
        }



        $this->loadModel('CourseTypes');
        if($loggedInUser['role_id'] == 3){

        $courseTypes = $this->CourseTypes->find()
                                         ->matching('CourseTypeCategories',function ($q) use ($loggedInUser){
                                            return $q->where(['tenant_id'=>$loggedInUser['corporate_client']['tenant_id']]);
                                         })
                                         ->combine('id', 'name')
                                         ->toArray();
        // pr($courseTypes);die();
        $corporateClients = $this->PromoCodes->CorporateClients->find()
                                                               ->where(['tenant_id' => $loggedInUser['corporate_client']['tenant_id']])
                                                               ->all()
                                                               ->combine('id','name')
                                                               ->toArray();

        $tenants = $this->PromoCodes->Tenants->TenantUsers->find()
                                                        ->where(['tenant_id' => $loggedInUser['corporate_client']['tenant_id']])
                                                        ->all()
                                                        ->combine('tenant_id', 'first_name')
                                                        ->toArray();

        } else {
            
        $courseTypes = $this->CourseTypes->find()
                                         ->matching('CourseTypeCategories',function ($q) use ($loggedInUser){
                                            return $q->where(['tenant_id'=>$loggedInUser['tenant_id']]);
                                         })
                                         // ->select('id', 'name')
                                         ->combine('id', 'name')
                                         ->toArray();
        // pr($courseTypes);die();
        $corporateClients = $this->PromoCodes->CorporateClients->find()
                                                               ->where(['tenant_id' => $loggedInUser['tenant_id']])
                                                               ->all()
                                                               ->combine('id','name')
                                                               ->toArray();
        // pr($corporateClients);die();
        $tenants = $this->PromoCodes->Tenants->TenantUsers->find()
                                                        ->where(['tenant_id' => $loggedInUser['tenant_id']])
                                                        ->all()
                                                        ->combine('tenant_id', 'first_name')
                                                        ->toArray();

        }
        $subcontractedClients = [];        
        if($loggedInUser['role']->name == 'tenant'){

        $subcontractedClients = $this->PromoCodes->SubcontractedClients->find()
                                                                       ->contain(['CorporateClients' =>function($q)use($loggedInUser){
                                                                        return $q->where(['CorporateClients.tenant_id'=> $loggedInUser['tenant_id']]);
                                                                           }])
                                                                       ->all()
                                                                       ->combine('id', 'name')
                                                                       ->toArray();
        }
        if($loggedInUser['role']->label == 'TRAINING SITE OWNER'){

        $subcontractedClients = $this->PromoCodes->SubcontractedClients->find()
                                                                       ->where(['training_site_id' => $loggedInUser['training_site_id']])
                                                                       ->all()
                                                                       ->combine('id', 'name')
                                                                       ->toArray();
        }


        // pr($subcontractedClients);die();
        $this->set(compact('promoCode', 'tenants', 'corporateClients','courseTypes','subcontractedClients'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Promo Code id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $loggedInUser = $this->Auth->user();
        $promoCode = $this->PromoCodes->get($id, [
            'contain' => ['PromoCodeCourseTypes', 'PromoCodeEmails']
            ]);

        $promoCode->promo_code_course_types = (new Collection($promoCode->promo_code_course_types))->extract('course_type_id')->toArray();
        $promoCode->email = (new Collection($promoCode->promo_code_emails))->extract('email')->toArray();
        $promoCode->email = implode("\n", $promoCode->email);

        if ($this->request->is(['patch', 'post', 'put'])) {

            $data = $this->request->getData();
            $data['tenant_id'] = $loggedInUser['tenant_id'];
            $data['start_date'] = new Time($data['start_date']);
            $data['end_date'] = new Time($data['end_date']);
            if(!empty($data['promo_code_course_types'])){
                $courseTypes = [];
                foreach ($data['promo_code_course_types'] as $key => $value) {
                    $courseTypes[] = ['course_type_id' => $value];
                    $data['promo_code_course_types'] = $courseTypes;

                } 
            }
            if(!empty($data['email'])){
                $promoCodeEmails = array_map('trim', explode("\n", $this->request->getData('email')));
                foreach ($promoCodeEmails as $key => $value) {
                    $promoCodeEmails[]= [
                    'email' => $value
                ];
                $data['promo_code_emails'] = $promoCodeEmails;
                }
            }
            $promoCode = $this->PromoCodes->patchEntity($promoCode, $data);
            if ($this->PromoCodes->save($promoCode)) {
                $this->Flash->success(__('The promo code has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The promo code could not be saved. Please, try again.'));
        }

        $this->loadModel('CourseTypes');
        $courseTypes = $this->CourseTypes->find()
        ->select(['id','name'])
        ->contain(['CourseTypeCategories' => function($q)use($loggedInUser){
            return $q->where(['tenant_id' => $loggedInUser['tenant_id']]);
        }])
        ->all()
        ->combine('id', 'name');
        // pr($courseTypes);die;
        $tenants = $this->PromoCodes->Tenants->TenantUsers->find()
        ->all()
        ->combine('id', 'first_name')
        ->toArray();
        $subcontractedClients = $this->PromoCodes->SubcontractedClients->find()->all()->combine('id', 'name')->toArray();
        
        $corporateClients = $this->PromoCodes->CorporateClients->find('list', ['limit' => 200]);
        $this->set(compact('promoCode', 'tenants', 'corporateClients','courseTypes','emails', 'subcontractedClients'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Promo Code id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $promoCode = $this->PromoCodes->get($id);
        if ($this->PromoCodes->delete($promoCode)) {
            $this->Flash->success(__('The promo code has been deleted.'));
        } else {
            $this->Flash->error(__('The promo code could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
        public function updateStatus($id = null)
    {
        $query = $this->request->getAttribute('params')['pass'];
        // pr($query); die();
        $promoCode_id = $query[0];
        $this->request->allowMethod(['post']);
        $promoCode = $this->PromoCodes->get($promoCode_id);
        if($promoCode){
          $status = $query[1];
          if($status == 1){
            $status = 0;
          }else if($status == 0){
            $status = 1;
          }
          $promoCodeData['status'] = $status;
          $promoCode = $this->PromoCodes->patchEntity($promoCode, $promoCodeData);
          $promoCode = $this->PromoCodes->save($promoCode);
            if($promoCode){
              $this->Flash->success(__('Status updated'));
            }else{
              $this->Flash->error(__('Please, try again.'));
            }
        }
        return $this->redirect(['action' => 'index']);
    }
}
