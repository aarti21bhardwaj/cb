<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
use Cake\Routing\Router;    

/**
 * TenantThemes Controller
 *
 * @property \App\Model\Table\TenantThemesTable $TenantThemes
 *
 * @method \App\Model\Entity\TenantTheme[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TenantThemesController extends AppController
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
        else if (in_array($action, ['index', 'view','add','edit','delete']) && $user['role']->name === self::TENANT_LABEL) {
        // pr($action); die('in tenant admin');
            return true;
        }
       
        }

    

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($id = null)
    {
        $loggedInUser = $this->Auth->user();
        $tenantId=$loggedInUser['tenant_id'];

        $x = $this->TenantThemes->findByTenantId($tenantId)->first();
        $id=$x['id'];
        if(empty($id)){
        $tenantTheme = $this->TenantThemes->newEntity();
            
        if ($this->request->is('post')) {
            $this->_RequestData['tenant_id'] = $loggedInUser['tenant_id'];

            $tenantTheme = $this->TenantThemes->patchEntity($tenantTheme, $this->_RequestData);
            if ($this->TenantThemes->save($tenantTheme)) {
                $this->Flash->success(__('The tenant theme has been saved.'));

                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('The tenant theme could not be saved. Please, try again.'));
        }
        $this->set(compact('tenantTheme', 'tenants'));
        }else{
        $tenantTheme = $this->TenantThemes->get($id, [
            'contain' => []
        ]);
        // pr($tenantTheme);die;
        $oldImageName = $tenantTheme->logo_name;
        $path = Configure::read('ImageUpload.unlinkPathForThemeLogo');

        if ($this->request->is(['patch', 'post', 'put'])) {
            // pr($this->_RequestData);die;
            $tenantTheme = $this->TenantThemes->patchEntity($tenantTheme, $this->_RequestData);
            if ($this->TenantThemes->save($tenantTheme)) {
                if(empty($this->_RequestData['logo_name']['tmp_name'])){
                    unset($this->_RequestData['logo_name']);
                    $oldImageName ='';
                }
                if(!empty($oldImageName)){
                    $filePath = $path . '/'.$oldImageName;
                    if($filePath != '' && file_exists( $filePath ) ){
                        unlink($filePath);
                    }
                }
                $this->Flash->success(__('The tenant theme has been saved.'));

                return $this->redirect(['action' => 'add']);
            }
            $this->Flash->error(__('The tenant theme could not be saved. Please, try again.'));
        }
        $this->set(compact('tenantTheme', 'tenants'));   
        }
    }

    
}
