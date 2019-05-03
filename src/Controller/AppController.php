<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Core\Configure;
use Cake\Http\Session;
use Cake\Routing\Router;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    const SUPER_ADMIN_LABEL = 'super_admin';
    const TENANT_LABEL = 'tenant';
    const USER_LABEL = 'user';
    const CLIENT_LABEL = 'corporate_client';
    const INSTRUCTOR_LABEL = 'instructor';
    const STUDENT_LABEL = 'student';

    public $components = array('RequestHandler');
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
	ini_set('memory_limit', '512M');
        set_time_limit(0);
        parent::initialize();
        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
            'viewClassMap' => ['xlsx' => 'Cewi/Excel.Excel']
        ]);
        // $this->loadComponent('RequestHandler', [
        //           'viewClassMap' => ['xlsx' => 'Cewi/Excel.Excel']
        // ]);
        $this->loadComponent('Flash');
        $this->loadComponent('Cookie');
        
        $currentController = $this->request->getParam('controller');
        // pr($currentController); die();
        if($currentController == 'Tenants'){
          $currentController = 'TenantUsers';
        }
        if($currentController == 'CorporateClients'){
          $currentController = 'CorporateClientUsers';
          // pr($currentController);die();
        }
        // $currentController = $this->request->params['controller'];
        $loginAction = $this->Cookie->read('loginAction');
        if(!$loginAction){
          $loginAction = ['controller' => $currentController,'action' => 'login'];
        }
        // pr($loginAction);die;
        $this->loadComponent('Auth',[
            'loginAction' => ['controller' => $currentController,'action' => 'login'],
            'authenticate' => [
                                'Form' =>
                                  [
                                    'userModel' => $currentController,
                                    'fields' => ['username' => 'email', 'password' => 'password']
                                  ]
                              ],
            'authorize'=> ['Controller'],
                            'loginAction' => $loginAction,
                            'loginRedirect' => $loginAction,
                            'logoutRedirect' => $loginAction 

          ]);

        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
    }

    public function beforeFilter(Event $event)
    {
      $title = 'ClassByte ';
      $this->viewBuilder()->setTheme('InspiniaTheme');
      $this->viewBuilder()->setLayout('default-override');
      $this->set('title',$title);

      $user = $this->Auth->user();
      // pr($user);die('sss');
      if(!empty($user) && isset($user['role'])){ 
        if(isset($user['is_site_owner']) && $user['is_site_owner'] == 1 && $user['role_id'] == 2){
          // pr($user);die;
          $user['role']['label'] = 'TRAINING SITE OWNER';
        }
        // $sideNavData = ['id'=>$user['id'],'first_name' => $user['first_name'],'last_name' => $user['last_name'],'role_name' => $user['role']['name']];
        $sideNavData = ['id'=>$user['id'],'first_name' => $user['first_name'],'last_name' => $user['last_name'],'role_name' => $user['role']['label']];
        $this->set('sideNavData', $sideNavData);

      }
      $this->loadModel('Tenants');
      $loggedInUser = $this->Auth->user();
      
      $url = Router::url('/', true);
          if($url == "http://localhost/classbyte/"){
            $domainType = 'cmc.classbyte.twinspark.co/tenants/login';
            // $domainType = 'http://dallas.classbyte.twinspark.co/tenants/login';
          }else{
            $domainType = "http://$_SERVER[HTTP_HOST]";
          }
      // $domainType = 'cmc.classbyte.twinspark.co/tenants/login';
      $tenant = $this->Tenants->find()
                              ->where(['domain_type LIKE' => '%'.$domainType.'%'])
                              ->contain(['TenantThemes','TenantConfigSettings','TenantSettings'])
                              ->first();
      // pr($tenant); die();
        //if conditions                      
      // if($tenant->tenant_config_settings['0']['course_description']){}
      // if($tenant->tenant_config_settings['0']['location_notes']){}
      // if($tenant->tenant_config_settings['0']['class_details']){}
      // if($tenant->tenant_config_settings['0']['remaining_seats']){}
      // if($tenant->tenant_config_settings['0']['promocode']){}
      $tenantTheme = '';
      $color = '';
      if(isset($tenant['tenant_themes'][0]) && !empty($tenant['tenant_themes'])){
     	$tenantTheme =  $tenant['tenant_themes']['0'];
      	$color =  $tenant['tenant_themes']['0']['color'];
      }    
  // pr($tenantTheme);die('here');
        $this->set(compact('tenant','loggedInUser','tenantTheme','color'));
      $popupLayout = $this->request->getQuery('layoutType');
      if($popupLayout && $popupLayout == "popUp"){
            $this->viewBuilder()->setLayout('popup-view');
      }
    
}
    public function beforeRender(Event $event){
        if($this->response->getStatusCode() == 200) {
            $user = $this->Auth->user();
            if(isset($user['is_site_owner']) && $user['is_site_owner']== 1 && $user['role_id'] == 2){
              $nav = $this->checkLink(Configure::read('Training Site Owner Menu'), $user['role']['name']);
            }else{
              $nav = $this->checkLink(Configure::read('Menu'), $user['role']['name']);
            }
            $this->set('sideNav',$nav['children']);
        }

        // Note: These defaults are just to get started quickly with development
        // // and should not be used in production. You should instead set "_serialize"
        // // in each action as required.
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->getType(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
        $this->set(compact('title'));

    }
    
    public function checkLink($nav = [], $role = false){
        $currentLink = [
        'controller' => $this->request->getParam('controller'),
        'action' => $this->request->getParam('action')
        ];


        $check = 0;
        foreach($nav as $key => &$value){
        //Figure out active class77
          if($value['link'] == '#' ){
            if(isset($value['children']) && $value['children']){
              $response = $this->checkLink($value['children'], $role);
              $value['children'] = $response['children'];
            }
            $value['active'] = $response['active'];
          } else{
            if(!is_array($value['link'])){
              $value['active'] = '';

            }else{
              $value['active'] = empty(array_diff($currentLink, $value['link'])) ? 1 : 0;
            }
          }

          if(isset($value['active']) && $value['active']){
            $check = 1;
          }
        //Figure out whether to show or not
          if($role){
            $show = 0;
        //role is not in show_to_roles
            if(empty($value['show_to_roles'])) {
              $show = 1;
            } elseif (in_array($role, $value['show_to_roles'])) {
              $show = 1;
            }
            if($show){
              if(empty($value['hide_from_roles'])) {
                $show = 1;
              } elseif (in_array($role, $value['hide_from_roles'])) {
                $show = 0;
              }  
            }
            $value['show'] = $show;
          } else {
            $value['show'] = 1;
          }
        }
        return ['children' => $nav, 'active' => $check];
    }


}
