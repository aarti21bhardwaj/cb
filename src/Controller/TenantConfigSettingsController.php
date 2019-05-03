<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * TenantConfigSettings Controller
 *
 * @property \App\Model\Table\TenantConfigSettingsTable $TenantConfigSettings
 *
 * @method \App\Model\Entity\TenantConfigSetting[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TenantConfigSettingsController extends AppController
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
        if (in_array($action, ['add','registrationSettings']) && $user['role']->name === self::TENANT_LABEL) {
        // pr($action); die('in tenant admin');
            return true;
        }
       
        }

   
    public function add($id = null)
    {
        $loggedInUser = $this->Auth->user();
        $tenantId=$loggedInUser['tenant_id'];

        $x = $this->TenantConfigSettings->findByTenantId($tenantId)->first();

        $id=$x['id'];
        if(empty($id)){
            $tenantConfigSetting = $this->TenantConfigSettings->newEntity();
        if ($this->request->is('post')) {
            $this->_RequestData['tenant_id'] = $loggedInUser['tenant_id'];
            $tenantConfigSetting = $this->TenantConfigSettings->patchEntity($tenantConfigSetting, $this->_RequestData);
            if ($this->TenantConfigSettings->save($tenantConfigSetting)) {
                $this->Flash->success(__('The tenant config setting has been saved.'));

                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('The tenant config setting could not be saved. Please, try again.'));
        }
        $tenants = $this->TenantConfigSettings->Tenants->find('list', ['limit' => 200]);
        $this->set(compact('tenantConfigSetting', 'tenants'));

        }else{ 
        $tenantConfigSetting = $this->TenantConfigSettings->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            // pr($this->_RequestData);die;
            $tenantConfigSetting = $this->TenantConfigSettings->patchEntity($tenantConfigSetting, $this->_RequestData);
            if ($this->TenantConfigSettings->save($tenantConfigSetting)) {
                $this->Flash->success(__('Tenant Config Settings have been saved.'));

                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('Registration settings could not be saved. Please, try again.'));
        }
        $tenants = $this->TenantConfigSettings->Tenants->find('list', ['limit' => 200]);
        $this->set(compact('tenantConfigSetting', 'tenants'));
        }
    }

    public function registrationSettings($id = null){
        $loggedInUser = $this->Auth->user();
        $tenantId=$loggedInUser['tenant_id'];

        $x = $this->TenantConfigSettings->findByTenantId($tenantId)->first();

        $id=$x['id'];
        if(empty($id)){
            $tenantConfigSetting = $this->TenantConfigSettings->newEntity();
        if ($this->request->is('post')) {
            $this->_RequestData['tenant_id'] = $loggedInUser['tenant_id'];
            $tenantConfigSetting = $this->TenantConfigSettings->patchEntity($tenantConfigSetting, $this->_RequestData);
            if ($this->TenantConfigSettings->save($tenantConfigSetting)) {
                $this->Flash->success(__('The tenant config setting has been saved.'));

                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('The tenant config setting could not be saved. Please, try again.'));
        }
        $tenants = $this->TenantConfigSettings->Tenants->find('list', ['limit' => 200]);
        $this->set(compact('tenantConfigSetting', 'tenants'));

        }else{ 
        $tenantConfigSetting = $this->TenantConfigSettings->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tenantConfigSetting = $this->TenantConfigSettings->patchEntity($tenantConfigSetting, $this->_RequestData);
            if ($this->TenantConfigSettings->save($tenantConfigSetting)) {
                $this->Flash->success(__('The tenant config setting has been saved.'));

                return $this->redirect(['action' => 'registrationSettings']);
            }
            $this->Flash->error(__('The tenant config setting could not be saved. Please, try again.'));
        }
        $tenants = $this->TenantConfigSettings->Tenants->find('list', ['limit' => 200]);
        $this->set(compact('tenantConfigSetting', 'tenants'));
        }
    }
   

    
}
