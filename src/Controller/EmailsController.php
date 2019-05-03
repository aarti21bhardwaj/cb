<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Collection\Collection;

/**
 * Emails Controller
 *
 * @property \App\Model\Table\EmailsTable $Emails
 *
 * @method \App\Model\Entity\Email[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EmailsController extends AppController
{

    public function initialize()
    { 
        $this->_RequestData = $this->request->getData();
        parent::initialize();
    }

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

        // $emails = $this->Emails->find('list')->contain(['Tenants', 'Events'])->toArray();
        // $tenants = (new Collection($emails))->combine('Tenants.id', 'Tenants.name')->toArray();
        // pr($tenants);die;
        $this->paginate = [
            'contain' => ['Tenants', 'Events']
        ];
        $emails = $this->paginate($this->Emails);
        $this->set(compact('emails'));
        $loggedInUser = $this->Auth->user();
        $emails = $this->Emails->find()
                              ->contain(['Events'])
                              ->where(['tenant_id ='=>$loggedInUser['tenant_id']])
                              ->all()
                              ->toArray();
        
        $this->set('loggedInUser', $loggedInUser);

        $this->set(compact('emails'));
    }

    /**
     * View method
     *
     * @param string|null $id Email id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $email = $this->Emails->get($id, [
            'contain' => ['Tenants', 'Events', 'EmailConfigurations', 'EmailCourseTypes', 'EmailRecipients']
        ]);

        $this->set('email', $email);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->loadModel('CourseTypes');
        $tenantId = $this->Auth->User('tenant_id');
        $email = $this->Emails->newEntity();
        if ($this->request->is('post')) {
            $this->_RequestData['tenant_id'] = $this->Auth->user('tenant_id');
            $data = $this->_RequestData;
            $data['email_configurations'][] = [ 'schedule' => $data['schedule'],
                                                'recipient' => $data['recipient'] ];
            foreach ($data['course_type_id'] as $key => $value) {
                $data['email_course_types'][] = [ 'course_type_id' => $value ];
              }
            if(!empty($data['corporate_ids'])){
               foreach ($data['corporate_ids'] as $key => $value) {
                    $data['email_recipients'][] = [ 'corporate_client_id' => $value ];
                } 
            }
            if(!empty($data['subcontracte_ids'])){
               foreach ($data['subcontracte_ids'] as $key => $value) {
                    $data['email_recipients'][] = [ 'subcontracted_client_id' => $value ];
                } 
            }    
            unset($data['course_type_id']);
            unset($data['corporate_ids']);
            unset($data['subcontracte_ids']);
            // pr($data);die;   
            $email = $this->Emails->patchEntity($email, $data,['associated' => ['EmailConfigurations','EmailCourseTypes','EmailRecipients']]);
            // pr($email);die;
            if ($this->Emails->save($email,['associated' => ['EmailConfigurations','EmailCourseTypes','EmailRecipients']])) {
                $this->Flash->success(__('The email has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The email could not be saved. Please, try again.'));
        }
        $events = $this->Emails->Events->find()->combine('id', 'name')->toArray();
        $courseTypes = $this->CourseTypes->find()
                                         ->matching('CourseTypeCategories', function($q) use($tenantId){
                                                return $q->where(['tenant_id' => $tenantId]);
                                            })
                                         ->combine('id', 'name')
                                         ->toArray();

        $eventVariables = $this->Emails->Events->EventVariables
                               ->find()
                               ->groupBy('event_id')
                               ->map(function($value, $key){
                                return (new Collection($value))->map(function($val){
                                    
                                            $data = [
                                                        'text' => $val->name,
                                                        'value'=> '{{'.$val->variable_key.'}}'
                                                    ];

                                            return $data;
                                        })->toArray();
                               })
                               ->toArray();
        $corporateOptions = [
                                'corporate_admins' => 'Corporate Users',
                                'site_contacts' => 'Corporate Admins',
                                'both' => 'Admins & Site Contacts' 
                            ];

        $subcontractedOptions = [
                                    'corporate_admins' => 'Corporate Users' 
                                ];
        $scheduleData = [
                            '0' => 'At Registration',
                            '-90'=> '3 months before',
                            '-60' => '2 months before',
                            '-30'=> '1 months before',
                            '-21' => '3 Week before',
                            '-14'=> '2 Week before',
                            '-7' => '3 Week before',
                            '-5'=> '5 Days Before',
                            '-4' => '4 Days Before',
                            '-3'=> '3 Days Before',
                            '-2' => '2 Days Before',
                            '-1'=> '1 Days Before',
                            '-0' => 'Day of Course',
                            '1'=> '1 Day After',
                            '2'=> '2 Day After',
                            '3'=> '3 Day After',
                            '4'=> '4 Day After',
                            '5'=> '5 Day After',
                            '7'=> '1 Week After',
                            '14'=> '2 Week After',
                            '21'=> '3 Week After',
                            '30'=> '1 Month After',
                            '60'=> '2 Month After',
                            '90'=> '3 Month After',
                            '180'=> '6 Month After',
                            '365'=> '1 Year After',
                            '545'=> '1 Year & 6 Month After',
                            '635'=> '1 Year & 9 Month After',
                            '730'=> '2 Year After',
                        ];
        
        $this->set(compact('email', 'tenants', 'events', 'eventVariables','courseTypes','scheduleData','corporateOptions','subcontractedOptions'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Email id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $email = $this->Emails->get($id, [
            'contain' => ['EmailRecipients','EmailConfigurations','EmailCourseTypes']
        ]);
        $selectedCourseTypes = (new Collection($email->email_course_types))->extract('course_type_id')->toArray();

        $existingCorporateClients = [];
        $existingSubcontractedClients = [];
        if(!empty($email->email_recipients)){
            foreach ($email->email_recipients as $key => $value) {
                if(isset($value->corporate_client_id) && $value->corporate_client_id){
                    $existingCorporateClients[$value->corporate_client_id] = $value->corporate_client_id;
                }else{
                    $existingSubcontractedClients[$value->subcontracted_client_id] = $value->subcontracted_client_id;
                }
            }
        }
        $this->loadModel('CourseTypes');
        $tenantId = $this->Auth->User('tenant_id');
        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->_RequestData['tenant_id'] = $this->Auth->user('tenant_id');
            $data = $this->_RequestData;
            // pr($data);die;
            $data['email_configurations'][] = [ 'schedule' => $data['schedule'],
                                                'recipient' => $data['recipient'] ];
            if(!empty($data['course_type_id'])){
                
                foreach ($data['course_type_id'] as $key => $value) {
                    $data['email_course_types'][] = [ 'course_type_id' => $value ];
                  }
            }
            if(!empty($data['corporate_ids'])){
               foreach ($data['corporate_ids'] as $key => $value) {
                    $data['email_recipients'][] = [ 'corporate_client_id' => $value ];
                } 
            }
            if(!empty($data['subcontracte_ids'])){
               foreach ($data['subcontracte_ids'] as $key => $value) {
                    $data['email_recipients'][] = [ 'subcontracted_client_id' => $value ];
                } 
            }    
            unset($data['course_type_id']);
            unset($data['corporate_ids']);
            unset($data['subcontracte_ids']);
            if($data['recipient'] == "student" || $data['recipient'] == "instructor"){
                $this->loadModel('EmailRecipients');
                $emailRecipient = $this->EmailRecipients->findByEmailId($email->id)->first();
                if(isset($emailRecipient) && $emailRecipient){
                    $this->EmailRecipients->delete($emailRecipient);
                }
            }
            $email = $this->Emails->patchEntity($email, $data,['associated' => ['EmailConfigurations','EmailCourseTypes','EmailRecipients']]);
            if ($this->Emails->save($email,['associated' => ['EmailConfigurations','EmailCourseTypes','EmailRecipients']])) {
                $this->Flash->success(__('The email has been saved.'));

                return $this->redirect(['action' => 'index']);
            } else {
            // pr($email);die;    
            $this->Flash->error(__('The email could not be saved. Please, try again.'));
            }
        }
        $events = $this->Emails->Events->find()->combine('id', 'name')->toArray();
        $courseTypes = $this->CourseTypes->find()
                                         ->matching('CourseTypeCategories', function($q) use($tenantId){
                                                return $q->where(['tenant_id' => $tenantId]);
                                            })
                                         ->combine('id', 'name')
                                         ->toArray();

        $eventVariables = $this->Emails->Events->EventVariables
                               ->find()
                               ->groupBy('event_id')
                               ->map(function($value, $key){
                                return (new Collection($value))->map(function($val){
                                    
                                            $data = [
                                                        'text' => $val->name,
                                                        'value'=> '{{'.$val->variable_key.'}}'
                                                    ];

                                            return $data;
                                        })->toArray();
                               })
                               ->toArray();
        $corporateOptions = [
                                'corporate_admins' => 'Corporate Users',
                                'site_contacts' => 'Corporate Admins',
                                'both' => 'Admins & Site Contacts' 
                            ];

        $subcontractedOptions = [
                                    'corporate_admins' => 'Corporate Users' 
                                ];
        $scheduleData = [
                            '0' => 'At Registration',
                            '-90'=> '3 months before',
                            '-60' => '2 months before',
                            '-30'=> '1 months before',
                            '-21' => '3 Week before',
                            '-14'=> '2 Week before',
                            '-7' => '3 Week before',
                            '-5'=> '5 Days Before',
                            '-4' => '4 Days Before',
                            '-3'=> '3 Days Before',
                            '-2' => '2 Days Before',
                            '-1'=> '1 Days Before',
                            '-0' => 'Day of Course',
                            '1'=> '1 Day After',
                            '2'=> '2 Day After',
                            '3'=> '3 Day After',
                            '4'=> '4 Day After',
                            '5'=> '5 Day After',
                            '7'=> '1 Week After',
                            '14'=> '2 Week After',
                            '21'=> '3 Week After',
                            '30'=> '1 Month After',
                            '60'=> '2 Month After',
                            '90'=> '3 Month After',
                            '180'=> '6 Month After',
                            '365'=> '1 Year After',
                            '545'=> '1 Year & 6 Month After',
                            '635'=> '1 Year & 9 Month After',
                            '730'=> '2 Year After',
                        ];
        
        $this->set(compact('email', 'tenants', 'events', 'eventVariables','courseTypes','scheduleData','corporateOptions','subcontractedOptions','selectedCourseTypes','existingCorporateClients','existingSubcontractedClients'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Email id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $email = $this->Emails->get($id);
        if ($this->Emails->delete($email)) {
            $this->Flash->success(__('The email has been deleted.'));
        } else {
            $this->Flash->error(__('The email could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
