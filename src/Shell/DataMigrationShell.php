<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Datasource\ConnectionManager;
use Cake\Datasource\Model;
use Cake\I18n\Time;
use Faker\Factory as Faker;
use Cake\Log\Log;
use Cake\Core\Configure;
use Cake\I18n\Date;
use Cake\Utility\Text;
use Cake\I18n\FrozenTime;


/**
 * DataMigration shell command.
 */
class DataMigrationShell extends Shell
{

    /**
     * Manage the available sub-commands along with their arguments and help
     *
     * @see http://book.cakephp.org/3.0/en/console-and-shells.html#configuring-options-and-generating-help
     *
     * @return \Cake\Console\ConsoleOptionParser
     */
    public function getOptionParser()
    {
        $parser = parent::getOptionParser();
        return $parser;
    }

    public function connectWithMigrationDB($query){
       
        if($this->_currentDb){
            $dbConfig = ConnectionManager::getConfig('classbyte_old'); 
            ConnectionManager::drop('classbyte_old');
            $dbConfig['database'] = $this->_currentDb;
            ConnectionManager::setConfig('classbyte_old', $dbConfig);    
        }
        
        $conn = ConnectionManager::get('classbyte_old');

        // pr($conn);die;
        $response = $conn->execute($query);
        // pr($response);die;
        return $response;
    }

    public function getDatabases(){

        $this->out('In Main');
        $query = "SHOW DATABASES WHERE `Database` LIKE '%classbdb%'";
            // ConnectionManager::config('testCase', ['url' => 'mysql://root:root@localhost/classbdb_cbdev1',]);
        $this->_currentDb = false;
        // pr($this->connectWithMigrationDB($query)->fetchAll('assoc'));die('ss');
        return $this->connectWithMigrationDB($query)->fetchAll('assoc');

    }

    /**
     * main() method.
     *
     * @return bool|int|null Success or error code.
     */
    public function main()
    {

        $databases = $this->getDatabases();
        // pr($databases);die;
        foreach ($databases as $key =>  $database){
            $this->_currentDb = $database['Database'];
        	if($this->_currentDb != 'classbdb_cprpros'){
        	   continue;
        	}
            $this->out('currentDb : '.$this->_currentDb);
            $this->_faker = Faker::create();
            // $this->qualifications();
            // pr($this->_faker);die;
            // $this->migrateTenants();
            // $this->migrateTrainingSites();
            // $this->migrateInstructors();
            // $this->migrateCorporateClients();
            // $this->migrateCorporateClientUsers();
            // $this->migrateCorporateClientDocuments();
            // $this->migrateTenantUsers(); 
            // $this->migrateLocations();            
            // $this->migrateKeyInventories();
            // $this->migrateKeyCategories();
            // $this->migratePromoCodes();            
            // $this->migrateAddons();            
            // $this->migrateTenantSettings();            
            // $this->migrateTenantThemes();            
            // $this->migrateTenantConfigSettings(); 
            // $this->migrateCardPrintingProfiles();      
            // $this->migrateStudents();            
            // $this->migrateCourses();
            // $this->migrateCourseInstructors();
            // $this->migrateCourseStudents();  
            // $this->migrateCourseDocuments();          
            // $this->migrateInstructorApplications();        
            // $this->migrateInstructorInsuranceForms();  
            // $this->migrateInstructorQualifications();
            // $this->migrateInstructorReferences();        
            // $this->migrateKeyCategories();
            // $this->addTrainingSiteToInstructor();
            $this->addTrainingSiteToStudents();            
            


        }
        
    }
    public function hashBot($new_id,$old_id,$new_name,$old_name){
        $this->out('in hash bot');
        // pr('old_id : '.$old_id);die;
        $this->loadModel('OldDbHashes');
        $dbHash = $this->OldDbHashes->newEntity();
        $data['new_id'] = $new_id ;
        $data['old_id'] = $old_id ;
        $data['new_name'] = $new_name ;
        $data['old_name'] = $old_name ;
        // pr($data);die;
        $dbHash = $this->OldDbHashes->patchEntity($dbHash, $data);
            // pr($dbHash); die('saved');
        if($this->OldDbHashes->save($dbHash)){
            $this->out('hashing saved');
        }else{
            pr($dbHash);
        }

    }

    public function getNewMappedId($oldId,$tableName){
        $this->loadModel('OldDbHashes');
        // $oldTrainingSiteIdQuery = "Select trainingsiteid from trainingsites";
        $myfile = fopen(Configure::read('App.webroot').'/migration_logs/data_not_present.json', "a");
        // pr($oldTrainingSiteIds);
            // pr($this->OldDbHashes);die;
            // pr($oldTrainingSiteId['trainingsiteid']);
            $newTableId = $this->OldDbHashes->find()
                                                   ->where(['old_id' => $oldId ,'old_name' => $tableName.'_'.$this->_currentDb])
                                                   ->order(['OldDbHashes.created' => 'DESC'])
                                                   ->extract('new_id')
                                                   ->first();

            if(empty($newTableId)){
                $data['database_name'] = $this->_currentDb;
                $data['table_name'] = $tableName;
                $data['id'] = $oldId;
                fwrite($myfile, json_encode($data));
                fclose($myfile);  
            }                                      
            return($newTableId);
        
    }

    public  function migrateCorporateClientUsers(){
         // $corporateClientQuery = "Select * from corp_clients";
        // $oldCorporateClientIdQuery = "Select corpparent from corp_admins";
        // try{
        //     $oldCorporateClientIds = $this->connectWithMigrationDB($oldCorporateClientIdQuery)->fetchAll('assoc');
        // }catch(\Exception $e){
        //     $this->out('Table not found will not continue;');
        //     return;
        // }
        // // pr($oldCorporateClientIds);
        
        // foreach ($oldCorporateClientIds as $oldCorporateClientId) {
        //     $newCorporateClientId = $this->getNewMappedId($oldCorporateClientId['corpparent'],'corp_clients');
            // pr($newCorporateClientId);
            // $oldInstructorsQuery = "Select * from instructors where trainingsiteid = ".$oldTrainingSiteId['trainingsiteid']  ;
        
                    
            $corporateClientUsersQuery = "Select * from corp_admins";
            // pr($corporateClientUsersQuery);die;
            try{
                $corporateClientUsers = $this->connectWithMigrationDB($corporateClientUsersQuery)->fetchAll('assoc');
            }catch(\Exception $e){
                $this->out('table not found will not continue;');
                return;
            }
            $myfile = fopen(Configure::read('App.webroot').'/duplicate_emails.json', "a");
            // pr($corporateClientUsers);
            if(isset($corporateClientUsers)){
                foreach ($corporateClientUsers as $key => $corporateClientUser) {
                $data =[];
		    if(empty($this->getNewMappedId($corporateClientUser['corpparent'],'corp_clients'))){
                             $data['corporate_client'] = 'Does Not exist';
                             fwrite($myfile, json_encode($data));
                             continue;

                    }
                    pr('id'.$corporateClientUser['corpparent']);
                    # code...
                    // pr($corporateClientUser['corpparent']);
                    $data['first_name'] = $corporateClientUser['corpuserfirstname'];
                    $data['last_name'] = isset($corporateClientUser['corpuserlastname'])? $corporateClientUser['corpuserlastname'] : $this->_faker->name;
                    $data['email'] = $corporateClientUser['corpuseremail'];
                    $data['phone'] = isset($corporateClientUser['corpuserphone'])? $corporateClientUser['corpuserphone'] : $this->_faker->phoneNumber ;
                    // if(isset(var))
                    $data['password'] = isset($corporateClientUser['corpuserpassword'])? $corporateClientUser['corpuserpassword'] : '12345678' ;
                    if($corporateClientUser['corpuseraccountstatus'] == 'active'){
                        $data['status'] = 1;
                    }elseif($corporateClientUser['corpuseraccountstatus'] == 'disabled'){
                        $data['status'] = 0; 
                    }
                    $data['role_id'] = 3;
                    $data['corporate_client_id'] = $this->getNewMappedId($corporateClientUser['corpparent'],'corp_clients') ;
                    pr($data);  
                    $this->loadModel('CorporateClientUsers');
                    $corporateClientUsersData = $this->CorporateClientUsers->newEntity();
                    $corporateClientUsersData = $this->CorporateClientUsers->patchEntity($corporateClientUsersData, $data);
                    if ($this->CorporateClientUsers->save($corporateClientUsersData)){
                        $this->out($corporateClientUsersData->first_name.' saved');
                        $new_id = $corporateClientUsersData->id;
                        $new_name = 'corporateClientUserUsers';
                        $old_id = $corporateClientUser['corpuserid'];
                        $old_name = 'corp_admins_'.$this->_currentDb ;
                        // pr($old_id);die;
                        $this->out('Mapping corporateClientUserUsers in OldDbHashes table');
                        $this->hashBot($new_id,$old_id,$new_name,$old_name);
			$corporateClientUsers[$key] = null;
                    }else{
                        if($corporateClientUsersData->getError('email')['_isUnique'] || $corporateClientUsersData->getError('email')['email']){
                            $data['corporate_client'] = 'Duplicate Email';
                             fwrite($myfile, json_encode($data));
                             continue;
                            }else{
                                pr($corporateClientUsersData);
                            
                            }
                    }
                }
                
            }
            fclose($myfile);

        // }


    }




