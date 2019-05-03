<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Controller\Controller;
use Cake\Collection\Collection;
use Cake\Http\Session;

/**
 * Orders Model
 *
 * @property \App\Model\Table\PromoCodesTable|\Cake\ORM\Association\BelongsTo $PromoCodes
 * @property \App\Model\Table\TenantsTable|\Cake\ORM\Association\BelongsTo $Tenants
 * @property \App\Model\Table\StudentsTable|\Cake\ORM\Association\BelongsTo $Students
 * @property |\Cake\ORM\Association\HasMany $BillingDetails
 * @property \App\Model\Table\LineItemsTable|\Cake\ORM\Association\HasMany $LineItems
 * @property \App\Model\Table\PaymentsTable|\Cake\ORM\Association\HasMany $Payments
 *
 * @method \App\Model\Entity\Order get($primaryKey, $options = [])
 * @method \App\Model\Entity\Order newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Order[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Order|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Order|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Order patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Order[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Order findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class OrdersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('orders');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('PromoCodes', [
            'foreignKey' => 'promo_code_id'
        ]);
        $this->belongsTo('Tenants', [
            'foreignKey' => 'tenant_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Students', [
            'foreignKey' => 'student_id'
        ]);
        $this->hasMany('BillingDetails', [
            'foreignKey' => 'order_id'
        ]);
        $this->hasMany('LineItems', [
            'foreignKey' => 'order_id'
        ]);
        $this->hasMany('Payments', [
            'foreignKey' => 'order_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('total_amount')
            ->maxLength('total_amount', 255)
            ->requirePresence('total_amount', 'create')
            ->notEmpty('total_amount');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['promo_code_id'], 'PromoCodes'));
        $rules->add($rules->existsIn(['tenant_id'], 'Tenants'));
        $rules->add($rules->existsIn(['student_id'], 'Students'));

        return $rules;
    }

   public function afterSave($event,$entity, $options){
          // pr($options['paymentStatus']);die;
        // pr('in Orders AfterSave function');
        // pr($entity);
        // pr('options');
        // pr($options);
        // die;
        // $options['billingDetails']['first_name']
          if($entity->offsetExists('bulk') && $entity->offsetGet('bulk') == 1){

            $tenantId = $entity->tenant_id;
            $tenantConfigSettings = TableRegistry::get('TenantConfigSettings');
            $configSettings = $tenantConfigSettings->find()
                                                   ->where(['tenant_id' => $tenantId])
                                                   ->first();
            if($configSettings->stripe_live_private_key || $configSettings->stripe_test_private_key){
              $data['status'] = false;
            }

            if($configSettings->payment_mode == 'stripe'){

              $stripeComponent = new Controller();
              $stripe = $stripeComponent->loadComponent('Stripe');
              if($configSettings->sandbox == 1){
                $coursePayment = $stripe->chargeCards($options['amountPaid'],$options['paymentCredentials'],$configSettings->stripe_test_private_key);
              } 
              if($configSettings->sandbox == 0){
                $coursePayment = $stripe->chargeCards($options['amountPaid'],$options['paymentCredentials'],$configSettings->stripe_live_private_key);
              }
              $studentIds = (new Collection($entity['line_items']))->extract('student_id')->toArray();
              $uniqueStudentIds = array_unique($studentIds);
          }           
                      $perStudentCost =  $options['amountPaid'] / count($uniqueStudentIds); 
                      $transactionData = [
                                        'charge_id' => $coursePayment['data']['id'],
                                        'payment_method' => $configSettings->payment_mode,
                                        'amount' => $options['amountPaid'],
                                        'remark' => 'Registration for a New Course',
                                        'status' => 1,
                                        'available_amount' => $options['amountPaid'],
                                        'type' => 'charge'
                                         ];
               $transactionData['payments'] = [];                           
               foreach($uniqueStudentIds as $key=>$value){
                $transactionData['payments'][] = [
                                                  'student_id' => $value,
                                                  'tenant_id' => $tenantId,
                                                  'order_id' => $entity->id, 
                                                  'amount' => $perStudentCost,
                                                  'payment_status' => 'Paid',
                                                 ];
              } 
              // pr('transaction');pr($transactionData);die;
              //---------------------------SAVE BILLING DETAILS---------------------------------
              $saveBillingDetails = $options['billingDetails'];
              $saveBillingDetails['order_id'] = $entity->id;
              // pr('saveBillingDetails');
              // pr($saveBillingDetails);die;
                                
          $this->BillingDetails = TableRegistry::get('BillingDetails');
          $billingDetail = $this->BillingDetails->newEntity();
          $billingDetail = $this->BillingDetails->patchEntity($billingDetail, $saveBillingDetails);
          if($this->BillingDetails->save($billingDetail)){;
          $session = new Session();
          $session->write('billing_information', $billingDetail);
          }  
          // $this->request->getSession()->write('billing_information',$billingDetail);
          //-------------------------------------------------------------------------------------
          $this->Transactions = TableRegistry::get('Transactions');
          $transaction = $this->Transactions->newEntity();
          $transaction = $this->Transactions->patchEntity($transaction, $transactionData, ['associated' => 'Payments']);
              if ($this->Transactions->save($transaction)) {
                // return true;
                // pr('gone from aftersave function of orders');
                 return $data = ['student_ids' => $uniqueStudentIds];
              } else {
              $data['status'] = false;                                 
              }           
          } 
        else { //BULK PAYMENT SAVE ENDS HERE AND NORMAL SAVE STARTS HERE
          $tenantId = $options['loggedInUser']['tenant_id'];
          $tenantConfigSettings = TableRegistry::get('TenantConfigSettings');
          $configSettings = $tenantConfigSettings->find()
                                                     ->where(['tenant_id' => $tenantId])
                                                     ->first();
          if($configSettings->stripe_live_private_key || $configSettings->stripe_test_private_key){
            $data['status'] = false;
          }                                           
          
          if($configSettings->payment_mode == "stripe"){

              $stripeComponent = new Controller();
              $stripe = $stripeComponent->loadComponent('Stripe');

                  if($options->offsetExists('type') && $options->offsetGet('type') == 'transfer'){

                            $stripeToken = $options['paymentCredentials']['stripeToken'];
                            if($configSettings->sandbox == 1){
                              $coursePayment = $stripe->chargeCards($options['finalAmount'],$options['paymentCredentials']['stripeToken'],$configSettings->stripe_test_private_key);
                            }
                            if($configSettings->sandbox == 0){
                              $coursePayment = $stripe->chargeCards($options['finalAmount'],$options['paymentCredentials']['stripeToken'],$configSettings->stripe_live_private_key);
                            }

                  } else {
                          if(isset($options['paymentCredentials']['stripeToken']) && $options['paymentCredentials']['stripeToken']){

                            $stripeToken = $options['paymentCredentials']['stripeToken'];
                          } else {
                            $stripeToken = $options['paymentCredentials'];
                          }

                         if($configSettings->sandbox == 1){
                          $coursePayment = $stripe->chargeCards($options['amountPaid'],$stripeToken,$configSettings->stripe_test_private_key);
                        }
                        if($configSettings->sandbox == 0){
                          $coursePayment = $stripe->chargeCards($options['amountPaid'],$stripeToken,$configSettings->stripe_live_private_key);
                        }
              }//   offsetExists('type')'s ELSE ENDS HERE
          }//   ($configSettings->payment_mode == "stripe")'s IF ENDS HERE

            if($options->offsetExists('type') && $options->offsetGet('type') == 'transfer'){
              $amount = $options['finalAmount'];
              $remark = 'Registration for a new course';
              $studentId = $entity->student_id;
            } else {
              $amount = $options['amountPaid'];
              $remark = 'Payment for Course and/or Addons';
              $studentId = $options['student']['id']; 
            }// (offsetExists('type'))'s ELSE ENDS HERE
            // pr($options);die;
            if($options->offsetExists('type') && $options->offsetGet('type') == 'transfer'){
              // die('In if');
              $paymentData = [
                                'student_id' => $studentId,
                                'tenant_id' => $tenantId,
                                'payment_status' => isset($options['paymentStatus'])?$options['paymentStatus']: 'Paid',
                                'order_id' => $entity->id,
                                'amount' => $amount,
                                'transaction' => [
                                                      // 'charge_id' => 'ch_1DtryhF26LXDyeKyBYJLjX5P',
                                                      'charge_id' => $coursePayment['data']['id'],
                                                      'payment_method' => $configSettings->payment_mode,
                                                      'amount' => $amount,
                                                      'remark' => $remark, 
                                                      'status'=> 1,
                                                      'available_amount' =>$options['finalAmount'],
                                                      'type'=> 'charge'
                                                    ]
                            ]; 

            } else {
              // die('in Else');
              $paymentData = [
                                'student_id' => isset($options['student']->id)?$options['student']->id:$options['loggedInUser']['id'],
                                  'tenant_id' => $tenantId,
                                  'payment_status' => isset($options['paymentStatus'])?$options['paymentStatus']: 'Paid',
                                  'order_id' => $entity->id,
                                  'amount' => $options['amountPaid'],
                                  'transaction' => [
                                                        // 'charge_id' => 'ch_1DiJr1F26LXDyeKyftrOF5Ko',
                                                        'charge_id' => $coursePayment['data']['id'],
                                                        'payment_method' => $configSettings->payment_mode,
                                                        'amount' => $options['amountPaid'],
                                                        'remark' => 'Registration for New Course',
                                                        'status'=> 1,
                                                        'type'=> 'charge'
                                                      ]
                              ]; 
                              // pr('payment Data');pr($paymentData);die;
            }// paymentData's ELSE ENDS HERE

              $this->Payments = TableRegistry::get('Payments');
              $payment = $this->Payments->newEntity();
              $payment = $this->Payments->patchEntity($payment, $paymentData, ['associated' => 'Transactions']);
                if ($this->Payments->save($payment)) {
                  return true; 
                } else {
                return false;
                }          
        } // NORMAL SAVE CONDITION ENDS HERE
     }// END OF AFTERSAVE FUNCTION
}

