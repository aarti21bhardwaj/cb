<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

/**
 * DashBoard component
 */
class DashBoardComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function fetchData(){
     //  $tenant_id = $this->Auth->user('tenant_id');
     //  $this->loadModel("Instructors");
     //  $this->loadModel("Students");
     //  $this->loadModel("Courses");
     //  $this->loadModel("Payments");
     //  $this->loadModel('InstructorQualifications');
     //  $todayDate = FrozenTime::now();

     //  $oneMonthStudents = $this->Students->find()->where(['created >=' => $todayDate->subDays(30),'tenant_id' => $tenant_id])->count();
     //  $twoMonthStudents = $this->Students->find()->where(['created <=' => $todayDate->subDays(30),'created >=' => $todayDate->subDays(60),'tenant_id' => $tenant_id])->count();
     //  $oneMonthCourses = $this->Courses->find()->where(['created >=' => $todayDate->subDays(30),'tenant_id' => $tenant_id, 'status' => 'publish'])->count();
     //  $twoMonthCourses = $this->Courses->find()->where(['created <=' => $todayDate->subDays(30),'created >=' => $todayDate->subDays(60),'tenant_id' => $tenant_id,'status' => 'publish'])->orWhere(['created <=' => $todayDate->subDays(30),'created >=' => $todayDate->subDays(60),'tenant_id' => $tenant_id,'status' => 'confirmed'])->count();
     //  $query = $this->Payments->find()->contain(['Transactions']);
     //  $profitOneMonth = $query->select(['sum' => $query->func()->sum("Transactions.amount")])->where(['tenant_id' => $tenant_id, 'Payments.created >=' => $todayDate->subDays(30)])->extract('sum')->first();

     //  $profitTwoMonth = $query->select(['sum' => $query->func()->sum("Transactions.amount")])->where(['tenant_id' => $tenant_id, 'Payments.created >=' => $todayDate->subDays(30)])->orWhere(['Payments.created <=' => $todayDate->subDays(30),'Payments.created >=' => $todayDate->subDays(60),'tenant_id' => $tenant_id])->extract('sum')->first();

     //  if($type = '3MonthExpiry'){
     //  	$where = ['expiry_date <=' => $todayDate->addMonth(3),'expiry_date >' => $todayDate])->contain(['Instructors','Qualifications'];
     //  }
     //  if($type = 'expiryToday'){
     //  	$where = ['expiry_date' => $todayDate])->contain(['Instructors','Qualifications'];
     //  }
     //  $expiringThreeMonths = $this->InstructorQualifications->find()->where($where)->toArray();
     //  $expiredNow = $this->InstructorQualifications->find()->where($where)->toArray();
     //  $pendingQualificationIds= $this->InstructorQualifications->find()->extract('instructor_id')->toArray();

     //  $pendingQualifications = $this->Instructors->find()->where(['id NOT IN' => $pendingQualificationIds,'tenant_id' => $tenant_id])->toArray();
     // $this->set(compact('pendingQualifications','oneMonthStudents', 'twoMonthStudents','loggedInUser','todayDate','oneMonthCourses','twoMonthCourses','profitOneMonth','profitTwoMonth','expiringThreeMonths','expiredNow'));
    }
}