    public  function migrateCorporateClientDocuments(){
         // $corporateClientQuery = "Select * from corp_clients";
        // $oldCorporateClientIdQuery = "Select corpupl_corpid from corp_uploads";
        // try{
        //     $oldCorporateClientIds = $this->connectWithMigrationDB($oldCorporateClientIdQuery)->fetchAll('assoc');
        // }catch(\Exception $e){
        //     $this->out('Table not found will not continue;');
        //     return;
        // }
        // pr($oldCorporateClientIds);die;  
        
        // foreach ($oldCorporateClientIds as $oldCorporateClientId) {
        //     if(empty($oldCorporateClientId['corpupl_corpid'])){
        //         continue;
        //     }
        //     $newCorporateClientId = $this->getNewMappedId($oldCorporateClientId['corpupl_corpid'],'corp_clients');
        //     // pr($newCorporateClientId);
        //     // $oldInstructorsQuery = "Select * from instructors where trainingsiteid = ".$oldTrainingSiteId['trainingsiteid']  ;
        $corporateClientDocsQuery = "Select * from corp_uploads";
        try{

            $corporateClientDocs = $this->connectWithMigrationDB($corporateClientDocsQuery)->fetchAll('assoc');
        }catch(\Exception $e){
            $this->out('table not found will not continue;');
            return;
        }
            // pr($corporateClientDocs);die;
            if(isset($corporateClientDocs)){
                foreach ($corporateClientDocs as $key => $corporateClientDoc) {
			$data = [];
                    if(!isset($corporateClientDoc['corpupl_corpid']) && empty($corporateClientDoc['corpupl_corpid'])){
                        pr('invalid_corporate_id');
                        continue;
                    }
                    # code...
                    $data['document_path'] = '/corporate_client_documents';
                    $data['document_name'] = $corporateClientDoc['corpupl_uploadname'];
                    $data['corporate_client_id'] = $this->getNewMappedId($corporateClientDoc['corpupl_corpid'],'corp_clients');

                    $this->loadModel('CorporateClientDocuments');
                    $corporateClientDocsData = $this->CorporateClientDocuments->newEntity();
                    $corporateClientDocsData = $this->CorporateClientDocuments->patchEntity($corporateClientDocsData, $data);
                    if ($this->CorporateClientDocuments->save($corporateClientDocsData)){
                        $this->out($corporateClientDocsData->first_name.' saved');
                        $new_id = $corporateClientDocsData->id;
                        $new_name = 'CorporateClientDocuments';
                        $old_id = $corporateClientDoc['corpupl_corpid'];;
                        $old_name = 'corp_uploads_'.$this->_currentDb ;
                        $this->out('Mapping corporateClient Documents in OldDbHashes table');
                        $this->hashBot($new_id,$old_id,$new_name,$old_name);
			            $corporateClientDocs[$key] = null;
                    }else{

                    pr($corporateClientDocsData);
                    }
                }
                
            }else{
                $this->out('no corporateClient DocumentData Found in this databse');
            }

        // }
    }


    public  function migrateLocations(){
         // $corporateClientQuery = "Select * from corp_clients";
        // $oldCorporateClientIdQuery = "Select locationparentclient from locations";
        // try{
        //     $oldCorporateClientIds = $this->connectWithMigrationDB($oldCorporateClientIdQuery)->fetchAll('assoc');
        // }catch(\Exception $e){
        //     $this->out('Table not found will not continue;');
        //     return;
        // }
        
        // // pr($oldCorporateClientId);
        // foreach ($oldCorporateClientIds as $oldCorporateClientId) {
        //     if(empty($oldCorporateClientId['locationparentclient'])){
        //         continue;
        //     }

            // $newCorporateClientId = $this->getNewMappedId($oldCorporateClientId['locationparentclient'],'corp_clients');
            // pr($newCorporateClientId);
            // $oldInstructorsQuery = "Select * from instructors where trainingsiteid = ".$oldTrainingSiteId['trainingsiteid']  ;
            $locationsQuery = "Select * from locations";
            // pr($locationsQuery);die;
            $locations = $this->connectWithMigrationDB($locationsQuery)->fetchAll('assoc');
            $myfile = fopen(Configure::read('App.webroot').'/invalid_id.json', "a");
            // pr($locations);die;
            if(isset($locations)){
                foreach ($locations as $key => $location) {
                   	$data = [];
                    if(!isset($location['locationparentclient']) && empty($location['locationparentclient'])){
                        $this->out('corporate_client_id not set');
                        continue;
                    }
                    // pr('id'.$location['locationparentclient']);
                    $data['name'] = $location['locationname'];
                    $data['contact_name'] = $location['locationcontact'];
                    $data['contact_email'] = $location['locationcontactemail'];
                    $data['contact_phone'] = $location['locationphone'];
                    $data['address'] = $location['locationaddress'];
                    $data['city'] = $location['locationcity'];
                    $data['state'] = $location['locationstate'];
                    $data['zipcode'] = $location['locationzip'];
                    $data['lat'] = $location['lat'];
                    $data['lng'] = $location['lng'];
                    $data['notes'] = $location['locationnotes'];
                    $data['tenant_id'] = $this->getNewMappedId($this->_currentDb,'old_tenants');
                    $data['training_site_id'] = 1;
                    $data['status'] = 1;
                    $data['corporate_client_id'] = $this->getNewMappedId($location['locationparentclient'],'corp_clients');
                    if(empty($this->getNewMappedId($location['locationparentclient'],'corp_clients'))){
                        $this->out('invalid corporate_client_id');
                        $data['location'] = 'invalid corporate_client_id as corporate client not saved id='.$location['locationparentclient'].' '.$this->_currentDb;
                        fwrite($myfile, json_encode($data));
                        continue;

                    }

                    $this->loadModel('Locations');
                    $locationsData = $this->Locations->newEntity();
                    $locationsData = $this->Locations->patchEntity($locationsData, $data);
                    if ($this->Locations->save($locationsData)){
                        $this->out($locationsData->name.' location saved');
                        $new_id = $locationsData->id;
                        $new_name = 'locations';
                        $old_id = $location['locationsid'];
                        $old_name = 'locations_'.$this->_currentDb ;
                        // pr($old_id);die;
                        $this->out('Mapping Locations in OldDbHashes table');
                        $this->hashBot($new_id,$old_id,$new_name,$old_name);
		              $locations[$key] = null;
                    }
                    // pr($corporateClientUsersData);
                }
                
            }
            fclose($myfile);



        // }


    }

    public  function migrateCourses(){
         // $corporateClientQuery = "Select * from corp_clients";
        $coursesQuery = "Select * from scheduledcourses";
        try{
            $courses = $this->connectWithMigrationDB($coursesQuery)->fetchAll('assoc');
            // pr($oldCorporateClientIds);die;
        }catch(\Exception $e){
            $this->out('Table not found will not continue;');
            return;
        }
            foreach ($courses as $key => $course) {
               // if($course['coursenumberofseats'] == 9){
               //      $seats = explode("-",$course['coursenumberofseats']);
               //      $data['seats'] = end($seats);
               //      pr(gettype($seats));pr(gettype((int)$data['seats']));
               //      die('here');
               // }
                $this->out('Migrating Courses');
                $data = [];
                $data['tenant_id'] = $this->getNewMappedId($this->_currentDb,'old_tenants');
                if(isset($course['coursecorpparent'])){
                $data['corporate_client_id'] = $this->getNewMappedId($course['coursecorpparent'],'corp_clients');
                }
                if($course['privatecourse']== 'yes'){
                    $data['private_course'] = 1;
                }else{
                    $data['private_course'] = 0;
                }
                $data['training_site_id'] = $this->getNewMappedId($course['courseparent'],'trainingsites');
                $data['course_type_id'] = $course['coursetype'];
                $data['location_id'] = $this->getNewMappedId($course['courselocationid'],'locations');
                $seats = explode("-",$course['coursenumberofseats']);
                $data['seats'] = (int)end($seats);
                // $course['coursenumberofseats'] = '6-8';
                // pr(explode("-",$course['coursenumberofseats']));
                // pr(end(explode("-",$course['coursenumberofseats'])));die;
                $data['cost'] = $course['coursecost'];
                if(isset($course['coursestatus'])){

                    $data['status'] = $course['coursestatus'];
                }else{
                    $data['status'] = 'cancelled';
                }
                $data['notes'] = $course['notes'];
                $data['document_name'] = $course['courseroster'];
                $data['document_path'] = 'course_roster';
                $data['instructor_pay'] = $course['instructorfee'];
                $data['instructor_notes'] = $course['notestoinstructor'];
                try{
                    $data['admin_notes'] = $course['adminnotes'];
                 }catch(\Exception $e){
                    $data['admin_notes'] = 'invalid Data Type ';  
                }
                $data['duration'] = 1;
                $data['class_details'] = 'not provided';
                $data['owner_id'] = 0;
                $data[' ']['instructor_id'] = $this->getNewMappedId($course['courseinstructor'],'instructors');


                $biddingCheckQuery = "Select bidding from scheduledcourses";
                try{
                    $biddingCheck = $this->connectWithMigrationDB($biddingCheckQuery)->fetchAll('assoc');
                    $data['instructor_bidding'] = $course['bidding'];
                }catch(\Exception $e){
                     $data['instructor_bidding'] = 0;
                }
                $data['course_dates'][0]['course_date'] = new Date($course['coursedate']) ;
                $data['course_dates'][0]['time_from'] = $course['coursetime'];
                $data['course_dates'][0]['time_to'] = $course['courseendtime'];
                if($data['course_dates'][0]['course_date'] == '0000-00-00'){
                            $data['course_dates'][0]['course_date'] = new Date($course['coursedate']->setDate(2020, 01, 01));
                        }
                if(isset($course['courseaddon']) && $course['courseaddon'] != 0){

                $data['course_addons']['addon_id'] = $this->getNewMappedId($course['courseaddon'],'course_addon');
                }
                $this->loadModel('Courses');
                $coursesData = $this->Courses->newEntity();
                    $coursesData = $this->Courses->patchEntity($coursesData, $data);
                    // pr($coursesData);die;
                    if ($this->Courses->save($coursesData)){
                        $this->out('Course '.$course['scheduledcoursesid'].$this->_currentDb.' saved');
                        $new_id = $coursesData->id;
                        $new_name = 'courses';
                        $old_id = $course['scheduledcoursesid'];
                        $old_name = 'scheduledcourses_'.$this->_currentDb ;
                        // pr($old_id);die;
                        $this->out('Mapping courses in OldDbHashes table');
                        $this->hashBot($new_id,$old_id,$new_name,$old_name);
			            $courses[$key] = null; 
                    }else{
                        pr($coursesData);die('here');
                    }  
            }
    }

