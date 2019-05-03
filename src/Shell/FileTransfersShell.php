<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use Aws\S3\S3Client;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use League\Flysystem\Filesystem;
use Cake\Core\Configure;




/**
 * FileTransfers shell command.
 */
class FileTransfersShell extends Shell
{

    protected $tableNameArray = [
                                    'trainingsites' => 'trainingsitesFileTransfer',
                                    'instructors' => 'instructorsFileTransfer',
                                    'corporateclients' => 'corporateclientsFileTransfer',
                                    'courseuploads' => 'courseuploadsFileTransfer',
                                    'rosters' => 'courseRosterFileTransfer'
                                ];
    protected $_client = false;                                                        
    protected $_dest = false;
    protected $_count = false;                                                        
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

    /**
     * main() method.
     *
     * @return bool|int|null Success or error code.
     */
    public function main()
    {   
        $this->_client = Configure::read('S3key');
        $this->_dest = 'ts-classbyte-test';
        $this->_count = 0;
        $this->fileTransfers();
    }
    public function fileTransfers(){ 
        $path = '/newvolume/www.mycprpros.com/uploadts/';
        // $path = '/home/daftpung/Downloads/FileData/uploadts';
        $this->test($path,null,'uploadts');
    }
    public function test($path,$parentFolder=null, $currentFolder){
        if($this->is_dir_empty($path)){
            return false;
        }
        $dir = new Folder($path);
        $folder = $dir->read();
        $folders = $folder[0];
        $files = $folder[1];
        if(!empty($folders)){
            foreach ($folders as $key => $value) {
                $newPath = $path.'/'.$value;
                $this->test($newPath, $currentFolder, $value);
            }
            if(array_key_exists($parentFolder,$this->tableNameArray) && !isset($this->tableNameArray[$currentFolder])){
                $functionName = $this->tableNameArray[$parentFolder];
                $this->$functionName($files,$currentFolder,$path);
            }
        }elseif(empty($folders) && !empty($files)){
            if(isset($this->tableNameArray[$currentFolder])){
                $functionName = $this->tableNameArray[$currentFolder];
                $this->$functionName($files,$parentFolder,$path);
            }elseif(isset($this->tableNameArray[$parentFolder])){
                $functionName = $this->tableNameArray[$parentFolder];
                $this->$functionName($files,$currentFolder,$path);
            }

        }else{
            // pr($currentFolder);
            return;
        }
        // $this->out('Total File Upload '.$this->_count);
    }
    public function is_dir_empty($dir) {
        if (!is_readable($dir)) return NULL; 
        return (count(scandir($dir)) == 2);
    }
    public function instructorsFileTransfer($file,$id,$path){
       // return;
       $this->loadModel('InstructorQualifications');
       $this->loadModel('InstructorApplications');
       $this->loadModel('InstructorInsuranceForms');
       $this->loadModel('OldDbHashes');
       $new_ids = $this->OldDbHashes->find()->where(['old_id' => $id,'old_name' => 'instructors_classbdb_cprpros'])->first();
       if(isset($new_ids) && !empty($new_ids)){
          $new_id = $new_ids->new_id;
           foreach ($file as $key => $value) {
               $config = [];
               $instructorsApplications = $this->InstructorApplications->find()->where(['instructor_id' => $new_id,'document_name' => $value])->toArray();
               $instructorQualifications = $this->InstructorQualifications->find()->where(['instructor_id' => $new_id,'document_name' => $value])->toArray();
               $nstructorInsuranceForms = $this->InstructorInsuranceForms->find()->where(['instructor_id' => $new_id,'document_name' => $value])->toArray();
               if(!empty($instructorsApplications)){
                    $key = $value;
                    $source = $path.'/'.$value;
                    $config = [
                                'Bucket' => $this->_dest,
                                'ACL' => 'public-read',
                                'Key'    => str_replace('/','',Configure::read('ImageUpload.uploadPathForInstructorsApplications')).'/'.$key,
                                'SourceFile' => $source
                            ];
               }
               if(!empty($instructorQualifications)){
                    $key = $value;
                    $source = $path.'/'.$value;
                    $config = [
                                'Bucket' => $this->_dest,
                                'ACL' => 'public-read',
                                'Key'    => str_replace('/','',Configure::read('ImageUpload.uploadPathForInstructorQualifications')).'/'.$key,
                                'SourceFile' => $source
                            ];
               }
               if(!empty($nstructorInsuranceForms)){
                    $key = $value;
                    $source = $path.'/'.$value;
                    $config = [
                                'Bucket' => $this->_dest,
                                'ACL' => 'public-read',
                                'Key'    => str_replace('/','',Configure::read('ImageUpload.uploadPathForInstructorsForms')).'/'.$key,
                                'SourceFile' => $source
                            ];
               }
               if(isset($config) && !empty($config)){
                    $res = $this->_client->putObject($config);
                    $this->_count++;
                    $this->out('Instructors');
                    $this->out('Folder'.$id);
                    $this->out('Total File Upload '.$this->_count);  
               }
           }
        }
    }

