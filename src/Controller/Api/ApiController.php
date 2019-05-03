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
namespace App\Controller\Api;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Log\Log;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class ApiController extends Controller
{

  const SUPER_ADMIN_LABEL = 'super_admin';
    const TENANT_LABEL = 'tenant';
    const USER_LABEL = 'user';
    const CLIENT_LABEL = 'corporate_client';
    const INSTRUCTOR_LABEL = 'instructor';
    const STUDENT_LABEL = 'student';
    //pr('qwertyu'); die;
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
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Cookie');
        $this->cors();

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
        // $this->loadComponent('Auth', [

        //     'unauthorizedRedirect' => false,
        //     'checkAuthIn' => 'Controller.initialize',

        //     // If you don't have a login action in your application set
        //     // 'loginAction' to false to prevent getting a MissingRouteException.
        //     'loginAction' => false
        // ]);
        /*
         * Enable the following components for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
    }


  public function cors(){
     
    $origin = $this->request->getHeader('Origin');
    if($this->request->getHeader('CONTENT_TYPE') != "application/x-www-form-urlencoded; charset=UTF-8"){
      $this->request->getEnv('CONTENT_TYPE', 'application/json');
    }

    $this->request->getEnv('HTTP_ACCEPT', 'application/json');
    if (!empty($origin)) {
      $this->response->withHeader('Access-Control-Allow-Origin', $origin);
    }

    if ($this->request->getMethod() == 'OPTIONS') {
      $method  = $this->request->getHeader('Access-Control-Request-Method');
      $headers = $this->request->getHeader('Access-Control-Request-Headers');
      $this->response->getHeader('Access-Control-Allow-Headers', $headers);
      $this->response->getHeader('Access-Control-Allow-Methods', empty($method) ? 'GET, POST, PUT, DELETE' : $method);
      $this->response->getHeader('Access-Control-Allow-Credentials', 'true');
      $this->response->getHeader('Access-Control-Max-Age', '120');
      $this->response->send();
      // die;
    }
    // die;
    $this->response->cors($this->request)
    ->allowOrigin(['*'])
    ->allowMethods(['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'])
    ->allowHeaders(['X-CSRF-Token','token'])
    ->allowCredentials()
    ->exposeHeaders(['Link'])
    ->maxAge(300)
    ->build();
  }

}