    public function migrateCourseInstructors(){
        $this->out('migrating Course Instructors');
        $courseInstructorQuery = "Select * from instructor_acceptance_history";
        try{
        $courseInstructors = $this->connectWithMigrationDB($courseInstructorQuery)->fetchAll('assoc');
        }catch(\Exception $e){
            $this->out('Table not found will not continue;');
            return;
        }
        if(!empty($courseInstructors)){
            foreach ($courseInstructors as $key => $courseInstructor) {
               $data = [];
                // pr($courseInstructor['keyscategory']);die;
                $data['course_id'] = $this->getNewMappedId($courseInstructor['courseid'],'scheduledcourses');
                $data['instructor_id'] = $this->getNewMappedId($courseInstructor['instid'],'instructors');
                $data['status']= $courseInstructor['status'];
                $data['modified']= $courseInstructor['datetime'];

                $this->loadModel('CourseInstructors');
                $courseInstructorsData = $this->CourseInstructors->newEntity();
                $courseInstructorsData = $this->CourseInstructors->patchEntity($courseInstructorsData, $data);
                if ($this->CourseInstructors->save($courseInstructorsData)){
                    $this->out($courseInstructorsData->first_name.' saved');
                    $new_id = $courseInstructorsData->id;
                    $new_name = 'course_instructors';
                    $old_id = $courseInstructor['id'];
                    $old_name = 'instructor_acceptance_history_'.$this->_currentDb ;
                    // pr($old_id);die;
                    $this->out('Mapping CourseInstructors in OldDbHashes table');
                    $this->hashBot($new_id,$old_id,$new_name,$old_name);
		    $courseInstructors[$key] = null;
                }else{
                    pr($courseInstructorsData);
                }

            }
        }

    }

    public function migrateCourseDocuments(){
        $courseDocumentQuery = "Select * from courseuploads";
        try{
        $courseDocuments = $this->connectWithMigrationDB($courseDocumentQuery)->fetchAll('assoc');
        }catch(\Exception $e){
            $this->out('Table not found will not continue;');
            return;
        }
        if(!empty($courseDocuments)){
            $this->loadModel('CourseDocuments');
            foreach ($courseDocuments as $key => $courseDocument) {
                $this->out('migrating Course Documents');
                # code...
                // pr($courseDocument);
                $data['course_id'] = 1;
                // $this->getNewMappedId($courseDocument['scheduledcourseid'],'scheduledcourses');
                $data['document_name']= $courseDocument['uploadname'];
                $data['document_path']= 'course_documents';
                $data['description']= $courseDocument['uploaddesc'];
                // $data['created']= $courseDocument['uploadtimedate'];
                $courseDocumentsData = $this->CourseDocuments->newEntity();
                // pr($courseDocumentsData);
                $courseDocumentsData = $this->CourseDocuments->patchEntity($courseDocumentsData, $data);
                if ($this->CourseDocuments->save($courseDocumentsData)){
                // pr($courseDocumentsData);
                    $this->out('courseDocumentsData saved');
                    $new_id = $courseDocumentsData->id;
                    $new_name = 'course_documents';
                    $old_id = $courseDocument['uploadid'];
                    $old_name = 'courseuploads_'.$this->_currentDb ;
                    // pr($old_id);die;
                    $this->out('Mapping CourseDocuments in OldDbHashes table');
                    $this->hashBot($new_id,$old_id,$new_name,$old_name);
                }else{
                    pr($data);
                    pr($courseDocumentsData);die('here');
                }

            }
        }

    }



    // public function studentPromoCode(){
    //     $studentPromocodesQuery = "Select * from courseregistrations";
    //     $studentPromocodes = $this->connectWithMigrationDB($studentPromocodesQuery)->fetchAll('assoc');
    //     if(!empty($studentPromocodes)){
    //         foreach ($studentPromocodes as $key => $student) {
    // }

    public function migrateCourseStudents(){
        $courseStudentsQuery = "Select * from courseregistrations";
        try{
        $courseStudents = $this->connectWithMigrationDB($courseStudentsQuery)->fetchAll('assoc');
        }catch(\Exception $e){
            $this->out('Table not found will not continue;');
            return;
        }
        $myfile = fopen(Configure::read('App.webroot').'/migration_logs/CourseStudents.json', "a");
        if(!empty($courseStudents)){
            foreach ($courseStudents as $key => $student) {
                $data = [];
                // pr($student['studentid']);
                // pr($this->getNewMappedId($student['studentid'],'students'));die;
                // pr(Configure::read('App.webroot'));die;
                if(empty($this->getNewMappedId($student['studentid'],'students'))){
                    continue;
                }
                $this->out('migrating Course Students');
                $data['payment_status']= $student['paymentstatus'];
                $data['course_id'] = 1;
                $data['student_id'] = $this->getNewMappedId($student['studentid'],'students');
                $data['payment_status']= $student['paymentstatus'];
                if($student['registrationstatus'] == 'passed'){
                $data['course_status']= 1;
                }
                if($student['registrationstatus'] == 'failed'){
                $data['course_status']= 2;
                }
                if($student['registrationstatus'] == 'absent'){
                $data['course_status']= 3;
                }
                if($student['registrationstatus'] == 'incomplete'){
                $data['course_status']= 4;
                }
                if($student['registrationstatus'] == null){
                $data['course_status']= null;
                }
                if(isset($student['promocode']) && $student['promocode']){

                    $dataPromocodeStudent['student_id'] = $this->getNewMappedId($student['studentid'],'students');
                    $dataPromocodeStudent['promo_code_id'] = $this->getNewMappedId($student['promocode'],'promo_code');
                    $dataPromocodeStudent['course_id'] = $this->getNewMappedId($student['scheduledid'],'scheduledcourses');
                    $this->loadModel('StudentPromoCodes');
                    $promocodeData = $this->StudentPromoCodes->newEntity();
                    $promocodeData = $this->StudentPromoCodes->patchEntity($promocodeData, $dataPromocodeStudent);
                    if($this->StudentPromoCodes->save($promocodeData)){
                        $this->out('PromoCode Student saved');
                    }
                }

                $this->loadModel('CourseStudents');
                $studentsData = $this->CourseStudents->newEntity();
                $studentsData = $this->CourseStudents->patchEntity($studentsData, $data);
                if($this->CourseStudents->save($studentsData)){
                    $this->out('Course Student saved');
                    $new_id = $studentsData->id;
                    $new_name = 'course_students';
                    $old_id = $student['courseregistrationsid'];
                    $old_name = 'courseregistratiions_'.$this->_currentDb ;
                    // pr($old_id);die;
                    $this->out('Mapping KeyCategories in OldDbHashes table');
                    $this->hashBot($new_id,$old_id,$new_name,$old_name);
		   $courseStudents[$key] = null;
                }else{
                    if($studentsData->getError('email')['_isUnique']){
                            fwrite($myfile, json_encode($data));
                            continue;
                        }else{
                            pr($studentsData);die;
                            die('outside');
                        }
                    pr($courseInstructorsData);
                }

            }
        }
        fclose($myfile);

    }

    public function migrateAddons(){
        $this->loadModel('Addons');
        $addonsQuery = "Select * from course_addon";
        try{
            $addons = $this->connectWithMigrationDB($addonsQuery)->fetchAll('assoc');
        }catch(\Exception $e){
            $this->out('Table not found will not continue;');
            return;
        }

        if(!empty($addons)){
            foreach ($addons as $key => $addon) {
            $this->out('migrating Addons');
               	$data = [];
                $data['product_code'] = $addon['product_code'];
                $data['name'] = $addon['product_name'] ;
                $data['description'] = $addon['product_description'] ;
                $data['price'] = $addon['product_price'] ;
                if(isset($addon['product_option'])){
                    $data['option_status'] = $addon['product_option'] ;
                }else{
                    $data['option_status'] = 0;  
                }
                $data['tenant_id'] = $this->getNewMappedId($this->_currentDb,'old_tenants');
                $data['type'] = $addon['product_type'] ;
                $data['short_description'] = 'not provided' ;

                $addonsData = $this->Addons->newEntity();
                $addonsData = $this->Addons->patchEntity($addonsData, $data);
                if ($this->Addons->save($addonsData)){
                    $this->out($addonsData->first_name.' saved');
                    $new_id = $addonsData->id;
                    $new_name = 'addons';
                    $old_id = $addon['product_id'];
                    $old_name = 'course_addon_'.$this->_currentDb ;
                    // pr($old_id);die;
                    $this->out('Mapping Addon in OldDbHashes table');
                    $this->hashBot($new_id,$old_id,$new_name,$old_name);
		    $addons[$key] = null;
                }else{
                    pr($addonsData);die;
                }

            }
        }


    }

    public  function migrateKeyInventories(){
        $this->loadModel('KeyInventories');
        $keyInventoriesQuery = "Select * from keys_inventory";
        try{
            $keyInventories = $this->connectWithMigrationDB($keyyInventoriesQuery)->fetchAll('assoc');
        }catch(\Exception $e){
            $this->out('Table not found will not continue;');
            return;
        }
        if(!empty($keyInventories)){
            foreach ($keyInventories as $key => $keyInventory) {
               	$data = [];
                // pr($keyInventory['keyscategory']);die;
                $data['key_category_id'] = $keyInventory['keyscategory'];
                $data['name'] = $keyInventory['keysnumber'] ;
                $data['status']= 1;
                $keyInventoriesData = $this->KeyInventories->newEntity();
                $keyInventoriesData = $this->KeyInventories->patchEntity($keyInventoriesData, $data);
                if ($this->KeyInventories->save($keyInventoriesData)){
                    $this->out($keyInventoriesData->first_name.' saved');
                    $new_id = $keyInventoriesData->id;
                    $new_name = 'key_inventories';
                    $old_id = $keyInventory['keysid'];
                    $old_name = 'keys_inventories_'.$this->_currentDb ;
                    // pr($old_id);die;
                    $this->out('Mapping KeyCategories in OldDbHashes table');
                    $this->hashBot($new_id,$old_id,$new_name,$old_name);
		    $keyInventories[$key] = null;
                }else{
                    pr($keyInventoriesData);die;
                }

            }
        }

    }

