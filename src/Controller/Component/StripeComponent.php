<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\Datasource\ConnectionManager;
use Stripe\Stripe;
use Cake\Http\Exception\BadRequestException;
use Cake\Http\Exception\MethodNotAllowedException;
use Cake\Core\Exception\Exception;
use Cake\Http\Exception\NotFoundException;
use Cake\Log\Log;

/**
 * Stripe component
 */
class StripeComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];


    public function chargeCards($serviceAmount,$stripeToken, $stripeKey){
     // pr($serviceAmount);pr($stripeToken);pr($stripeKey);die('here');
      if(!isset($serviceAmount) || !$serviceAmount){
        throw new MethodNotAllowedException(__("Amount for the service is missing"));
      }
      if(!isset($stripeToken) || !$stripeToken){
        throw new MethodNotAllowedException

        (__("Stripe token is missing"));
      }
      if(!isset($stripeKey) || !$stripeKey){
        throw new MethodNotAllowedException(__("Stripe key is missing."));
      }
      try {

        \Stripe\Stripe::setApiKey($stripeKey);

        $customer = \Stripe\Charge::create(array(
                                                  'amount' => $serviceAmount*100,
                                                  'currency' => 'usd',
                                                  'description' => 'Example charge',
                                                  'source' => $stripeToken,
                                                ));
        
        // die($customer);
        if($customer){
          $customerChargeDetails = $customer->jsonSerialize();
        }
         
      } catch (Exception $e) {

        // pr('here in exception');
        // pr($e);
        // die;
        throw new Exception("User card not charged. Error in Stripe."); 
      } 

      return [ 'status' => true,'data' => $customerChargeDetails];
        
    }
    public function refundAmount($refundAmount,$chargeId,$stripeKey){
      // pr('here');die;
      // pr($refundAmount);
      // pr($chargeId);
      // pr($stripeKey);
      // die;

      if(!isset($refundAmount) || !$refundAmount){
        throw new MethodNotAllowedException(__("Refund Amount is missing"));
      }
      if(!isset($chargeId) || !$chargeId){
        throw new MethodNotAllowedException(__("Charge Id is missing"));
      }
      if(!isset($stripeKey) || !$stripeKey){
        throw new MethodNotAllowedException(__("Stripe key is missing."));
      }
      try {

        \Stripe\Stripe::setApiKey($stripeKey);
        if(!empty($refundAmount)){  
          $refund = \Stripe\Refund::create([
                                              'charge' => $chargeId,
                                              'amount' => $refundAmount*100,
                                          ]);
        }else{
          $refund = \Stripe\Refund::create([
                                              'charge' => $chargeId,
                                          ]);
        }

        
        // die($refund);
        if($refund){
          $customerChargeDetails = $refund->jsonSerialize();
        }
         
      } catch (Exception $e) {

        // pr('here in exception');
        // pr($e);
        // die;
        throw new Exception("User card not charged. Error in Stripe."); 
      } 

      return [ 'status' => true,'data' => $customerChargeDetails];
    }
    public function refundTransactions($balance,$data,$configSettings,$orderId){
        // pr($balance);pr($data);pr($configSettings);pr($orderId);die;
        $this->Transactions = TableRegistry::get('Transactions');        
        $this->Payments = TableRegistry::get('Payments');
        $tenantId = $configSettings->tenant_id;
         $refundAmount = $data['refund_amount'];
        foreach ($balance as $key => $value) {
            if($refundAmount > $value['available_amount'] && $value['available_amount'] !=0 ){
                $refundAmount = $value['available_amount'] - $refundAmount;
                // pr('test');die;
                if($configSettings->payment_mode == "stripe"){
                        $charge_id = $value['charge_id'];
                        if($configSettings->sandbox == 1){
                            // pr('test');die;
                            $coursePayment = $this->refundAmount($value['available_amount'],$charge_id,$configSettings->stripe_test_private_key);
                        }
                        if($configSettings->sandbox == 0){
                            $coursePayment = $this->refundAmount($value['available_amount'],$charge_id,$configSettings->stripe_live_private_key);
                        }
                     // pr($coursePayment);pr($refundAmount);die; 
                        if($coursePayment){
                            // $this->Transactions->query()->update()->set(['available_amount' => 0])->where(['charge_id' => $value['charge_id']])->execute();
                            $this->Payments->getQuery()->update()->set(['amount' => 0])->where(['student_id' => $data['student_id'],'transaction_id'=>$value['transaction_id']])->execute();
                            $paymentData = [
                                'student_id' => $data['student_id'],
                                'tenant_id' => $tenantId,
                                'payment_status' => 'refund',
                                'order_id' => $orderId,
                                'amount' => -$value['available_amount'],
                                'transaction' => [
                                                      // 'charge_id' => 'ch_1DiJr1F26LXDyeKyftrOF5Ko',
                                                      'charge_id' => $coursePayment['data']['id'],
                                                      'payment_method' => $configSettings->payment_mode,
                                                      'amount' => -$value['available_amount'],
                                                      'available_amount' => 0,
                                                      'remark' => 'Refund for Course',
                                                      'status'=> 1,
                                                      'type'=> 'refund',
                                                      'parent_id' => $value['charge_id']
                                                    ]
                            ];
                            $payment = $this->Payments->newEntity();
                            $payment = $this->Payments->patchEntity($payment, $paymentData);
                            // pr($payment);die;
                            if (!$this->Payments->save($payment)) {
                                throw new BadRequestException(__('The status could not be updated.'));
                            }
                        }
                            $refundAmount = abs($refundAmount);
                  }
            }else{
              // die('here');
               if($configSettings->payment_mode == "stripe"){
                    $charge_id = $value['charge_id'];
                    if($configSettings->sandbox == 1){
                        $coursePayment = $this->refundAmount($refundAmount,$charge_id,$configSettings->stripe_test_private_key);
                    }
                    if($configSettings->sandbox == 0){
                     $coursePayment = $this->refundAmount($refundAmount,$charge_id,$configSettings->stripe_live_private_key);   
                    }
                    if($coursePayment){
                            // $this->Transactions->query()->update()->set(['available_amount' => $value['available_amount'] - $refundAmount])->where(['charge_id' => $value['charge_id']])->execute();
                             $this->Payments->getQuery()->update()->set(['amount' => $value['available_amount'] - $refundAmount])->where(['student_id' => $data['student_id'],'transaction_id'=>$value['transaction_id']])->execute();
                            $paymentData = [
                                'student_id' => $data['student_id'],
                                'tenant_id' => $tenantId,
                                'payment_status' => 'refund',
                                'order_id' => $orderId,
                                'amount' => -$refundAmount,
                                'transaction' => [
                                                      // 'charge_id' => 'ch_1DiJr1F26LXDyeKyftrOF5Ko',
                                                      'charge_id' => $coursePayment['data']['id'],
                                                      'payment_method' => $configSettings->payment_mode,
                                                      'amount' => -$refundAmount,
                                                      'available_amount' => $refundAmount,
                                                      'remark' => 'Refund for Course',
                                                      'status'=> 1,
                                                      'type'=> 'refund',
                                                      'parent_id' => $value['charge_id']
                                                    ]
                            ];
                            $payment = $this->Payments->newEntity();
                            $payment = $this->Payments->patchEntity($payment, $paymentData);
                            // pr($payment);die;
                            if (!$this->Payments->save($payment)) {
                                throw new BadRequestException(__('The status could not be updated.'));
                            }
                                return $payment;
                        }
              } 
            }    
        }
        // die('here');
    }
}
