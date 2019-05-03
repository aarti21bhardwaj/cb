<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;



/**
 * Events shell command.
 */
class EventsShell extends Shell
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
        $this->Tenants = TableRegistry::get('Tenants');
        $this->Events = TableRegistry::get('Events');        
        $this->out($this->OptionParser->help());
        // $this->out('test');
        $this->saveEvents();
    }
    public function saveEvents(){
        $events = Configure::read('events');
        // $event = [];
        // $check = $this->Events->find()->contain(['EventVariables','Emails'])->toArray();
        foreach ($events as $key => $value) {
            $email = $value['emails'][0];
          $emails = $this->emailWithTenant($email);
            // pr($value);die;
            if($this->Events->find()->where(['name' => $value['name']])->first()){
               continue;    
            }
            $value['emails'] = $emails;
            $event[] = $value;
        }
        if(isset($event) && !empty($event)){
            $entities = $this->Events->newEntities($event);
            $result =  $this->Events->saveMany($entities);
            if($result){
                $this->out('Data is saved');
            }
            // die('here54');
        }
    }
    public function emailWithTenant($email){
        $emails = [];
        $data = $this->Tenants->find()->extract('id')->toArray();
        // print_r($data);die;
        foreach ($data as $key => $value) {
            $email['tenant_id'] = $value;
            $emails[] = $email;
            // pr($emailems);
        }
        // die('here');
        return $emails;
    }
}