    public  function migrateKeyCategories(){
        $this->loadModel('KeyCategories');
        $keyCategoriesQuery = "Select * from keys_categories";
        $this->out('migrating KeyCategories');
        try{
            $keyCategories = $this->connectWithMigrationDB($keyCategoriesQuery)->fetchAll('assoc');
        }catch(\Exception $e){
            $this->out('Table not found will not continue;');
            return;
        }
        if(!empty($keyCategories)){
            foreach ($keyCategories as $key => $keyCategory) {
                $data = [];
                $data['tenant_id']= $this->getNewMappedId($this->_currentDb,'old_tenants');
                $data['description'] = $keyCategory['keyscategorydescription'];
                $data['name'] = $keyCategory['keyscategoryname'] ;
                $data['status']= 1;
                pr($data);
                $keyCategoriesData = $this->KeyCategories->newEntity();
                $keyCategoriesData = $this->KeyCategories->patchEntity($keyCategoriesData, $data);
                if ($this->KeyCategories->save($keyCategoriesData)){
                    $this->out($keyCategoriesData->first_name.' saved');
                    $new_id = $keyCategoriesData->id;
                    $new_name = 'key_categories';
                    $old_id = $keyCategory['keyscategoryid'];
                    $old_name = 'keys_categories_'.$this->_currentDb ;
                    // pr($old_id);die;
                    $this->out('Mapping KeyCategories in OldDbHashes table');
                    $this->hashBot($new_id,$old_id,$new_name,$old_name);
		    $migrateKeyCategories[$key] = null;
                }else{
                    pr($keyCategoriesData);die;
                }
            }
        }

    }



    public  function migrateTenantUsers(){
        $this->out('currentDb : '.$this->_currentDb);
        // $this->out('saving tenant users');
        $this->loadModel('TenantUsers');

        $adminsQuery = "Select * from admins";
        $adminsData = $this->connectWithMigrationDB($adminsQuery)->fetchAll('assoc');
        if(!empty($admins)){
            foreach ($admins as $key => $admin) {
		$data = [];
                $this->out('migrating Tenant Users from admin table');
                // if($instructor['masteradmin'] == 'y'){
                    // pr($instructor);
                    // $this->_tenantId = 1;
                    $data['first_name'] = 'admin'.$key;
                    $data['last_name'] = 'tenant';
                    $data['email'] = $admin['adminsername'];
                    $data['phone'] = $this->_faker->phoneNumber;
                    $data['address'] = null;
                    $data['city'] = $this->_faker->city;
                    $data['state'] = $this->_faker->state;
                    $data['zipcode'] = $this->_faker->postcode;
                    $data['password'] = $admin['adminpassword'];
                    $data['is_site_owner'] = 1;
                    $data['tenant_id'] = $this->getNewMappedId($this->_currentDb,'old_tenants');
                    $data['status'] = 1;
                    $data['role_id'] = 2;
                    
                    pr($data);
                    $tenantUsersData = $this->TenantUsers->newEntity();
                    $tenantUsersData = $this->TenantUsers->patchEntity($tenantUsersData, $data);
                    if ($this->TenantUsers->save($tenantUsersData)){
                        $this->out($tenantUsersData->first_name.' saved');
                        $new_id = $tenantUsersData->id;
                        $new_name = 'tenantUsers';
                        $old_id = $instructor['instructorsid'];
                        $old_name = 'instructors_'.$this->_currentDb ;
                        // pr($old_id);die;
                        $this->out('Mapping tenantUsers in OldDbHashes table');
                        $this->hashBot($new_id,$old_id,$new_name,$old_name);
			$admins[$key] = null;
                    }else{
                    pr($tenantUsersData);die;
                    }
                // }

                }   
            }else{
                $this->out('no Tenant user found in this admin table');
            }


        // $oldTrainingSiteIdQuery = "Select trainingsiteid from trainingsites";
        // $oldTrainingSiteIds = $this->connectWithMigrationDB($oldTrainingSiteIdQuery)->fetchAll('assoc');
        
        // foreach ($oldTrainingSiteIds as $oldTrainingSiteId) {
            // $newTrainingSiteId = $this->getNewMappedId($oldTrainingSiteId['trainingsiteid'],'trainingSites');
            $oldInstructorsQuery = "Select * from instructors"  ;
            $instructors = $this->connectWithMigrationDB($oldInstructorsQuery)->fetchAll('assoc');
            if(!empty($instructors)){

                foreach ($instructors as $key => $instructor) {
			        $data = [];
                    
                    $this->out('migrating Tenant Users from instructor table');
                    if($instructor['masteradmin'] == 'y'){

                        pr('id=>'.$instructor['instructorsid']);
                        // if(empty($this->getNewMappedId($instructor['trainingsiteid'],'trainingsites'))){
                        //     $this->out('invalid_training_site_id;');
                        //     continue;
                        // }
                        $this->out('migrating Tenant Users from instructor table');
                        $data['first_name'] = $instructor['instructorname'];
                        $data['last_name'] = $instructor['instructorlastname'];
                        $data['email'] = $instructor['instructoremail'];
                        $data['phone'] = isset($instructor['instructorphone']) && $instructor['instructorphone']?$instructor['instructorphone']:$this->_faker->phoneNumber;
                        $data['address'] = $instructor['instuctoraddress'].' '.$instructor['instructoraddress2'];
                        $data['city'] = $instructor['city'];
                        $data['state'] = $instructor['state'];
                        $data['zipcode'] = $instructor['zip'];
                        $data['password'] = $instructor['instructorpassword'];
                        $data['is_site_owner'] = 1;
                        $data['training_site_id'] = $this->getNewMappedId($instructor['trainingsiteid'],'trainingsites');
                        $data['tenant_id'] = $this->getNewMappedId($this->_currentDb,'old_tenants');
                        $data['status'] = 1;
                        $data['role_id'] = 2;
                        $tenantUsersData = $this->TenantUsers->newEntity();
                        $tenantUsersData = $this->TenantUsers->patchEntity($tenantUsersData, $data);
                        if ($this->TenantUsers->save($tenantUsersData)){
                            $this->out($tenantUsersData->first_name.' saved');
                            $new_id = $tenantUsersData->id;
                            $new_name = 'tenantUsers';
                            $old_id = $instructor['instructorsid'];
                            $old_name = 'instructors_tenantUser_'.$this->_currentDb ;
                            // pr($old_id);die;
                            $this->out('Mapping tenantUsers in OldDbHashes table');
                            $this->hashBot($new_id,$old_id,$new_name,$old_name);
			    $instructors[$key] = null;
                        }
                        else{
                            if((isset($tenantUsersData->getError('email')['_isUnique']) && $tenantUsersData->getError('email')['_isUnique']) || (isset($tenantUsersData->getError('email')['email']) && $tenantUsersData->getError('email')['email'])){
                             fwrite($myfile, 'student_emails'.json_encode($data));
                             continue;
                            }else{
                                pr($tenantUsersData);die;
                                die('outside');
                            }
                        }
                    }

                }   
            }else{
                $this->out('no Tenant user found in this databases');
            }

        // }

    }

    public function migratePromoCodes(){
        $promoCodeQuery = "Select * from promo_code";
        try{
        $promoCodes = $this->connectWithMigrationDB($promoCodeQuery)->fetchAll('assoc');
        }catch(\Exception $e){
            $this->out('Table not found will not continue;');
            return;
        }
        // pr($promoCodes);
        if(!empty($promoCodes)){
                foreach ($promoCodes as $key =>  $promoCode) {
                    $this->out('migrating promoCodes');
		    $data = [];
                    // pr($promoCode);
                    // $this->_tenantId = 1;
                    $data['code'] = $promoCode['code_id'];
                    $data['description'] = $promoCode['description'];
                    $data['start_date'] = $promoCode['start_date'];
                    $data['end_date'] = $promoCode['end_date'];
                    $data['discount_type'] = $promoCode['disc_type'];
                    $data['discount'] = $promoCode['discount'];
                    $data['no_of_uses'] = $promoCode['uses'];
                    $data['status'] = 1;
                    $data['tenant_id'] =$this->getNewMappedId($this->_currentDb,'old_tenants');
                    // $data['restrict_by_course_types'] = $promoCode['course_type'];
                    // $data['restrict_by_email'] = $promoCode['email_data'];
                    
                    // pr($data);
                    $this->loadModel('PromoCodes');
                    $promoCodeData = $this->PromoCodes->newEntity();
                    $promoCodeData = $this->PromoCodes->patchEntity($promoCodeData, $data);
                    if ($this->PromoCodes->save($promoCodeData)){
                        $this->out('promocode saved');
                        $new_id = $promoCodeData->id;
                        $new_name = 'promocodes';
                        $old_id = $promoCode['id'];
                        $old_name = 'promo_code_'.$this->_currentDb ;
                        // pr($old_id);die;
                        $this->out('Mapping promoCodes in OldDbHashes table');
                        $this->hashBot($new_id,$old_id,$new_name,$old_name);
			$promoCodes[$key] = null;

                    }else{
                     pr($promoCodeData) ;
                    }
                }
            }
    }

