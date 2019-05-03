<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CourseTypeCategories Controller
 *
 * @property \App\Model\Table\CourseTypeCategoriesTable $CourseTypeCategories
 *
 * @method \App\Model\Entity\CourseTypeCategory[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CourseTypeCategoriesController extends AppController
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
        else if (in_array($action, ['index','view','add','edit','delete','thankYou','updateStatus']) && $user['role']->name === self::TENANT_LABEL) {
        // pr($action); die('in tenant admin');
            return true;
        }else if (in_array($action, ['index','view','add','edit','delete','thankYou','updateStatus']) && $user['role']->name === self::CLIENT_LABEL) {
        // pr($action); die('in tenant admin');
            return true;
        }
        else if (in_array($action, ['index','view','add','edit','delete','thankYou','updateStatus']) && $user['role']->name === self::CLIENT_LABEL) {
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
     * Index method..
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $loggedInUser = $this->Auth->user();
        if($loggedInUser['role']->name == self::TENANT_LABEL){
          $courseTypeCategories = $this->CourseTypeCategories->find()
                                              ->contain(['Tenants'])
                                              ->where(['CourseTypeCategories.tenant_id ='=>$loggedInUser['tenant_id']])
                                              ->all()
                                              ->toArray();
        }else if($loggedInUser['role']->name == self::SUPER_ADMIN_LABEL){
        $courseTypeCategories = $this->CourseTypeCategories
                                    ->find()
                                    ->contain(['Tenants'])
                                    ->all();
        }
        $this->set('loggedInUser', $loggedInUser);

        $this->set(compact('courseTypeCategories'));
    }

    /**
     * View method
     *
     * @param string|null $id Course Type Category id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $courseTypeCategory = $this->CourseTypeCategories->get($id, [
            'contain' => ['Tenants', 'CourseTypes.Agencies', 'Courses.Tenants', 'Courses.Locations','Courses.TrainingSites','Courses.CorporateClients','Courses.CourseTypes']
        ]);

        $this->set('courseTypeCategory', $courseTypeCategory);
    }

    public function thankYou(){
      $this->viewBuilder()->setLayout('popup-view');
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($variable=null)
    {
        if($variable){
        $this->viewBuilder()->setLayout('popup-view');

        }
        $courseTypeCategory = $this->CourseTypeCategories->newEntity();
        $loggedInUser = $this->Auth->user();
        if ($this->request->is('post')) {
          $data = $this->request->getData();
           // pr($data);die;
          if($loggedInUser['role']->name == 'corporate_client' ){
            $data['tenant_id'] = $loggedInUser['corporate_client']['tenant_id'];
            // pr($data['tenant_id']);die;
          }else{
           $data['tenant_id'] = $loggedInUser['tenant_id']; 
          }
            $courseTypeCategory = $this->CourseTypeCategories->patchEntity($courseTypeCategory, $data);
            // pr($courseTypeCategory);die;
            if ($this->CourseTypeCategories->save($courseTypeCategory)) {
                 if(!$variable){
                $this->Flash->success(__('The course type category has been saved.'));
                return $this->redirect(['action' => 'index']);
              }else{
                $this->Flash->success(__('The course type category has been saved.'));
                return $this->redirect(['action' => 'thankYou']);
              }
            }
            $this->Flash->error(__('The course type category could not be saved. Please, try again.'));
        }

        // pr($loggedInUser['role']->name); die('ss');
        if($loggedInUser['role']->name == self::TENANT_LABEL){
            $tenants = $this->CourseTypeCategories->Tenants->find()
                                                ->where(['id'=>$loggedInUser['id']])
                                                ->all()
                                                ->combine('id','center_name')
                                                ->toArray();
            
        }else {
            $tenants = $this->CourseTypeCategories->Tenants->find()->all()->combine('id','center_name')->toArray();
        }
        $this->set('loggedInUser', $loggedInUser);

        // $tenants = $this->CourseTypeCategories->Tenants->find()->all()->combine('id','first_name')->toArray();
        $this->set(compact('courseTypeCategory', 'tenants'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Course Type Category id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $courseTypeCategory = $this->CourseTypeCategories->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $courseTypeCategory = $this->CourseTypeCategories->patchEntity($courseTypeCategory, $this->request->getData());
            if ($this->CourseTypeCategories->save($courseTypeCategory)) {
                $this->Flash->success(__('The course type category has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The course type category could not be saved. Please, try again.'));
        }

        $loggedInUser = $this->Auth->user();
        if($loggedInUser['role']->name == self::TENANT_LABEL){
            $tenants = $this->CourseTypeCategories->Tenants->find()
                                                ->where(['id'=>$loggedInUser['id']])
                                                ->all()
                                                ->combine('id','center_name')
                                                ->toArray();
            
        }else {
            $tenants = $this->CourseTypeCategories->Tenants->find()->all()->combine('id','center_name')->toArray();
        }
        $this->set('loggedInUser', $loggedInUser);
        
        // $tenants = $this->CourseTypeCategories->Tenants->find()->all()->combine('id','center_name')->toArray();
        $this->set(compact('courseTypeCategory', 'tenants'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Course Type Category id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $courseTypeCategory = $this->CourseTypeCategories->get($id);
        if ($this->CourseTypeCategories->delete($courseTypeCategory)) {
            $this->Flash->success(__('The course type category has been deleted.'));
        } else {
            $this->Flash->error(__('The course type category could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
      public function updateStatus($id = null)
    {
        $query = $this->request->getAttribute('params')['pass'];
        // pr($query); die();
        $courseTypeCategory_id = $query[0];
        $this->request->allowMethod(['post']);
        $courseTypeCategory = $this->CourseTypeCategories->get($courseTypeCategory_id);
        if($courseTypeCategory){
          $status = $query[1];
          if($status == 1){
            $status = 0;
          }else if($status == 0){
            $status = 1;
          }
          $courseTypeCategoryData['status'] = $status;
          $courseTypeCategory = $this->CourseTypeCategories->patchEntity($courseTypeCategory, $courseTypeCategoryData);
          $courseTypeCategory = $this->CourseTypeCategories->save($courseTypeCategory);
            if($courseTypeCategory){
              $this->Flash->success(__('Status updated'));
            }else{
              $this->Flash->error(__('Please, try again.'));
            }
        }
        return $this->redirect(['action' => 'index']);
    }
}
