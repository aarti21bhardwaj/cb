<?php
namespace App\Controller\Api;

use App\Controller\Api\ApiController;
use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Http\Exception\NotFoundException;

/**
 * CorporateClients Controller
 *
 * @property \App\Model\Table\CorporateClientsTable $CorporateClients
 *
 * @method \App\Model\Entity\CorporateClient[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CorporateClientsController extends ApiController
{
    /**
     * Index method..
     *
     * @return \Cake\Http\Response|void
     */
  public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['courseTypes','courseData','getSubcontractedClients','index']);

    }
    public function index()
    {
      $trainingSiteId =  $this->request->getQuery('training_site_id');
      $loggedInUser = $this->Auth->user();
      $tenant_id = $loggedInUser['tenant_id'];
      $corporateClients = $this->CorporateClients->find()
                                          ->where(['tenant_id ='=>$tenant_id,'training_site_id'=>$trainingSiteId])
                                          ->all()
                                          ->toArray();
      $this->set(compact('corporateClients'));
      $this->set('_serialize', ['corporateClients']);
    }

    // get course type as per course type categories
    public function courseTypes()
    {
      $this->loadModel('CourseTypes');
      $courseTypeCategoryId =  $this->request->getQuery('course_type_category_id');
      $courseTypes = $this->CourseTypes->find()
                                          ->where(['course_type_category_id'=>$courseTypeCategoryId])
                                          ->all()
                                          ->toArray();
      $this->set(compact('courseTypes'));
      $this->set('_serialize', ['courseTypes']);
    }

    public function courseData(){
      $this->loadModel('CourseTypes');
      $courseTypeId =  $this->request->getQuery('course_type_id');
      $courseTypeData = $this->CourseTypes->find()
                                          ->where(['id'=>$courseTypeId])
                                          ->first();
      $this->set(compact('courseTypeData'));
      $this->set('_serialize', ['courseTypeData']);
    }
     public function getSubcontractedClients($corporateClientId = null){
         // $corporateId = $corporateClientId;
         // pr($corporateId);die();
          // pr($corporateClientId)
         $loggedInUser = $this->Auth->user();
         // pr($loggedInUser);die();
         if(!$this->request->is(['get'])){
          throw new MethodNotAllowedException(__('BAD_REQUEST'));
        }
        if(!$corporateClientId){
          throw new NotFoundException(__('Corporate client id not found'));
        }
        $subcontractedClients = $this->CorporateClients
                                     ->SubcontractedClients
                                     ->find()
                                     ->matching('CorporateClients',function ($q) use ($loggedInUser, $corporateClientId){
                                        return $q->where(['CorporateClients.id'=> $corporateClientId,'CorporateClients.tenant_id'=>$loggedInUser['tenant_id'] 
                                        ]);
                                      })
                                      ->all()
                                      ->toArray();
        // pr($subcontractedClients);die();

        if(empty($subcontractedClients)){
          throw new NotFoundException(__('Subcontracted Client(s) for this Corporate Client has not been found'));
        }

        $this->set('response',$subcontractedClients);
        $this->set('_serialize', ['response']);
      }

}