    public function trainingsitesFileTransfer($file,$id,$path){
        // return;
        $this->loadModel('TrainingSites');
        $this->loadModel('OldDbHashes');
        $new_ids = $this->OldDbHashes->find()->where(['old_id' => $id,'old_name' => 'trainingsites_classbdb_cprpros'])->first();
        if(isset($new_ids) && !empty($new_ids)){
            $new_id = $new_ids->new_id;
            foreach ($file as $key => $value) {
               $config = [];
               $trainingSitesContract = $this->TrainingSites->find()
                                                              ->where(['id' => $new_id, 
                                                                       'site_contract_name' => $value
                                                                    ])
                                                              ->first();
                $trainingSitesMonitoring = $this->TrainingSites->find()
                                                              ->where(['id' => $new_id, 
                                                                       'site_monitoring_name' => $value
                                                                    ])
                                                              ->first();
                $trainingSitesInsurance = $this->TrainingSites->find()
                                                              ->where(['id' => $new_id, 
                                                                       'site_insurance_name' => $value
                                                                    ])
                                                              ->first();
               if(!empty($trainingSitesContract)){
                    $key = $value;
                    $source = $path.'/'.$value;
                    $config = [
                                'Bucket' => $this->_dest,
                                'ACL' => 'public-read',
                                'Key'    => str_replace('/','',Configure::read('ImageUpload.uploadPathForTrainingSiteContract')).'/'.$key,
                                'SourceFile' => $source
                            ];
               }
               if(!empty($trainingSitesMonitoring)){
                    $key = $value;
                    $source = $path.'/'.$value;
                    $config = [
                                'Bucket' => $this->_dest,
                                'ACL' => 'public-read',
                                'Key'    => str_replace('/','',Configure::read('ImageUpload.uploadPathForTrainingSiteMonitoringForm')).'/'.$key,
                                'SourceFile' => $source
                            ];
               }
               if(!empty($trainingSitesInsurance)){
                    $key = $value;
                    $source = $path.'/'.$value;
                    $config = [
                                'Bucket' => $this->_dest,
                                'ACL' => 'public-read',
                                'Key'    => str_replace('/','',Configure::read('ImageUpload.uploadPathForTrainingSiteInsurance')).'/'.$key,
                                'SourceFile' => $source
                            ];
               }
               if(isset($config) && !empty($config)){ 
                    $res = $this->_client->putObject($config);
                    $this->_count++;
                    $this->out('TrainingSites');
                    $this->out('Folder'.$id);
                    $this->out('Total File Upload '.$this->_count); 

               }
           }
       }   
    }