    public function migrateTenantSettings(){
        $settingsQuery = "Select * from _master_settings";
        try{
            $settings = $this->connectWithMigrationDB($settingsQuery)->fetchAll('assoc');
        }catch(\Exception $e){
            $this->out('Table not found will not continue;');
            return;
        }
        
        // pr($settings);
        if(!empty($settings)){
            foreach ($settings as $key =>  $setting) {
                $this->out('migrating settings');
                $data = [];
                // $this->_tenantId = 1;
                $data['enable_training_site_module'] = 0;
                $data['enable_corporate_module'] = 1;
                $data['shop_menu_visible'] = 1;
                $data['default_theme'] = isset($setting['defaulttheme']) && $setting['defaulttheme']?$setting['defaulttheme']:'admin-theme';
                $data['key_management'] = 0;
                $data['admin_email'] = isset($setting['adminemail']) && $setting['adminemail']?$setting['adminemail']:$this->_faker->email;
                $data['from_email'] = isset($setting['fromemail']) && $setting['fromemail']?$setting['fromemail']:$this->_faker->email;
                $data['tenant_id'] = $this->getNewMappedId($this->_currentDb,'old_tenants');
                $data['allow_duplicate_emails'] = !$setting['uniquestudentemail'];
                $data['training_centre_website'] = isset($setting['tcwebsiteurl']) && $setting['tcwebsiteurl']?$setting['tcwebsiteurl']:$this->_faker->url;
                $setting['bccemail']? $data['bcc_email'] = $setting['bccemail'] : $data['bcc_email'] = 'notprovided';
                $data['title_bar_text'] = isset($setting['titleforbackend']) && $setting['titleforbackend']?$setting['titleforbackend']:$this->_faker->title;
                $data['enable_payment_email'] = 1;
                $data['enable_aed_pm_module'] = 1;
                
                pr($data);
                $this->loadModel('TenantSettings');
                $settingsData = $this->TenantSettings->newEntity();
                $settingsData = $this->TenantSettings->patchEntity($settingsData, $data);
                if ($this->TenantSettings->save($settingsData)){
                    $this->out('TenantSettings saved');
                     $new_id = $settingsData->id;
                     $new_name = 'tenant_settings';
                     $old_id = $setting['id'];
                     $old_name = '_master_settings_'.$this->_currentDb ;
                    // pr($old_id);die;
                    $this->out('Mapping Tenant Settings in OldDbHashes table');
                    $this->hashBot($new_id,$old_id,$new_name,$old_name);
		   $settings[$key] = null;
                }else{

                pr($settingsData);die;
                }
            }
        }
    }

    public function migrateTenantConfigSettings(){
        $settingsQuery = "Select * from config_settings";
        try{
            $settings = $this->connectWithMigrationDB($settingsQuery)->fetchAll('assoc');
        }catch(\Exception $e){
            $this->out('Table not found will not continue;');
            return;
        }
        
        // pr($settings);die;
        if(!empty($settings)){
            foreach ($settings as $key =>  $setting) {
                $this->out('migrating settings');
                $data = [];
                // $this->_tenantId = 1;
                $data['card_print'] = $setting['card_printing'];
                $data['instructor_bidding'] = $setting['card_printing'];
                $data['sandbox'] = $setting['sandbox'];
                $data['stripe_live_publish_key'] = $setting['stripe_published_key'];
                $data['stripe_live_private_key'] = $setting['stripe_private_key'];
                $data['termcondition'] = $setting['termsandconditions'];
                $data['tenant_id'] =  $this->getNewMappedId($this->_currentDb,'old_tenants');
                $data['API_endpoint'] = $setting['api_endpoint'];
                $data['API_username'] = $setting['api_username'];
                $data['API_password'] = $setting['api_password'];
                $data['API_signature'] = $setting['api_signature'];
                $data['API_payment_url'] = $setting['api_url'];
                $data['authorize_login_id_sandbox'] = $setting['auth_login_id_sandbox'];
                $data['authorize_API_url_live'] = $setting['auth_api_url_live'];
                $data['authorize_transaction_key_live'] = $setting['auth_tran_key_live'];
                $data['authorize_login_id_live'] = $setting['auth_login_id_live'];
                $data['intuit_login_id_live'] = $setting['intuit_login_id_live'];
                $data['intuit_key_sandbox'] = $setting['intuit_key_sandbox'];
                $data['intuit_login_id_sandbox'] = $setting['intuit_login_id_sandbox'];
                $data['intuit_key_live'] = $setting['intuit_key_live'];
                $data['course_description'] = 1;
                $data['location_notes'] = 1;
                $data['location_notes'] = 1;
                $data['remaining_seats'] = 1;
                $data['promocode'] = 1;
                
                pr($data);
                $this->loadModel('TenantConfigSettings');
                $settingsData = $this->TenantConfigSettings->newEntity();
                $settingsData = $this->TenantConfigSettings->patchEntity($settingsData, $data);
                if ($this->TenantConfigSettings->save($settingsData)){
                    $this->out('TenantSettings saved');
                    $new_id = $settingsData->id;
                    $new_name = 'tenant_config_settings';
                    $old_id = $setting['id'];
                    $old_name = 'config_settings_'.$this->_currentDb ;
                    // pr($old_id);die;
                    $this->out('Mapping Tenant Settings in OldDbHashes table');
                    $this->hashBot($new_id,$old_id,$new_name,$old_name);
		    $settings[$key] = null;
                }else{
                pr($settingsData);die;
                }   
            }
        }
    }

    public function migrateTenantThemes(){
        $themesQuery = "Select * from manage_frontend";
        try{
            $themes = $this->connectWithMigrationDB($themesQuery)->fetchAll('assoc');
        }catch(\Exception $e){
            $this->out('Table not found will not continue;');
            return;
        }
        
        // pr($themes);
        if(!empty($themes)){
            foreach ($themes as $key => $theme) {
                $this->out('migrating themes');
		$data = [];
                // pr($theme);
                // $this->_tenantId = 1;
                $data['content_area'] = $theme['content_area'];
                $data['content_sidebar'] = $theme['sidebar_area'];
                $data['logo_name'] = $theme['logo'];
                $data['logo_path'] = 'tenant_themes/logo_name/';
                $data['tenant_color_light'] = '#e55e6e';
                $data['tenant_color_dark'] = '#db0f0f';
                $data['tenant_id'] =$this->getNewMappedId($this->_currentDb,'old_tenants');
                
                
                // pr($data);
                $this->loadModel('TenantThemes');
                $themesData = $this->TenantThemes->newEntity();
                $themesData = $this->TenantThemes->patchEntity($themesData, $data);
                if ($this->TenantThemes->save($themesData)){
                    $this->out('Tenantthemes saved');
                    $new_id = $themesData->id;
                    $new_name = 'tenant_themes';
                    $old_id = $theme['id'];
                    $old_name = 'manage_frontend_'.$this->_currentDb ;
                    // pr($old_id);die;
                    $this->out('Mapping Tenant themes in OldDbHashes table');
                    $this->hashBot($new_id,$old_id,$new_name,$old_name);
		    $themes[$key] = null;
                }else{

                pr($themesData);die;
                }   
            }
        }
    }

    public function migrateCardPrintingProfiles(){
        $cardQuery = "Select * from cards_profiles";
        try{
            $cards = $this->connectWithMigrationDB($cardQuery)->fetchAll('assoc');
        }catch(\Exception $e){
            $this->out('Table not found will not continue;');
            return;
        }
        
        // pr($themes);
        if(!empty($cards)){
            foreach ($cards as $key =>  $card) {
                $this->out('migrating card printing profiles');
                $data = [];
                // $this->_tenantId = 1;
                $data['name'] = $card['name'];
                $data['left_right_adjustment'] = $card['xpad'];
                $data['up_right_adjustment'] = $card['ypad'];
                $data['status'] = 1  ;
                $data['card_printing_profile_training_sites']['training_site_id'] = $this->getNewMappedId($card['ts'],'trainingsites');
                $data['card_printing_profile_training_sites']['tenant_id'] = $this->getNewMappedId($this->_currentDb,'old_tenants');
                
                
                // pr($data);
                $this->loadModel('CardPrintingProfiles');
                $cardsData = $this->CardPrintingProfiles->newEntity();
                $cardsData = $this->CardPrintingProfiles->patchEntity($cardsData, $data);
                // pr($cardsData);
                if ($this->CardPrintingProfiles->save($cardsData)){
                    $this->out('CardPrintingProfiles saved');
                    $new_id = $cardsData->id;
                    $new_name = 'card_printing_profiles';
                    $old_id = $card['id'];
                    $old_name = 'card_profiles_'.$this->_currentDb ;
                    // pr($old_id);die;
                    $this->out('Mapping CardPrintingProfiles in OldDbHashes table');
                    $this->hashBot($new_id,$old_id,$new_name,$old_name);
		   $cards[$key] = null;
                }else{

                pr($cardsData);die;
                }   
            }
        }
    }

    public function migrateInstructors(){
        $this->loadModel('TrainingSites');
        $oldInstructorsQuery = "Select * from instructors";
        $instructors = $this->connectWithMigrationDB($oldInstructorsQuery)->fetchAll('assoc');
        $myfile = fopen(Configure::read('App.webroot').'/migration_logs/duplicate_emails.json', "a");
        if(!empty($instructors)){
            foreach ($instructors as $key =>  $instructor) {
                $data = [];
                if(in_array($instructor['instructorname'], [null, '', false]) || in_array($instructor['instructoremail'], [null, '', false])){
                    continue;
                }
                if(empty($this->getNewMappedId($instructor['trainingsiteid'],'trainingsites'))){
                    $tenant_id = $this->getNewMappedId($this->_currentDb,'old_tenants');
                    $data['training_site_id'] = $this->TrainingSites->findByTenantId($tenant_id)->first()->id;
                }
                $this->out('migrating Instructors');
                $data['first_name'] = $instructor['instructorname'];
                $data['last_name'] = $instructor['instructorlastname'];
                $data['email'] = $instructor['instructoremail'];
                $data['phone1'] = $instructor['instructorphone'];
                $data['phone2'] = $instructor['instructormobilephone'];
                $data['address'] = $instructor['instuctoraddress'].' '.$instructor['instructoraddress2'];
                $data['city'] = isset($instructor['city']) && $instructor['city']?$instructor['city']:$this->_faker->city;
                $data['state'] = isset($instructor['state']) && $instructor['state']?$instructor['state']:$this->_faker->state;
                $data['zipcode'] = isset($instructor['zip']) && $instructor['zip']?$instructor['zip']:$this->_faker->state;
                $data['password'] = isset($instructor['instructorpassword']) && $instructor['instructorpassword']?$instructor['instructorpassword']:'12345678';
                $data['is_verified'] = 1;
                // pr($instructor);
                $data['training_site_id'] = $this->getNewMappedId($instructor['instructorparent'],'trainingsites');
                $data['tenant_id'] = $this->getNewMappedId($this->_currentDb,'old_tenants');
                $data['status'] = 1;
                $data['token'] = Text::uuid();
                $data['role_id'] = 4;
                $data['lat'] = 99.09;
                $data['lng'] = 0.09;
                // pr($data);
                $this->loadModel('Instructors');
                $instructorData = $this->Instructors->newEntity();
                $instructorData = $this->Instructors->patchEntity($instructorData, $data);
                if ($this->Instructors->save($instructorData)){
                    $this->out($instructorData->first_name.' saved');
                    $new_id = $instructorData->id;
                    $new_name = 'instructors';
                    $old_id = $instructor['instructorsid'];
                    $old_name = 'instructors_'.$this->_currentDb ;
                    // pr($old_id);die;
                    $this->out('Mapping instructors in OldDbHashes table');
                    $this->hashBot($new_id,$old_id,$new_name,$old_name);
		   $instructors[$key] = null;

                }else{
                    if($instructorData->getError('email')['_isUnique'] || $instructorData->getError('email')['email']){

                        fwrite($myfile, json_encode($data));
                        continue;
                    }else{
                        pr($instructorData);die('here');
                        die('outside');
                    }
                }
            }
        }else{
                $this->out('no instructor found in this databases');
        }   
        fclose($myfile); 
    }



