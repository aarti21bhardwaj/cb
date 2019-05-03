<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

/**
 * EventAdds shell command.
 */
class EventAddsShell extends Shell
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
        $this->eventAdd();
    }
    public function eventAdd(){
        $this->Events = TableRegistry::get('Events');
        $events = Configure::read('events');
        // pr($events);die;
        foreach ($events as $key => $value) {
            if($this->Events->find()->where(['name' => $value['name']])->first()){
               continue;    
            }
            unset($value['emails'][0]);
            $event[] = $value;
        }
        if(isset($event) && !empty($event)){
            $entities = $this->Events->newEntities($event);
            $result =  $this->Events->saveMany($entities);
            // pr($result);die;
            if($result){
                $this->out('Data is saved');
            }
            // die('here54');
            
        }
    }
}
