<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls; 
use Cake\Filesystem\File;
use Cake\Filesystem\Folder;
use Cake\ORM\TableRegistry;
use Cake\Collection\Collection;
use Robotusers\Excel\Registry;


/**
 * CourseType shell command.
 */
class CourseTypeShell extends Shell
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

    /**
     * main() method.
     *
     * @return bool|int|null Success or error code.
     */
    public function main()
    {
        $this->out($this->OptionParser->help());
        // $this->CourseTypes = Table
        $this->CourseTypes = TableRegistry::get('CourseTypes');
        $this->Emails = TableRegistry::get('Emails');        


         // $this->connectWithMigrationDB();
        $this->courseType();
        // $this->test();
    }
    public function connectWithMigrationDB($query){
       
        $conn = ConnectionManager::get('oldDb');
        $response = $conn->execute($query);
        return $response;
    }
    public function courseType(){
        // die('here');
      $query = "SELECT
    ct.coursetypename AS name,
    ct.comments AS descriptions,
    ct.certificationvalidfor AS valid,
    ct.class_details,
    ct.coursetypecolor AS color_code,
    ct.coursestatus AS status,
    ct.userdefined_courseid AS course_code,
    ct.notes_to_instructor,
    ict.ins_certification_agency AS agency_id,
    IF(
        ct.coursedeliverymethod BETWEEN 1 AND 8,
        ct.coursedeliverymethod,
        9
    ) AS course_type_category_id,
    IF(
        ct.coursedeliverymethod BETWEEN 1 AND 8,
        cct.coursekeyscategoryname,
        'Uncategorized'
    ) AS category_name,
    IF(
        ct.coursedeliverymethod BETWEEN 1 AND 8,
        cct.coursekeyscategorydescription,
        'Uncategorized'
    ) AS category_description,
    IF(
        ct.coursedeliverymethod BETWEEN 1 AND 8,
        cct.coursekeystatus,
        1
    ) AS category_status
FROM
    classbytes2.coursetypes AS ct
LEFT JOIN
    classbytes2.instructor_cert_types AS ict
ON
    ct.coursetypecert = ict.ins_cert_id
LEFT JOIN
    course_category_type cct
ON
    cct.coursekeyscategoryid = ct.coursedeliverymethod;";
    // pr($query);die;
      $results = $this->connectWithMigrationDB($query)->fetchAll('assoc');
      // pr($results);die;
      $results = (new Collection($results))->groupBy('course_type_category_id')->map(function($value){
        $data = [
            'name' => $value[0]['category_name'],
            'description' => $value[0]['category_description'],
            'status' => $value[0]['category_status'],
            'course_types' => (new Collection($value))->map(function($val){
              $val['descriptions'] = $val['descriptions']?str_replace('"', "'", $val['descriptions']):'';
              $val['status'] =  $val['status'] == 'available' ? true : false;
               unset($val['category_name']);
               unset($val['category_description']);
               unset($val['category_status']);
               unset($val['course_type_category_id']);
               return $val;

            })->toArray()
        ];
        return $data;
      })->toArray();
      $results = array_values($results);
      // pr($results);
      $file = Configure::read('App.webroot').'/courseTypes.json';
      if(file_put_contents($file, json_encode($results))){
        // $courseTypeData = json_decode(file_get_contents($file), True);
        pr($courseTypeData);die;
        $this->out('done');
      }
    }
}
