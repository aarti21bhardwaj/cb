<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Event\Event;
use Cake\Event\EventManager;


/**
 * SendEmails shell command.
 */
class SendEmailsShell extends Shell
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
        // die('here');
        $this->out($this->OptionParser->help());
        $this->getAllEvents();
    }
    public function getAllEvents(){
        $this->loadModel('Events');

        $events = $this->Events->find()
                                ->contain(['EventVariables','Emails' => function($q) {
                                                                                            return $q->where(['Emails.status' => 1]);
                                                                                        },
                                            'Emails.EmailConfigurations','Emails.EmailRecipients','Emails.EmailCourseTypes'])
                                ->where(['is_schedulable' => 1])
                                ->toArray();


        // pr($events);die;                        
        $eManager = new EventManager();
        foreach ($events as $key => $value) {
            // $this->out($value->event_key);die;
            // if($value->event_key == "7_day_course_reminder_student"){
            //     // pr($value->event_key);die;
            //     $event = new Event($value->event_key, $this, [
            //         'hashData' => $value,
            //     ]);
            //     $eManager->dispatch($event);
            //     die('here there');  
            // }
            $event = new Event($value->event_key, $this, [
             'hashData' => $value,
            ]);
            $eManager->dispatch($event);
        }

    }
}
