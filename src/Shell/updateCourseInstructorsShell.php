<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Database\Schema\TableSchema;
/**
 * UpdateTenantSettings shell command.
 */
class UpdateCourseInstructorsShell extends Shell
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
        $this->updateCourseInstructors();
    }

    public function updateCourseInstructors(){
        $this->loadModel('Courses');
        $this->loadModel('CourseInstructors');

        $courses = $this->Courses->find()->contain(['CourseInstructors'])->toArray();

        foreach ($courses as $key => $course) {
            if(isset($course['instructor_pay']) && !empty($course['instructor_pay'])) {
                if(!empty($course->course_instructors)) {
                    foreach ($course->course_instructors as $value) {
                        if(!$value->instructor_pay || empty($value->instructor_pay)) {
                            $data['instructor_pay'] = $course['instructor_pay'];
                            if(!$value->additional_pay || empty($value->additional_pay)) {
                                $data['additional_pay'] = $course['additional_pay'];
                            }

                            $courseInstructor = $this->CourseInstructors->patchEntity($value, $data);
                            if(!$this->CourseInstructors->save($courseInstructor)){
                            $this->out('Already Present ! '.$courseInstructor->id);
                            pr($courseInstructor);die;
                            } else {

                            $this->out('Saved successfuly for '.$value->id); 
                            }
                        } else {
                            $this->out('Already saved for '.$value->id);
                        }
                    }
                }
                
            }
        }
    }
}
