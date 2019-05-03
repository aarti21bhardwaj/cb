<?php
namespace App\Controller\Api;

use App\Controller\Api\ApiController;
use Cake\Http\Exception\MethodNotAllowedException;
use Cake\Http\Exception\BadRequestException;
use Cake\Http\Exception\UnauthorizedException;
use Cake\Http\Exception\ConflictException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Exception\InternalErrorException;
use Cake\Collection\Collection;

/**
 * ReferralLeads Controller
 *
 * @property \App\Model\Table\ReferralLeadsTable $ReferralLeads
 */
class  EventsController extends ApiController
{

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
    }
    
    /**
     * View method
     *
     * @return \Cake\Network\Response|void Redirects on successful show the response from AJAX, renders view for the template data.
    */
    public function view($id = null)
    {
        $event = $this->Events->get($id, [
            'contain' => ['EventVariables']
        ]);
        $this->set('event', $event);
        $this->set('_serialize', ['event']);
    }
    public function corporateClient(){
        $tenantId = $this->Auth->User('tenant_id');
        $this->loadModel('CorporateClients');

        $data = $this->CorporateClients->find()
                                       ->where(['tenant_id' => $tenantId])
                                       ->contain(['SubcontractedClients'])
                                       ->toArray();
        
        $corporateType = (new Collection($data))->combine('id','name')->toArray();
        $subcontractedClients = (new Collection($data))->extract('subcontracted_clients.{*}')->combine('id','name')->toArray();
        
        $this->set(compact('corporateType','subcontractedClients'));
        $this->set('_serialize',['corporateType','subcontractedClients']);                          
    }
    
}