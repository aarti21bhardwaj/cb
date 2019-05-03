<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Routing\Router;
use Cake\I18n\Date;
use Cake\I18n\Time;
use Cake\Core\Configure;
use Cake\Mailer\Email;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Collection\Collection;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Exception\BadRequestException;
use Cake\Utility\Security;
use Cake\Event\Event;
use Cake\I18n\FrozenTime;
use Cake\Http\Session;


/**
 * Students Model
 *
 * @property \App\Model\Table\TrainingSitesTable|\Cake\ORM\Association\BelongsTo $TrainingSites
 * @property \App\Model\Table\TenantsTable|\Cake\ORM\Association\BelongsTo $Tenants
 * @property \App\Model\Table\CorporateClientsTable|\Cake\ORM\Association\BelongsTo $CorporateClients
 * @property \App\Model\Table\SubcontractedClientsTable|\Cake\ORM\Association\BelongsTo $SubcontractedClients
 * @property \App\Model\Table\RolesTable|\Cake\ORM\Association\BelongsTo $Roles
 * @property \App\Model\Table\CourseStudentsTable|\Cake\ORM\Association\HasMany $CourseStudents
 * @property |\Cake\ORM\Association\HasMany $StudentResetPasswordHashes
 *
 * @method \App\Model\Entity\Student get($primaryKey, $options = [])
 * @method \App\Model\Entity\Student newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Student[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Student|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Student|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Student patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Student[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Student findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class StudentsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('students');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('TrainingSites', [
            'foreignKey' => 'training_site_id'
        ]);
        $this->belongsTo('Tenants', [
            'foreignKey' => 'tenant_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('CorporateClients', [
            'foreignKey' => 'corporate_client_id'
        ]);
        $this->belongsTo('SubcontractedClients', [
            'foreignKey' => 'subcontracted_client_id'
        ]);
        $this->belongsTo('StudentTransferHistories', [
            'foreignKey' => 'student_id'
        ]);
        $this->belongsTo('Roles', [
            'foreignKey' => 'role_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('CourseStudents', [
            'foreignKey' => 'student_id'
        ]);
        $this->hasMany('LineItems', [
            'foreignKey' => 'student_id'
        ]);
        $this->hasMany('StudentResetPasswordHashes', [
            'foreignKey' => 'student_id'
        ]);
        $this->hasMany('Payments', [
            'foreignKey' => 'student_id'
        ]);
        $this->hasMany('Orders', [
            'foreignKey' => 'student_id'
        ]);

    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('first_name')
            ->maxLength('first_name', 255)
            ->requirePresence('first_name', 'create')
            ->notEmpty('first_name');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 255)
            ->requirePresence('last_name', 'create')
            ->notEmpty('last_name');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email');

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmpty('password');

        $validator
            ->scalar('address')
            ->allowEmpty('address');

        $validator
            ->scalar('city')
            ->maxLength('city', 255)
            ->allowEmpty('city');

        $validator
            ->scalar('state')
            ->maxLength('state', 255)
            ->allowEmpty('state');

        $validator
            ->scalar('zipcode')
            ->maxLength('zipcode', 255)
            ->allowEmpty('zipcode');

        $validator
            ->scalar('phone1')
            ->maxLength('phone1', 255)
            ->allowEmpty('phone1');

        $validator
            ->scalar('phone2')
            ->maxLength('phone2', 255)
            ->allowEmpty('phone2');

        $validator
            ->boolean('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status');

        $validator
            ->scalar('student_profession')
            ->maxLength('student_profession', 255)
            ->allowEmpty('student_profession');

        $validator
            ->scalar('hear_about_us')
            ->maxLength('hear_about_us', 255)
            ->allowEmpty('hear_about_us');

        $validator
            ->scalar('health_care_provider')
            ->maxLength('health_care_provider', 255)
            ->allowEmpty('health_care_provider');

        $validator
            ->scalar('requested_organisation')
            ->maxLength('requested_organisation', 255)
            ->allowEmpty('requested_organisation');

        $validator
            ->scalar('comments')
            ->maxLength('comments', 255)
            ->allowEmpty('comments');

        $validator
            ->scalar('others')
            ->maxLength('others', 255)
            ->allowEmpty('others');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['email']));
        // $rules->add($rules->existsIn(['training_site_id'], 'TrainingSites'));
        $rules->add($rules->existsIn(['tenant_id'], 'Tenants'));
        $rules->add($rules->existsIn(['corporate_client_id'], 'CorporateClients'));
        // $rules->add($rules->existsIn(['subcontracted_client_id'], 'SubcontractedClients'));
        $rules->add($rules->existsIn(['role_id'], 'Roles'));

        return $rules;
    }

    function registerStudents($students, $course, $emailFlag = null, $type = null){
      $session = new Session();
      // pr($session->read('studentsInfo'));die('table');
      // pr($course);die;

        // $studentNumbers = $session->read('studentsInfo');
        $studentNumbers = $session->consume('studentsInfo');

        // pr($studentNumbers);die;
        $students = [];
        $emailData = [];
        foreach($studentNumbers as $key => $studentData){
            $studentData = array_values($studentData);
            // pr($studentData);die;
            $data['training_site_id'] = $course->training_site_id;
            $data['tenant_id'] = $course->tenant_id;
            $data['corporate_client_id'] = $course->corporate_client_id;
            if($type ==1){
                $date = new FrozenTime();
                $data['course_students'][0] = [
                                                'course_id' => $course->id,
                                                'payment_status' => 'Paid',
                                                'course_status' => 1,
                                                'registration_date' => $date
                                             ];    
            }else{

                $data['course_students'][0] = [
                                                'course_id' => $course->id,
                                                'payment_status' => 'Not Paid'
                                             ];
            }
            $courseTypeCategory = $course->course_type_category?$course->course_type_category->name:"No information available!";
            $courseType  = $course->course_type?$course->course_type->name:"No information available!";
            $trainingSite = $course->training_site?$course->training_site->name:"No information available!";
            $courseId = $course->id;
            $locationName = $course->location?$course->location->name:"No information available!";
            $locationAddress = $course->location?$course->location->address:"No information available!";
            $locationCity = $course->location?$course->location->city:"No information available!";
            $locationState = $course->location?$course->location->state:"No information available!";
            $locationZipcode = $course->location?$course->location->zipcode:"No information available!";

            if(isset($course->course_type_category)){
              $courseTypeCategory = $course->course_type_category->name;
            } else {
              $courseTypeCategory = "No data exits";
            }             
            if(isset($course->course_type)){
              $courseType  = $course->course_type->name;
            } else {
              $courseType  = 'No data exits';  
            }              
            if(isset($course->training_site)){  
              $trainingSite = $course->training_site->name;
            } else {
              $trainingSite = 'No data exists';  
            }
              $courseId = $course->id;
            if(isset($course->location)){
              $locationName = $course->location->name;
              $locationAddress = $course->location->address;
            }else {
              $locationAddress= "No data exits";  
            }
            if(isset($course->location)){
              $locationCity = $course->location->city;
              $locationState = $course->location->state;
              $locationZipcode = $course->location->zipcode;
            }
            if(!empty($studentData[2]) && isset($studentData[2])){
              $email = $studentData[2];
              $emailValidator = $this->validEmail($email);
              if(!$emailValidator){
                break;
                return false;
              }
              $student = $this->findByEmail($email)->first(); 
              if($student){ 
                  return false;
              }
             
              if(!$emailValidator) {
                  $abort = true;
                  break;
              }
              $password = substr($studentData[0], 0, 3).substr($studentData[0], 0, 3);
            // pr($studentData);die;
              // pr($password);die;

              $reqData[] = [
                              'first_name' => $studentData[0],
                              'last_name' => $studentData[1],
                              'email' => $email,
                              'phone1' => $studentData[3],
                              'tenant_id' => $data['tenant_id'],
                              'training_site_id' => $data['training_site_id'],
                              'corporate_client_id' => $data['corporate_client_id'],
                              'password' => $password ,
                              'status' => 1,
                              'role_id' => 5,
                              'course_students' => $data['course_students']
                           ];
                           // pr($reqData);die;
                $name = $studentData[0].' '.$studentData[1];
                $url = Router::url('/', true);
                if($emailFlag == 1){     
                    $emailData = [
                      'name' => $name,
                      'email' => $email,
                      'course_id' => $course->id,
                      'course_type' => $courseType,
                      'email_content'=> "You have been Registered to ".$course->training_site->name.". Your username and password is mentioned below: <br>",
                      'username' => "Username : ".$email,
                      'password' => "Password : ".$password,
                      'to_login' => "You can Login at :".$url.'students/login',
                      'course_type_agency' => $course->course_type->agency->name,
                      'course_date' => $course->course_dates[0]->course_date->format('Y-m-d'),
                      'course_start_time' => $course->course_dates[0]->time_from->format('H:i'),
                      'course_end_time' => $course->course_dates[0]->time_to->format('H:i'),
                      'location_name' => $locationName,
                      'location_address' => $locationAddress,
                      'location_city' => $locationCity,
                      'location_state' => $locationState,
                      'location_zipcode' => $locationZipcode,
                      'training_site_name' => $course->training_site->name,
                      'training_site_email' => $course->training_site->contact_email,
                      'training_site_phone' => $course->training_site->phone,
                      'server_name' => $url.'students/login',
                      'emailFlag' => $emailFlag,
                    ];  
                }
            }
            // pr($emailData);die;
        }
        // pr($reqData);die;
        $students = $this->newEntities($reqData);
        $students = $this->patchEntities($students, $reqData);
        if($this->saveMany($students,['emailData' => $emailData,'registerEmailStatus' => true])){
            return $data = ['students' => $students, 'status' => true];
        }else{
            return $data = ['status' => false];
        }
    }

    public function afterSave($event,$entity,$options){
        if(isset($options['registerEmailStatus']) && $options['registerEmailStatus'] == 1){
          $emailData = $options->offsetGet('emailData');
          $name = $entity->first_name.' '.$entity->last_name; 
          $emailData['name'] = $name;
          $emailData['email'] = $entity->email;
          $emailData['username'] = "Username : ".$entity->email;
          if($emailData && !empty($emailData)){
              $event = new Event('register_student_to_course', $this, [
                 'hashData' => $emailData,
                 'tenant_id' => $entity->tenant_id
              ]);
              $this->getEventManager()->dispatch( $event);
              $emailData = [];
          }
        }
    }

    function validEmail($email){
        
        // First, we check that there's one @ symbol, and that the lengths are right
        if (!preg_match("/^[^@]{1,64}@[^@]{1,255}$/", $email)) {
            // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
            return false;
        }
        // Split it into sections to make life easier
        $email_array = explode("@", $email);
        $local_array = explode(".", $email_array[0]);
        for ($i = 0; $i < sizeof($local_array); $i++) {
            if (!preg_match("/^(([A-Za-z0-9!#$%&'*+\/=?^_`{|}~-][A-Za-z0-9!#$%&'*+\/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/", $local_array[$i])) {
                return false;
            }
        }
        if (!preg_match("/^\[?[0-9\.]+\]?$/", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
            $domain_array = explode(".", $email_array[1]);
            if (sizeof($domain_array) < 2) {
                return false; // Not enough parts to domain
            }
            for ($i = 0; $i < sizeof($domain_array); $i++) {
                if (!preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/", $domain_array[$i])) {
                    return false;
                }
            }
        }

        return true;
    }
}
