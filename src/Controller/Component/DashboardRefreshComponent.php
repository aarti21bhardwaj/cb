<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\I18n\FrozenTime;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use Cake\Collection\Collection;
use Cake\I18n\Date;
use Cake\Database\Expression\QueryExpression;


/**
 * DashboardRefresh component
 */
class DashboardRefreshComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    protected $_overLappingCourse = [];
    public function fetchData($user,$tenant_id,$type){
      // pr($user['training_site_id']);die;
      // $tenant_id = $this->Auth->user('tenant_id');
      $this->Instructors = TableRegistry::get('Instructors');        
      $this->InstructorQualifications = TableRegistry::get('InstructorQualifications');
      $this->CourseStudents = TableRegistry::get('CourseStudents');        
      $this->Courses = TableRegistry::get('Courses');        
      $todayDate = FrozenTime::now();
      $todaysDate = date("Y-m-d");  
      $nextDate = date('Y-m-d', strtotime($todaysDate. ' + 14 day'));
      // pr($user['role']->label == 'TRAINING SITE OWNER');die;

      if($type == 'expiringThreeMonths'){
      	$where = ['expiry_date <=' => $todayDate->addMonth(3),'expiry_date >' => $todayDate];
      }
      if($type == 'expiringToday'){
      	$where = ['expiry_date <=' => $todayDate];
      }
      if($type == 'pendingQualifications'){
          $pendingQualifications = [];
      	// pr($tenant_id);die('here');
	      $pendingQualificationIds= $this->InstructorQualifications->find()->extract('instructor_id')->toArray();
        if(isset($pendingQualificationIds) && !empty($pendingQualificationIds)){
    	  $pendingQualifications = $this->Instructors->find()->where(['id NOT IN' => $pendingQualificationIds,'tenant_id' => $tenant_id])->toArray();
            
        }
      }
      if($type == 'expiringToday' || $type == 'expiringThreeMonths'){
        $expiringData = $this->InstructorQualifications->find()
                                                          ->where($where)
                                                          ->contain(['Instructors' => function($q) use($tenant_id){
                                                              return $q->where(['Instructors.tenant_id' => $tenant_id]);
                                                          },'Qualifications'])
                                                          ->toArray();
      }
      if($type == 'expiringToday' || $type == 'expiringThreeMonths' && $user['role']->label == 'TRAINING SITE OWNER'){
        $expiringData = $this->InstructorQualifications->find()
                                                          ->where($where)
                                                          ->contain(['Instructors' => function($q) use($tenant_id,$user){
                                                              return $q->where(['Instructors.tenant_id' => $tenant_id,'Instructors.training_site_id' => $user['training_site_id']]);
                                                          },'Qualifications'])
                                                          ->toArray();
      }
      // pr($type);die;
      if($type == 'incompleteCheckout'){
        $incompleteCheckout = $this->CourseStudents->find()
                                                    ->where(['course_status IS NULL'])
                                                    ->contain(['Courses' => function ($q) use($tenant_id){
                                                      return $q->where(['Courses.tenant_id' => $tenant_id,'Courses.document_name IS NOT NULL','Courses.status NOT IN' => 'draft']);
                                                    },'Courses.CourseTypes','Courses.CourseDates','Courses.Locations'])                                    
                                                    ->toArray();
        // pr($incompleteCheckout);die;
        if(!empty($incompleteCheckout)){
	        $count =  (new Collection($incompleteCheckout))->map(function($q){
							$bob = count($q->course->course_dates);
				        	return $bob;
				        })->first();
	        // pr($count);
        }   
      }
      if($type == 'incompleteCheckout' && $user['role']->label == 'TRAINING SITE OWNER'){
        $incompleteCheckout = $this->CourseStudents->find()
                                                    ->where(['course_status IS NULL'])
                                                    ->contain(['Courses' => function ($q) use($tenant_id,$user){
                                                      return $q->where(['Courses.tenant_id' => $tenant_id,'Courses.document_name IS NOT NULL','Courses.status NOT IN' => 'draft','Courses.training_site_id' => $user['training_site_id']]);
                                                    },'Courses.CourseTypes','Courses.CourseDates','Courses.Locations'])                                    
                                                    ->toArray();
        // pr($incompleteCheckout);die;
        if(!empty($incompleteCheckout)){
          $count =  (new Collection($incompleteCheckout))->map(function($q){
              $bob = count($q->course->course_dates);
                  return $bob;
                })->first();
          // pr($count);
        }   
      }
      if($type == 'courseDates'){
        $this->_overLappingCourses = [];
        if($user['role']->label == 'TRAINING SITE OWNER'){
        $courseDates = $this->Courses->CourseDates->find()
                                                  ->where(function(QueryExpression $q) use($todaysDate, $nextDate){
                                                          return $q->between('course_date', $todaysDate, $nextDate);
                                                  })
                                                  ->contain(['Courses.Locations','Courses.CourseTypes'])
                                                  ->matching('Courses', function($q) use ($user){
                                                    return $q->where(['Courses.status'=> 'publish','Courses.training_site_id'=> $user['training_site_id']]);
                                                  })
                                                  ->map(function($value, $key){
                                                    $value->start_time = $value->time_from->format('H:i');
                                                    $value->end_time = $value->time_to->format('H:i');
                                                    return $value;
                                                  })
                                                  ->groupBy('course.location.name')
                                                  ->map(function($value, $key){
                                                    return (new Collection($value))->sortBy('time_from', SORT_ASC)->groupBy(function($q){
                                                      return $q->course_date = date('Y-m-d');
                                                    })->map(function($value, $key){
                                                      // $data = [];
                                                      $data = $this->_clashCourseData($value);
                                                      // pr($data);die;
                                                      return $data;
                                                    })->toArray();
                                                  })
                                                  ->toArray();
                                                    
        } else {
        $courseDates = $this->Courses->CourseDates->find()
                                                  ->where(function(QueryExpression $q) use($todaysDate, $nextDate){
                                                          return $q->between('course_date', $todaysDate, $nextDate);
                                                  })
                                                  ->contain(['Courses.Locations','Courses.CourseTypes'])
                                                  ->matching('Courses', function($q) use ($tenant_id){
                                                    return $q->where(['Courses.status'=> 'publish','Courses.tenant_id'=> $tenant_id]);
                                                  })
                                                  ->map(function($value, $key){
                                                    $value->start_time = $value->time_from->format('H:i');
                                                    $value->end_time = $value->time_to->format('H:i');
                                                    return $value;
                                                  })
                                                  ->groupBy('course.location.name')
                                                  ->map(function($value, $key){
                                                    return (new Collection($value))->sortBy('time_from', SORT_ASC)->groupBy(function($q){
                                                      return $q->course_date = date('Y-m-d');
                                                    })->map(function($value, $key){
                                                      // $data = [];
                                                      $data = $this->_clashCourseData($value);
                                                      // pr($data);die;
                                                      return $data;
                                                    })->toArray();
                                                  })
                                                  ->toArray();
      }
      // pr($courseDates);die;
                                                  // pr('yahaa');die;
      // pr($this->_overLappingCourses);die;                            // die;
      // $this->_overLappingCourses = array_unique($this->_overLappingCourses);
      // pr($courseDates);die;
      // pr($this->_overLappingCourses);die;
      if(!empty($courseDates) && !empty($this->_overLappingCourses)){
	      $location = $this->Courses->find()
	                                  ->contain(['CourseTypes'])
	                                  ->where(['Courses.id IN' => $this->_overLappingCourses])
	                                  ->all()
	                                  ->combine('id','course_type.name')
	                                  ->toArray();
      }                                            
      // pr($location);die;                                                                        
      }
      if($type == 'courseInstructors'){
        $ids = [];
        $this->_overLappingCourses = [];
        if($user['role']->label == 'TRAINING SITE OWNER'){

         $courseInstructors = $this->Courses->CourseInstructors->findByStatus(1)
                            ->contain(['Courses.CourseTypes','Instructors','Courses.CourseDates' => function($q) use($todaysDate, $nextDate){
                                return $q->where(function(QueryExpression $qe) use($todaysDate, $nextDate){
                                        return $qe->between('course_date', $todaysDate, $nextDate);
                                });
                              }])
                            ->matching('Courses', function($q) use ($user){
                              return $q->where(['Courses.status'=> 'publish','Courses.training_site_id' => $user['training_site_id']]);
                            })
                            ->groupBy('instructor_id')
                            ->map(function($value, $key) use($ids){
                              $value = (new Collection($value))->extract('course.course_dates')
                                                             ->toArray();
                              $value = call_user_func_array('array_merge', $value); 
                              $value = (new Collection($value))->map(function($value, $key){
                                          // pr($value->course_id);
                                          $value->start_time = $value->time_from->format('H:i');
                                          $value->end_time = $value->time_to->format('H:i');
                                          return $value;
                                        })
                                        ->sortBy('time_from', SORT_ASC)
                                        ->groupBy(function($q){
                                          return $q->course_date = date('Y-m-d');
                                        })
                                        ->map(function($value, $key){
                                          $data = $this->_clashCourseData($value);
                                          return $data;
                                        })
                                        ->toArray();
                              return $value;

                            })->toArray();
        } else {  
        $courseInstructors = $this->Courses->CourseInstructors->findByStatus(1)
                            ->contain(['Courses.CourseTypes','Instructors','Courses.CourseDates' => function($q) use($todaysDate, $nextDate){
                                return $q->where(function(QueryExpression $qe) use($todaysDate, $nextDate){
                                        return $qe->between('course_date', $todaysDate, $nextDate);
                                });
                              }])
                            ->matching('Courses', function($q) use ($tenant_id){
                              return $q->where(['Courses.status'=> 'publish','tenant_id' => $tenant_id]);
                            })
                            ->groupBy('instructor_id')
                            ->map(function($value, $key) use($ids){
                              $value = (new Collection($value))->extract('course.course_dates')
                                                             ->toArray();
                              $value = call_user_func_array('array_merge', $value); 
                              $value = (new Collection($value))->map(function($value, $key){
                                          // pr($value->course_id);
                                          $value->start_time = $value->time_from->format('H:i');
                                          $value->end_time = $value->time_to->format('H:i');
                                          return $value;
                                        })
                                        ->sortBy('time_from', SORT_ASC)
                                        ->groupBy(function($q){
                                          return $q->course_date = date('Y-m-d');
                                        })
                                        ->map(function($value, $key){
                                          $data = $this->_clashCourseData($value);
                                          return $data;
                                        })
                                        ->toArray();
                              return $value;

                            })->toArray();
        }

      $this->_overLappingCourses = array_unique($this->_overLappingCourses);
      // pr($this->_overLappingCourses);die; 
      $instructorIds = array_keys($courseInstructors);
      if(!empty($this->_overLappingCourses)){	
      	$courses = $this->Courses->find()
                                  ->contain(['CourseTypes'])
                                  ->where(['Courses.id IN' => $this->_overLappingCourses])
                                  ->combine('id','course_type.name')
                                  ->toArray();
      }
      $instructorsData = [];
      if(!empty($instructorIds)){
	      $instructorsData = $this->Instructors->find()
	      									   ->where(['Instructors.id IN' => $instructorIds])
	      									   ->combine('id','first_name')
	      									   ->toArray();
      }                           
      }
      
      return $fetchData = ['expiringThreeMonths' => ($type=='expiringThreeMonths')?$expiringData:null,
      					        'expiringToday' => $type=='expiringToday'?$expiringData:null,
  						          'pendingQualifications' => $type=='pendingQualifications'?$pendingQualifications:null,
		                    'incompleteCheckout' => $type=='incompleteCheckout'?$incompleteCheckout:null,
		                    'courseInstructors' => $type=='courseInstructors'?$courseInstructors:null,
		                    'courses' => isset($courses)?$courses:null,
		                    'instructorsData' => $type=='courseInstructors'?$instructorsData:null,
		                    'courseDates' => $type=='courseDates'?$courseDates:null,
		                    'location' => isset($location)?$location:null,
		                    'count' => isset($count)?$count:null
  						   ];						   
      

    }
        // function return course clashes on same date
    private function _clashCourseData($courseLists){
      // pr('haha');pr($courseLists);die;
        $data = [];
        $overLappingCourses = [];
        for ($i=0; $i < count($courseLists) - 1 ; $i++) {

          if($courseLists[$i]->end_time > $courseLists[$i + 1]->start_time){
              if(!isset($data[$courseLists[$i]->course_id])){
                $data[$courseLists[$i]->course_id] = $courseLists[$i];
              }
              
              $data[$courseLists[$i+1]->course_id] = $courseLists[$i + 1];
              // pr($data);die;
              $overLappingCourses[] = $courseLists[$i]->course_id;
              $overLappingCourses[] = $courseLists[$i+1]->course_id;
              // pr($overLappingCourses);die;
          }
        }
        $this->_overLappingCourses = array_merge($this->_overLappingCourses, $overLappingCourses);
        // pr($data);die;
       return $data;      
    }

}
