<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CourseTypes Controller
 *
 * @property \App\Model\Table\CourseTypesTable $CourseTypes
 *
 * @method \App\Model\Entity\CourseType[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CourseTypesController extends AppController
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
        $this->paginate = [
            'contain' => ['CourseTypeCategories', 'Agencies']
        ];
        $loggedInUser = $this->Auth->user();
        $courseTypes = $this->CourseTypes->find()
                                         ->contain(['CourseTypeCategories','Agencies'])
                                         ->where(['CourseTypeCategories.tenant_id' => $loggedInUser['tenant_id'] ])
                                         ->all();
                                         // pr($CourseTypes);die;

        $this->set(compact('courseTypes'));
    }

    /**
     * View method
     *
     * @param string|null $id Course Type id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $courseType = $this->CourseTypes->get($id, [
            'contain' => ['CourseTypeCategories', 'CourseTypeQualifications', 'Courses', 'Agencies']
        ]);

        $this->set('courseType', $courseType);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $loggedInUser = $this->Auth->user();
        $courseType = $this->CourseTypes->newEntity();
        if ($this->request->is('post')) {
            $courseType = $this->CourseTypes->patchEntity($courseType, $this->request->getData());
            // pr($courseType); die('ss');
            if ($this->CourseTypes->save($courseType)) {
                $this->Flash->success(__('The course type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The course type could not be saved. Please, try again.'));
        }
        $courseTypeCategories = $this->CourseTypes->CourseTypeCategories->find()
                                                                        ->where(['CourseTypeCategories.tenant_id' => $loggedInUser['tenant_id'] ])
                                                                        ->combine('id','name');
        $agencies = $this->CourseTypes->Agencies->find()->all()->combine('id','name')->toArray();
        $courseDurations= [
                                '1' => '1 Year' , '2' => '2 Years' , '3' => '3 Years', '4' => '4 Years' , '5' => '5 Years'
                            ];
        $this->set(compact('courseType', 'courseTypeCategories','agencies','courseDurations'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Course Type id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $courseType = $this->CourseTypes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $courseType = $this->CourseTypes->patchEntity($courseType, $this->request->getData());
            if ($this->CourseTypes->save($courseType)) {
                $this->Flash->success(__('The course type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The course type could not be saved. Please, try again.'));
        }
        $courseTypeCategories = $this->CourseTypes->CourseTypeCategories->find('list', ['limit' => 200]);
        $agencies = $this->CourseTypes->Agencies->find()->all()->combine('id','name')->toArray();
        $courseDurations= [
                                '1' => '1 Year' , '2' => '2 Years' , '3' => '3 Years', '4' => '4 Years' , '5' => '5 Years'
                            ];
        $this->set(compact('courseType', 'courseTypeCategories','agencies','courseDurations'));

    }

    /**
     * Delete method
     *
     * @param string|null $id Course Type id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $courseType = $this->CourseTypes->get($id);
        if ($this->CourseTypes->delete($courseType)) {
            $this->Flash->success(__('The course type has been deleted.'));
        } else {
            $this->Flash->error(__('The course type could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