    public function migrateTrainingSites(){

        $this->out('migrating trainingsites');
            // pr($this->_tenantId);
        $trainingSiteQuery = "Select * from trainingsites";
        $trainingSites = $this->connectWithMigrationDB($trainingSiteQuery)->fetchAll('assoc');
         if(isset($trainingSites)){
            $this->loadModel('TrainingSites');
        // pr($trainingSites);die;

            foreach ($trainingSites as $key =>  $trainingSite) {
               $this->out('trainingsitename :'.$trainingSite['trainingsitename']); 
               $data = [];
		 $data['name'] = isset($trainingSite['trainingsitename'])?$trainingSite['trainingsitename']:$this->_faker->name;
                $data['phone'] = isset($trainingSite['trainingsitephone'])?$trainingSite['trainingsitephone']:$this->_faker->phoneNumber;
                $data['address'] = $trainingSite['trainingsiteaddress'].' '.$trainingSite['trainingsiteaddress2'];
                $data['city'] = isset($trainingSite['trainingsitecity'])?$trainingSite['trainingsitecity']:$this->_faker->city;
                $data['state'] = isset($trainingSite['trainingsitestate'])?$trainingSite['trainingsitestate']:$this->_faker->state;
                $data['zipcode'] = isset($trainingSite['trainingsitezip'])?$trainingSite['trainingsitezip']:$this->_faker->postcode;
                $data['contact_email'] = isset($trainingSite['trainingsiteowneremail'])?$trainingSite['trainingsiteowneremail']:$this->_faker->email;
                $data['contact_phone'] = isset($trainingSite['trainingsiteownercell'])?$trainingSite['trainingsiteownercell']:$this->_faker->phoneNumber;
                $data['contact_name'] = isset($trainingSite['trainingsiteowner'])?$trainingSite['trainingsiteowner']:$this->_faker->name;
                $data['site_contract_name'] = $trainingSite['upload_sitecontract'];
                $data['site_contract_path'] = 'trainingsite_contract';
                $data['site_contract_date'] = new Time($trainingSite['sitecontract_upload_date']);
                $data['site_monitoring_name'] = $trainingSite['upload_monitoringform'];
                $data['site_monitoring_path'] = 'trainingsite_monitoringform';
                $data['site_monitoring_date'] = new Time($trainingSite['monitordate']);
                $data['site_insurance_name'] = $trainingSite['upload_insurance'];
                $data['site_insurance_path'] = 'trainingsite_insurance';
                $data['site_insurance_expiry_date'] = new Time($trainingSite['insurance_exp']);
                $data['tenant_id'] = $this->getNewMappedId($this->_currentDb,'old_tenants');
                $data['status'] = 1;
                $trainingsiteData = $this->TrainingSites->newEntity();
                $trainingsiteData = $this->TrainingSites->patchEntity($trainingsiteData, $data);
                if ($this->TrainingSites->save($trainingsiteData)){
                    $this->out($trainingsiteData->name.' saved');
                    $new_id = $trainingsiteData->id;
                    $new_name = 'training_sites';
                    $old_id = $trainingSite['trainingsiteid'];
                    $old_name = 'trainingsites_'.$this->_currentDb  ;
                    // pr($old_id);die;
                    $this->hashBot($new_id,$old_id,$new_name,$old_name);
	           $trainingSites[$key] = null;
                }else{
                    pr($trainingsiteData);die('here');
                }

            }
        }


    }


    public function migrateTenants(){
        // $query1 = "Select * from admins";
        // $results = $this->connectWithMigrationDB($query1)->fetchAll('assoc');
        $centerName = substr($this->_currentDb,9);
        $this->out('Migrating Tenants');
        $trainingSiteQuery = "Select * from trainingsites";
        $trainingSites = $this->connectWithMigrationDB($trainingSiteQuery)->fetch('assoc');
        $domainQuery = "Select * from domains";
        $domainData = $this->connectWithMigrationDB($domainQuery)->fetch('assoc');
        // pr($trains);
        if(isset($domainData) && !empty($domainData)){
            // pr($domainData);
            $data['domain_type'] = "http://".$domainData['domain_alias'].".cb.twinspark.co/tenants/login";


        }else{
            $data['domain_type'] = "http://".$centerName.".cb.twinspark.co/tenants/login";
        }
        $this->loadModel('Tenants');
        $tenant = $this->Tenants->newEntity();

        if(isset($trainingSites)){
        // pr($trainingSites);
            
            $data['address'] = $trainingSites['trainingsiteaddress'];
            $data['city'] = $trainingSites['trainingsitecity'];
            $data['state'] = $trainingSites['trainingsitestate'];
            $data['zip'] = $trainingSites['trainingsitezip'];
            $data['email'] = $trainingSites['trainingsiteowneremail'];
        }
        $data['center_name'] = $centerName;
        $data['status'] = 1;
        $data['image_name'] = null;
        $data['image_url'] = 'tenant_images';
            // pr($this->_currentDb);
            pr($data);
        $tenant = $this->Tenants->patchEntity($tenant, $data,['associated' => ['CourseTypeCategories','CourseTypeCategories.CourseTypes']]);
        // pr($tenant);die;

         if ($this->Tenants->save($tenant, ['associated' => ['CourseTypeCategories','CourseTypeCategories.CourseTypes']])) {
            $this->_tenantId = $tenant->id;
            // pr($tenant);die;
            $this->out('tenant saved');
            $new_id = $tenant->id;
            $new_name = 'tenants';
            $old_id = $this->_currentDb;
            $old_name = 'old_tenants_'.$this->_currentDb;
            // pr($old_id);die;
            $this->hashBot($new_id,$old_id,$new_name,$old_name);
         }else{

         pr($tenant);die;
         }
    }

    public function migrateStudents(){

        // $oldCorporateClientIdQuery = "Select clientid from corp_clients";
        // $oldCorporateClientIds = $this->connectWithMigrationDB($oldCorporateClientIdQuery)->fetchAll('assoc');
        // foreach ($oldCorporateClientIds as $oldCorporateClientId) {
            
        //     $newCorporateClientId = $this->getNewMappedId($oldCorporateClientId['clientid']);
        // }
        $this->loadModel('Students');
        $studentsQuery = "Select * from students";
        $students = $this->connectWithMigrationDB($studentsQuery)->fetchAll('assoc');
        $myfile = fopen(Configure::read('App.webroot').'/duplicate_emails.json', "a");
        if(!empty($students)){
                foreach ($students as $key =>  $student) {
                    $this->out('migrating Students');
                       	$data = [];
                        // $this->_tenantId = 1;
                    // pr($student['studentsid']);die;
                        $data['first_name'] = isset($student['studentsname']) && $student['studentsname']?$student['studentsname']:$this->_faker->name;
                        $data['last_name'] = isset($student['studentlastname']) && $student['studentlastname']?$student['studentlastname']:' ';
                        $data['address'] = $student['studentaddress'].' '.$student['studentaddress2'];
                        $data['city'] = $student['studentcity'];
                        $data['state'] = $student['studentstate'];
                        $data['zipcode'] = $student['studentzip'];
                        $data['email'] = isset($student['studentemddress']) && $student['studentemddress']?$student['studentemddress']:$this->_faker->email;
                        $data['phone1'] = $student['studentphone'];
                        $data['phone2'] = $student['studentmobilephone'];
                        $data['status'] = 1;
                        $data['role_id'] = 5;
                        $data['tenant_id'] = $this->getNewMappedId($this->_currentDb,'old_tenants');
                        if(empty($student['studentpassword'])){
                            $data['password'] = '12345';
                        }else{
                            $data['password'] = $student['studentpassword'];
                        }
                        $data['hear_about_us'] = $student['wheredidyouhear'];
                        

                        // pr($data);
                        $studentData = $this->Students->newEntity();
                        $studentData = $this->Students->patchEntity($studentData, $data);

                        if ($this->Students->save($studentData)){
                            
                            $this->out($studentData->first_name.' saved');
                            $new_id = $studentData->id;
                            $new_name = 'students';
                            $old_id = $student['studentsid'];
                            $old_name = 'students_'.$this->_currentDb ;
                            // pr($old_id);die;
                            $this->out('Mapping student in OldDbHashes table');
                            $this->hashBot($new_id,$old_id,$new_name,$old_name);
			    $students[$key] = null;
                        }else{
                        // pr($studentData);die;
                        if($studentData->getError('email')['_isUnique'] || $studentData->getError('email')['email']){
                             fwrite($myfile, 'student_emails'.json_encode($data));
                             continue;
                            }else{
                                pr($studentData);die;
                                die('outside');
                            }
                        }
                    

                }   
            }else{
                $this->out('no Students found in this admin table');
            }
            fclose($myfile);

    }



