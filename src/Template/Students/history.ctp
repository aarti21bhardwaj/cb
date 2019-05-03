<?php

$salonTemplate = [
        'button' => '<button class="btn btn-primary m-b " {{attrs}}>{{text}}</button>'
];

$this->Form->setTemplates($salonTemplate);


$loginFormTemplate = [
        'radioWrapper' => '<div class="col-sm-offset-2"'
];
$this->Form->setTemplates($loginFormTemplate);
// pr($payments);die;
?>

<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-content">
          <div class="addons form large-9 medium-8 columns content">
              <?= $this->Form->create('', ['id' => 'processform']) ?>
                  <fieldset>
                  	<div class = 'ibox-title'>
                                        <legend><?= __('Course History') ?></legend>
                    </div>
                    <div align="center">
                    <div clas="ibox-content">
                    <table class ="table table-striped" width="80%" border="0" align="center">
                    	<thead>
                    		<th class="text-center" scope="col">Course Status</th>
                    		<th class="text-center" scope="col">Course ID</th>
                    		<th class="text-center" scope="col">Course Type</th>
                    		<th class="text-center" scope="col">Course Date</th>
                    		<th class="text-center" scope="col">Cost</th>
                    		<!-- <th scope="col">Status</th> -->
                    		<th scope="col">Registration Date/Time</th>
                    	</thead>
                        <?php if(empty($courseStudent)){ ?>
                        <tbody>
                            <tr>
                                <td class="text-center" colspan="6">No data exists!</td>
                            </tr>
                        </tbody>
                        <?php } else { ?>
                    	<tbody>
                    		<td class="text-center"><?= $courseStudent->course->status? $courseStudent->course->status:"No information available!" ?></td>
                    		<td class="text-center">
                                <?php if($courseStudent->course){  ?>
                    			<?= '<a href='.$this->Url->build(['controller'=>'Courses','action' => 'view', $courseStudent->course->id]).' class="btn btn-xs btn-success"">' ?>
                                        <?= $this->Number->format($courseStudent->course->id) ?>
                                <?php } ?>
                            </a></td>
                    		<td class="text-center"><?= $courseStudent->course->course_type? $courseStudent->course->course_type->name : "No information available!" ?></td>
                    		<td class="text-center" >
                                <?php if(isset($courseStudent->course)){  ?>
                                <?= $courseStudent->course['course_dates'][0]?$courseStudent->course['course_dates'][0]->course_date->format('m-d-y'): "-" ?>
                                <?php } ?>
                                </td>
                    		<td class="text-center" ><?= $courseStudent->course? $courseStudent->course->cost : "No information available!" ?></td>
                    		<!-- <td></td> -->
                    		<td class="text-center" ><?= $courseStudent->registration_date ?></td>
                    	</tbody>
                            <?php } ?> 
                            <?php foreach($studentData as $data):?>
                            <td class="text-center"><?= $data->course->status ?></td>
                            <td class="text-center">
                            <?= '<a href='.$this->Url->build(['controller'=>'Courses','action' => 'view', $data->course->id]).' class="btn btn-xs btn-success"">' ?>
                                        <?= $this->Number->format($data->course->id) ?>
                                     </a>                                       
                             </td>
                            <td class="text-center"><?= $data->course->course_type? $data->course->course_type->name: "No Course Type information available!"?></td>
                            <?php if(isset($data->course['course_dates'])){?>
                            <td class="text-center"><ul>
                                <li><?php foreach($data->course['course_dates'] as $date){?>
                                <?php echo $date->course_date?$date->course_date->format('Y-m-d').',': "-" ?> 
                                <?php echo $date->time_from?$date->time_from->format('H:i').' -': "-" ?> 
                                <?php echo $date->time_to?$date->time_to->format('H:i'):"-" ?>
                                <!-- <?php '\n\r' ?> -->
                            </li></ul>
                        <?php } ?>
                            </td>
                        <?php } else { ?>
                            <td><?= "No data exists!"?></td>
                        <?php } ?>    
                            <td class="text-center"><?= $data->course->cost?></td>
                            <td class="text-center"><?= $data->registration_date ?></td>
                    	</tbody>
                    <?php endforeach;?>
                    </table>
                    </div>
                    </div>	
                    <div class = 'ibox-title'>
                                        <legend><?= __('Transfer Course History') ?></legend>
                    </div>
                    <div align="center">
                    <div clas="ibox-content">
                    <table class ="table table-striped" width="80%" border="0" align="center">
                    <thead>
                    	<th class="text-center" scope="col">Course Id's</th>	
                        <th class="text-center" scope="col">From Course Type</th>
                        <th class="text-center" scope="col">To Course Type</th>
                        <th class="text-center" scope="col">Transfer date</th>
                        <th class="text-center" scope="col">Refund Amount</th>
                        <th class="text-center" scope="col">Additional Paid Amount</th> 
                    </thead>

                    <tbody>
                        <?php if(isset($studentTransferHistory) && !empty($studentTransferHistory)) {?>
                         <?php foreach ($studentTransferHistory as $student): ?>
                            <tr>
                                <td class="text-center">
                                	<?= '<a href='.$this->Url->build(['controller'=>'Courses','action' => 'view', $student->previous_course_id]).' class="btn btn-xs btn-success"">' ?>
                                        <?= $this->Number->format($student->previous_course_id) ?>
                                     </a>                              
                                		<i class=" fa fa-1.5x fa-arrow-right"></i>
                                	<?= '<a href='.$this->Url->build(['controller'=>'Courses','action' => 'view', $student->current_course_id]).' class="btn btn-xs btn-success"">' ?>
                                        <?= $this->Number->format($student->current_course_id) ?>
                                     </a>                                    	
                                </td>
                                <td class="text-center" >
                                	<?= $student->previous_course->course_type->name ?>
                                </td>
                                <td class="text-center" ><?= $student->current_course->course_type->name ?></td>
                                <td class="text-center" ><?= $student->transfer_date ?></td>
 								<td class="text-center" ><?php echo "$";?>
 								<?= $student->refund_amount?></td>
 								<td class="text-center"><?php echo "$";?>
 								<?= $student->additional_amount?></td>	
                        </tr>

                    <?php endforeach;?>
                <?php }else{ ?>
                    <tr>
                        <td class="text-center" colspan="6">No data exists!</td>
                    </tr>
                <?php } ?>
                    </tbody>
                    </table>
                    </div>
                    </div>
                        <div class = 'ibox-title'>
                            <legend><?= __('Payment History') ?></legend>
                        </div>
                <div align="center">
                    <div clas="ibox-content">
                    <table class ="table table-striped" width="80%" border="0" align="center">
                        <thead>
                            <tr>
                                <th class="text-center" scope="col">Payment Method</th>
                                <th class="text-center" scope="col">Amount</th>
                                <th class="text-center" scope="col">Payment Type</th>
                                <th class="text-center" scope="col">Transaction ID</th>
                                <th class="text-center" scope="col">Notes</th>
                            </tr>
                        </thead>
                        <tbody >
                            <?php if(isset($payments) && !empty($payments)) { ?>
                            <?php foreach($payments as $paymentData):?>
                            <tr>
                                <td class="text-center"><?= $paymentData->transaction->payment_method ?></td>
                                <td class="text-center"><?= "$".$paymentData->transaction->amount ?></td>
                                <td class="text-center"><?= $paymentData->transaction->type ?></td>
                                <td class="text-center"><?= $paymentData->transaction->charge_id ?></td>
                                <td class="text-center"><?= $paymentData->transaction->remark ?></td>
                            </tr>
                        <?php endforeach;?>
                        <?php }else { ?>
                            <tr>
                                <td class="text-center" colspan="6"><?= "No data exists!"?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
                 </fieldset>
          </div>
      </div>
    </div>
  </div>
</div>