    public function courseuploadsFileTransfer($file,$id,$path){
        // return;
        $this->loadModel('CourseDocuments');
        $this->loadModel('OldDbHashes');
        foreach ($file as $key => $value) {
            $courseDocuments = $this->CourseDocuments->find()->where(['document_name' => $value])->toArray();
            if(!empty($courseDocuments)){
                $key = $value;
                $source = $path.'/'.$value;
                $config = [
                            'Bucket' => $this->_dest,
                            'ACL' => 'public-read',
                            'Key'    => str_replace('/','',Configure::read('ImageUpload.uploadPathForCourseDocuments')).'/'.$key,
                            'SourceFile' => $source
                        ];
                // pr($config);die;        
                $res = $this->_client->putObject($config);
                $this->_count++;
                $this->out('CourseDocuments');
                $this->out('Folder',$id);
                $this->out('Total File Upload '.$this->_count);  

            }
        }
    }

    public function corporateclientsFileTransfer($file,$id,$path){
        // return;
        $this->loadModel('CorporateClientDocuments');
        $this->loadModel('OldDbHashes');
        $new_ids = $this->OldDbHashes->find()->where(['old_id' => $id,'old_name' => 'corp_uploads_classbdb_cprpros'])->first();
        if(isset($new_ids) && !empty($new_ids)){
            $new_id = $new_ids->new_id;
            foreach ($file as $key => $value) {
                $corporateClientDocuments = $this->CorporateClientDocuments->find()->where(['corporate_client_id '=>$new_id,'document_name' => $value])->toArray();
                if(!empty($corporateClientDocuments)){
                    $key = $value;
                    $source = $path.'/'.$value;
                    $config = [
                                'Bucket' => $this->_dest,
                                'ACL' => 'public-read',
                                'Key'    => str_replace('/','',Configure::read('ImageUpload.uploadPathForCorporateClientDocuments')).'/'.$key,
                                'SourceFile' => $source,
                            ];
                    $res = $this->_client->putObject($config);
                    $this->_count++;
                    $this->out('CorporateClientDocuments');
                    $this->out('Folder'.$id);
                    $this->out('Total File Upload '.$this->_count);  

                }
            }
        }
    }

    public function courseRosterFileTransfer($file,$id,$path){
        // return;
        $this->loadModel('Courses');
        $this->loadModel('OldDbHashes');
        $myfile = fopen(Configure::read('App.webroot').'/fileNotTransfer.json', "a");
        foreach ($file as $key => $value) {
            $courseData = explode("-",$value);
            if(!array_key_exists(2, $courseData) || !isset($courseData[2]) || empty($courseData[2])){
                $inValid = [ 'fileName' => $value ];
                fwrite($myfile, json_encode($inValid));
                continue;
            }
            $old_course_id = $courseData[2];
            $new_course_id = $this->OldDbHashes->find()->where(['old_id' => $old_course_id,'old_name' => 'scheduledcourses_classbdb_cprpros'])->first();
            if(isset($new_course_id) && !empty($new_course_id)){
                $new_id = $new_course_id->new_id;
                $course = $this->Courses->findById($new_id)->first();
                $data['document_name'] = $value;
                $data['document_path'] = Configure::read('ImageUpload.uploadPathForCourseRoster');
                $course = $this->Courses->patchEntity($course,$data);
                if(!$this->Courses->save($course)){
                    $missingData = [
                                        'file_name' => $value,
                                        'old_course_id' => $old_course_id,
                                        'new_course_id' => $new_id,
                                        'folder_name' => $id
                                    ];
                    fwrite($myfile, json_encode($missingData));
                    fclose($myfile);
                    continue;
                }
                if(!empty($course)){
                    $key = $value;
                    $source = $path.'/'.$value;
                    $config = [
                                'Bucket' => $this->_dest,
                                'ACL' => 'public-read',
                                'Key'    => str_replace('/','',Configure::read('ImageUpload.uploadPathForCourseRoster')).'/'.$key,
                                'SourceFile' => $source
                            ];
                    $res = $this->_client->putObject($config);
                    $this->_count++;
                    $this->out('CoursesRoster');
                    $this->out('Course Id '.$new_id);
                    $this->out('Total File Upload '.$this->_count);  

                }

            }
        }
    }
}