    public function migrateCorporateClients(){

        $corporateClientQuery = "Select * from corp_clients";
        try{
            $corporateClients = $this->connectWithMigrationDB($corporateClientQuery)->fetchAll('assoc');
        }catch(\Exception $e){
            $this->out('Table not found will not continue;');
            return;
        }
        $this->out('currentDb : '.$this->_currentDb);
        $this->out('saving Corporate Clients');
        $this->loadModel('CorporateClients');

        // pr($corporateClients);
         if(!empty($corporateClients)){
                foreach ($corporateClients as $key => $corporateClient) {
			$data = [];
                        if(!isset($corporateClient['clientparent']) && empty($corporateClient['clientparent'])){
                            continue;
                        }
                        $this->out('migrating corporate clients');
                        // pr($corporateClient);
                        // $this->_tenantId = 1;
                        $address = $corporateClient['clientaddress'].' '.$corporateClient['clientaddress2'];
                        $data['name'] = $corporateClient['clientname'];
                        $data['address'] = isset($address) && $address?$corporateClient['clientaddress'].' '.$corporateClient['clientaddress2']:$this->_faker->address;
                        $data['city'] = isset($corporateClient['clientcity']) && $corporateClient['clientcity']?$corporateClient['clientcity']:$this->_faker->city;
                        $data['state'] = isset($corporateClient['clientstate']) && $corporateClient['clientstate']?$corporateClient['clientstate']:$this->_faker->state;
                        $data['zipcode'] = isset($corporateClient['clientzip']) && $corporateClient['clientzip']?$corporateClient['clientzip']:$this->_faker->postcode;
                        // $data['web_page'] = $corporateClient['frontend'];
                        $data['web_page'] = 1;
                        $data['status'] = 1;
                        $data['role_id'] = 3;
                        $data['tenant_id'] = $this->getNewMappedId($this->_currentDb,'old_tenants');
                        if(isset($corporateClient['corpurl'])){
                            $data['web_url'] = $corporateClient['corpurl'];
                        }else{
                            $data['web_url'] = 0;                     
                        }
                        $data['training_site_id'] = $this->getNewMappedId($corporateClient['clientparent'],'trainingsites');

                        // pr($data);
                        $corporateClientData = $this->CorporateClients->newEntity();
                        // pr($corporateClientData);die;
                         $corporateClientData = $this->CorporateClients->patchEntity($corporateClientData, $data);
                        if ($this->CorporateClients->save($corporateClientData)){
                            $this->out($corporateClientData->name.' saved');
                            $new_id = $corporateClientData->id;
                            $new_name = 'corporateClients';
                            $old_id = $corporateClient['clientid'];
                            $old_name = 'corp_clients_'.$this->_currentDb ;
                            // pr($corporateClientData);die;
                            $this->out('Mapping corporateClient in OldDbHashes table');
                            $this->hashBot($new_id,$old_id,$new_name,$old_name);
                       	   $corporateClients[$key] = null;
			 }else{
                         pr($corporateClientData);pr('corporateClient');die('here');
                        }
                }   
            }else{
                $this->out('no CorporateClients found in this admin table');
            }

    }
    public function migrateInstructorApplications(){
        $instructorApplicationQuery = "Select * from instructor_creds";
        try{
            $instructorApplications = $this->connectWithMigrationDB($instructorApplicationQuery)->fetchAll('assoc');
        }catch(\Exception $e){
            $this->out('Table not found will not continue;');
            return;
        }
        $this->out('currentDb : '.$this->_currentDb);
        $this->out('saving Instructor Applications');
        $this->loadModel('InstructorApplications');
        if(!empty($instructorApplications)){
                foreach ($instructorApplications as $key => $instructorApplication) {
                   	$data = [];
			 $this->out('migrating Instructor Applications');
                        if(empty($instructorApplication['instructor_application']) || in_array($instructorApplication['instructor_application'], [null, '', false])){
                            pr('Document Name is Missing IN InstructorApplications');
                            continue;
                        }
                        pr($instructorApplication);
                        if(empty($this->getNewMappedId($instructorApplication['instructor_profile_id'],'instructors'))){
                            continue;
                        }
                        // $data['instructor_id'] = $instructorApplication['instructor_profile_id'];
                        $data['instructor_id'] = $this->getNewMappedId($instructorApplication['instructor_profile_id'],'instructors');

                        $data['document_name'] = $instructorApplication['instructor_application'];
                        $data['document_path'] = '/instructor_files';
                        $instructorApplicationData = $this->InstructorApplications->newEntity();
                         $instructorApplicationData = $this->InstructorApplications->patchEntity($instructorApplicationData, $data);
                        pr($instructorApplicationData);
                        if ($this->InstructorApplications->save($instructorApplicationData)){
                            $this->out($instructorApplicationData->name.' saved');
                            $new_id = $instructorApplicationData->id;
                            $new_name = 'InstructorApplication';
                            $old_id = $instructorApplication['instructor_profile_id'];
                            $old_name = 'instructor_creds_'.$this->_currentDb ;
                            // pr($corporateClientData);die;
                            $this->out('Mapping InstructorApplication in OldDbHashes table');
                            $this->hashBot($new_id,$old_id,$new_name,$old_name);
                   		$instructorApplications[$key] = null;    
		    }else{
                         pr($instructorApplicationData);pr('Instructor Application');die('here');
                        }
                }   
            }else{
                $this->out('no corporateClients found in this admin table');
            }
    }
    public function migrateInstructorInsuranceForms(){
        $instructorInsuranceFormsQuery = "Select * from instructor_creds";
        try{
            $instructorInsuranceForms = $this->connectWithMigrationDB($instructorInsuranceFormsQuery)->fetchAll('assoc');
        }catch(\Exception $e){
            $this->out('Table not found will not continue;');
            return;
        }
        $this->out('currentDb : '.$this->_currentDb);
        $this->out('saving Instructor Insurance Forms');
        $this->loadModel('InstructorInsuranceForms');
        if(!empty($instructorInsuranceForms)){
                foreach ($instructorInsuranceForms as $key => $instructorInsuranceForm) {
                       $data = [];
			 if(empty($instructorInsuranceForm['insurance_form_upload']) || in_array($instructorInsuranceForm['insurance_form_upload'], [null, '', false])){
                            // pr('test');
                            continue;
                        }
                        if(empty($this->getNewMappedId($instructorInsuranceForm['instructor_profile_id'],'instructors'))){
                            continue;
                        }
                        $this->out('migrating instructor Insurance Forms');
                        $data['instructor_id'] = $this->getNewMappedId($instructorInsuranceForm['instructor_profile_id'],'instructors');
                        // $data['instructor_id'] = $instructorInsuranceForm['instructor_profile_id'];
                        $data['document_name'] = $instructorInsuranceForm['insurance_form_upload'];
                        $data['document_path'] = '/instructor_files';
                        $data['date'] = new Time($instructorInsuranceForm['insuranceexp']);
                        $instructorInsuranceFormsData = $this->InstructorInsuranceForms->newEntity();
                        $instructorInsuranceFormsData = $this->InstructorInsuranceForms->patchEntity($instructorInsuranceFormsData, $data);
                        pr('here in data');pr($instructorInsuranceFormsData);pr('after data');
                        if ($this->InstructorInsuranceForms->save($instructorInsuranceFormsData)){
                            $this->out($instructorInsuranceFormsData->name.' saved');
                            $new_id = $instructorInsuranceFormsData->id;
                            $new_name = 'instructorInsuranceForms';
                            $old_id = $instructorInsuranceForm['instructor_profile_id'];
                            $old_name = 'instructor_creds_'.$this->_currentDb ;
                            // pr($corporateClientData);die;
                            $this->out('Mapping instructorInsuranceForms in OldDbHashes table');
                            $this->hashBot($new_id,$old_id,$new_name,$old_name);
                       		$instructorInsuranceForms[$key] = null;
			 }else{
                         pr($instructorInsuranceFormsData);pr('Instructor Insurance Forms');die('here');
                        }
                }   
            }else{
                $this->out('no Instructors found in this admin table');
            }
    }
    public function migrateInstructorQualifications(){
        $instructorQualificationsQuery = "SELECT * FROM `instructor_certifications` as ic INNER JOIN instructor_cert_types ON ic.inst_cert_type_id = instructor_cert_types.ins_cert_id";
        try{
            $instructorQualifications = $this->connectWithMigrationDB($instructorQualificationsQuery)->fetchAll('assoc');
        }catch(\Exception $e){
            $this->out('Table not found will not continue;');
            return;
        }
        $this->out('currentDb : '.$this->_currentDb);
        $this->out('saving Instructor Qualifications');
        $this->loadModel('InstructorQualifications');
        $myfile = fopen(Configure::read('App.webroot').'/migration_logs/instructor_qualifications.json', "a");

        if(!empty($instructorQualifications)){
                foreach ($instructorQualifications as $key => $instructorQualification) {
			$data = [];
                        $this->out('migrating instructor Qualifications');
                        if(empty($instructorQualification['inst_cert_upload_file_name']) || in_array($instructorQualification['inst_cert_upload_file_name'], [null, '', false])){
                            // pr('test');
                            continue;
                        }
                        if(empty($instructorQualification['ins_certification_name']) || in_array($instructorQualification['ins_certification_name'], [null, '', false])){
                            $instructorQualification['ins_certification_name'] = 'Missing Name';
                            fwrite($myfile, json_encode($instructorQualification));
                            continue;
                        }
                        if(empty($instructorQualification['inst_cert_prof_id']) || in_array($instructorQualification['inst_cert_prof_id'], [null, '', false])){
                            $instructorQualification['inst_cert_prof_id'] = 'Missing Instructor Id';
                            fwrite($myfile, json_encode($instructorQualification));
                            continue;
                        }
                        if(empty($this->getNewMappedId($instructorQualification['inst_cert_prof_id'],'instructors'))){
                            continue;
                        }
                        // pr($instructorQualification['ins_certification_name']);die;
                        $data['instructor_id'] = $this->getNewMappedId($instructorQualification['inst_cert_prof_id'],'instructors');
                        // $data['instructor_id'] = $instructorQualification['inst_cert_prof_id'];
                        $data['qualification_id'] = $this->qualificationName($instructorQualification['ins_certification_name']);
                        $data['expiry_date'] = new Date($instructorQualification['inst_cert_exp_date']);
                        $data['last_monitored'] = new Date($instructorQualification['inst_cert_mon_date']);
                        if($instructorQualification['inst_cert_exp_date'] == '0000-00-00' || $instructorQualification['inst_cert_mon_date'] == '0000-00-00'){
                            $data['expiry_date'] = $data['expiry_date']->setDate(2020, 01, 01);
                            $data['last_monitored'] = $data['last_monitored']->setDate(2020,01,01);
                        }
                        $data['qualification_type_id'] = null;
                        $data['license_number'] = isset($instructorQualification['inst_certidnum']) && $instructorQualification['inst_certidnum']?$instructorQualification['inst_certidnum']:'12345678';
                        $data['document_name'] = $instructorQualification['inst_cert_upload_file_name'];
                        $data['document_path'] = '/instructor_files';
                        pr('here in data');pr($data);pr('after data');
                        $instructorQualificationsData = $this->InstructorQualifications->newEntity();
                        $instructorQualificationsData = $this->InstructorQualifications->patchEntity($instructorQualificationsData, $data);
                        if ($this->InstructorQualifications->save($instructorQualificationsData)){
                            if($instructorQualification['inst_cert_exp_date'] == '0000-00-00' || $instructorQualification['inst_cert_mon_date'] == '0000-00-00'){
                                fwrite($myfile, json_encode($instructorQualificationsData));
                            }
                            $this->out($instructorQualificationsData->name.' saved');
                            $new_id = $instructorQualificationsData->id;
                            $new_name = 'InstructorQualification';
                            $old_id = $instructorQualification['inst_cert_id'];
                            $old_name = 'instructor_certifications_'.$this->_currentDb ;
                            // pr($corporateClientData);die;
                            $this->out('Mapping InstructorQualification in OldDbHashes table');
                            $this->hashBot($new_id,$old_id,$new_name,$old_name);
                       		$instructorQualifications[$key] = null;
			 }else{
                         pr($instructorQualificationsData);pr('Instructor Qualifications');die('here');
                        }
                }   
            }else{
                $this->out('no instructor found in this admin table');
            }
            fclose($myfile); 
    }
    public function migrateInstructorReferences(){
        $instructorReferencesQuery = "Select * from instructor_references";
        try{
            $instructorReferences = $this->connectWithMigrationDB($instructorReferencesQuery)->fetchAll('assoc');
        }catch(\Exception $e){
            $this->out('Table not found will not continue;');
            return;
        }
        // pr($instructorReferences);die;
        $this->out('currentDb : '.$this->_currentDb);
        $this->out('saving Instructor References');
        $this->loadModel('InstructorReferences');
        $myfile = fopen(Configure::read('App.webroot').'/migration_logs/duplicate_emails.json', "a");
        if(!empty($instructorReferences)){
                foreach ($instructorReferences as $key => $instructorReference) {
                        // pr($key);die;
			$data = [];
                        $this->out('migrating instructor References');
                        if(in_array($instructorReference['ref1_name'], [null, '', false]) && in_array($instructorReference['ref2_name'], [null, '', false]) && in_array($instructorReference['ref3_name'], [null, '', false]) && in_array($instructorReference['ref1_phone'], [null, '', false]) && in_array($instructorReference['ref2_phone'], [null, '', false]) && in_array($instructorReference['ref3_phone'], [null, '', false]) && in_array($instructorReference['ref1_email'], [null, '', false]) && in_array($instructorReference['ref2_email'], [null, '', false]) && in_array($instructorReference['ref3_email'], [null, '', false])){
                            // pr('test');
                            continue;
                        }

                        $referenceArray[] = [ 'name' => $instructorReference['ref1_name'],
                                    'email' => $instructorReference['ref1_email'],
                                    'phone_number' =>  $instructorReference['ref1_phone']
                                  ];
                        $referenceArray[] = [ 'name' => $instructorReference['ref2_name'],
                                    'email' => $instructorReference['ref2_email'],
                                    'phone_number' =>  $instructorReference['ref2_phone']
                                  ];
                        $referenceArray[] = [ 'name' => $instructorReference['ref3_name'],
                                    'email' => $instructorReference['ref3_email'],
                                    'phone_number' =>  $instructorReference['ref3_phone']
                                  ];
                        foreach ($referenceArray as $key => $value) {
                            if(empty($value['name']) || in_array($value['name'], [null, '', false])){
                                continue;
                            }
                            if(empty($this->getNewMappedId($instructorReference['creds_inst_id'],'instructors'))){
                                continue;
                            }
                            // $data['instructor_id'] = $instructorReference['creds_inst_id'];
                            $data['instructor_id'] = $this->getNewMappedId($instructorReference['creds_inst_id'],'instructors');
                            $data['name'] = $value['name'];
                            $data['phone_number'] = $value['phone_number'];
                            $data['email'] = $value['email'];
                            pr($data);
                            $instructorReferencesData = $this->InstructorReferences->newEntity();
                            $instructorReferencesData = $this->InstructorReferences->patchEntity($instructorReferencesData, $data);
                            if ($this->InstructorReferences->save($instructorReferencesData)){
                                $this->out($instructorReferencesData->name.' saved');
                                $new_id = $instructorReferencesData->id;
                                $new_name = 'InstructorReferences';
                                $old_id = $instructorReference['creds_inst_id'];
                                $old_name = 'instructor_references_'.$this->_currentDb ;
                                // pr($corporateClientData);die;
                                $this->out('Mapping InstructorReferences in OldDbHashes table');
                                $this->hashBot($new_id,$old_id,$new_name,$old_name);
                        	$instructorReferences[$key] = null;   
			 }else{
                                if($instructorReferencesData->getError('email')['_isUnique'] || $instructorReferencesData->getError('email')['email']){
                                    fwrite($myfile, json_encode($data));
                                    continue;
                                }else{
                                    pr($instructorReferencesData);pr('Instructor References');die;
                                    die('outside');
                                }       
                            }
                        }                      
                }   
            }else{
                $this->out('no instructor found in this admin table');
            }
        fclose($myfile); 

    }
    public function qualifications(){
        $qualificationsQuery = "SELECT DISTINCT ins_certification_name FROM instructor_cert_types";
        try{
            $qualifications = $this->connectWithMigrationDB($qualificationsQuery)->fetchAll('assoc');
        }catch(\Exception $e){
            $this->out('Table not found will not continue;');
            return;
        }
        $this->out('currentDb : '.$this->_currentDb);
        $this->out('saving Qualifications');
        $this->loadModel('Qualifications');
        foreach ($qualifications as $key => $qualification) {
            $data['name'] = $qualification['ins_certification_name'];
            $data['status'] = 1;
            pr($data);
            $qualificationsData = $this->Qualifications->newEntity();
            if($this->Qualifications->findByName($qualification['ins_certification_name'])->first()){
                pr('Qualifications Present In Database');
                continue;
            }
            $qualificationsData = $this->Qualifications->patchEntity($qualificationsData, $data);
            if ($this->Qualifications->save($qualificationsData)){
                $this->out($qualificationsData->name.' saved');
                $this->out('Mapping qualificationsData');
            }else{
                pr($qualificationsData);die;      
            }
        }
    }
    public function qualificationName($name){
        pr($name);
        $this->loadModel('Qualifications');
        $qualificationId = $this->Qualifications->findByName($name)->first()->id;
        return $qualificationId;
    }
    public function addTrainingSiteToInstructor(){
        $this->loadModel('Instructors');
        $oldInstructorsQuery = "Select * from instructors";
        $instructors = $this->connectWithMigrationDB($oldInstructorsQuery)->fetchAll('assoc');
        $myfile = fopen(Configure::read('App.webroot').'/migration_logs/instrcutorMissing.json', "a");
        if(!empty($instructors)){
            foreach ($instructors as $key => $singleInstructor) {
                $newInstructorId = $this->getNewMappedId($singleInstructor['instructorsid'],'instructors');
                if(!isset($newInstructorId) || empty($newInstructorId)){
                    continue;
                }
                $newTrainingSiteId = $this->getNewMappedId($singleInstructor['instructorparent'],'trainingsites');
                $instructorData = $this->Instructors->findById($newInstructorId)->first();
                $data['training_site_id'] = $newTrainingSiteId;
                $instructorsData = $this->Instructors->patchEntity($instructorData,$data);
                if(!$this->Instructors->save($instructorsData)){
                    if($instructorData->getError('email')['_isUnique'] || $instructorData->getError('email')['email']){
                        fwrite($myfile, json_encode($data));
                        continue;
                    }else{
                        pr($instructorData);die('here');
                    }
                }
                $this->out('Instructors Id Saved '.$instructorData->id);
            }
        }
    } 
    public function addTrainingSiteToStudents(){
        $this->loadModel('Students');
        $oldInstructorsQuery = "Select * from students";
        $students = $this->connectWithMigrationDB($oldInstructorsQuery)->fetchAll('assoc');
        $myfile = fopen(Configure::read('App.webroot').'/migration_logs/studentsMissing.json', "a");
        if(!empty($students)){
            foreach ($students as $key => $singleStudent) {
                $newStudentId = $this->getNewMappedId($singleStudent['studentsid'],'students');
                if(!isset($newStudentId) || empty($newStudentId)){
                    continue;
                }
                $newTrainingSiteId = $this->getNewMappedId($singleStudent['studentparent'],'trainingsites');
                $studentData = $this->Students->findById($newStudentId)->first();
                $data['training_site_id'] = $newTrainingSiteId;
                $studentData = $this->Students->patchEntity($studentData,$data);
                if(!$this->Students->save($studentData)){
                    if($studentData->getError('email')['_isUnique'] || $studentData->getError('email')['email']){
                        fwrite($myfile, json_encode($data));
                        continue;
                    }else{
                        pr($studentData);die('here');
                    }
                }
                $this->out('Students Id Saved '.$studentData->id);
            }
        }
    }

}
