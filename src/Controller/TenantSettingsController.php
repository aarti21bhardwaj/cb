<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * TenantSettings Controller
 *
 * @property \App\Model\Table\TenantSettingsTable $TenantSettings
 *
 * @method \App\Model\Entity\TenantSetting[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TenantSettingsController extends AppController
{
    public function initialize()
    { 
        $this->_RequestData = $this->request->getData();
        parent::initialize();
    }
    public function isAuthorized($user)
    {
        // pr($user['role']->name); die('ss');
        $action = $this->request->getParam('action');
        // pr($action); die();

        // The add and index actions are always allowed.
        if (in_array($action, ['index', 'view','add','edit','delete']) && $user['role']->name === self::SUPER_ADMIN_LABEL) {
        // pr($action); die('in super admin');
            return true;
        }
        // All other actions require an id.
        /*if (empty($this->request->getParam('pass.0'))) {
            return $this->redirect(['controller' => 'tenants','action' => 'index']);
        }*/
        return parent::isAuthorized($user);
    }

    
    public function add($id = null)
    {
        
        $tenantSetting = $this->TenantSettings->findByTenantId($id)->first();
        if(!$tenantSetting){
            $tenantSetting = $this->TenantSettings->newEntity();
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $this->_RequestData['tenant_id'] = $id;
            $tenantSetting = $this->TenantSettings->patchEntity($tenantSetting, $this->_RequestData);
            if ($this->TenantSettings->save($tenantSetting)) {
                $this->Flash->success(__('The tenant setting has been saved.'));

                return $this->redirect(['controller' => 'Tenants','action' => 'index']);
            }
            $this->Flash->error(__('The tenant setting could not be saved. Please, try again.'));
        }
        $tenants = $this->TenantSettings->Tenants->findById($id)->first();
        $this->set(compact('tenantSetting', 'tenants'));
    }

    
}
