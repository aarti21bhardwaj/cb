<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Database\Schema\TableSchema;
/**
 * UpdateTenantSettings shell command.
 */
class UpdateTenantSettingsShell extends Shell
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
        $this->updateTenantSettings();
    }

    public function updateTenantSettings(){
        $this->loadModel('Tenants');
        $tenant = $this->Tenants->find()->contain(['TenantSettings'])->toArray();
        foreach($tenant as $key => $value){
                if(isset($value['tenant_settings']) && !empty($value['tenant_settings'])){
                    $this->out('Already Present ! '.$value->id);
                    continue;
                } else {
                    $this->loadModel('TenantSettings');
                    $columns = $this->TenantSettings->getSchema()->typeMap();
                    foreach($columns as $key => $checkType){
                        if($checkType == 'boolean'){
                            $data[$key] = 1;
                        } 
                    }
                    $data['tenant_id'] = $value->id;
                    $tenantSetting = $this->TenantSettings->newEntity();
                    $tenantSetting = $this->TenantSettings->patchEntity($tenantSetting,$data);
                    if(!$this->TenantSettings->save($tenantSetting)){      
                        $this->out('Setting not saved'.$value->id);                    
                    }
                }
        }
    }
}
