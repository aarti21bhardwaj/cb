<?php 
use Cake\Core\Configure;
use Cake\Routing\Router;

?>


<style>
body {background-color: #fff;}
.own_ser td{ padding:5px;}
.own_ser td h1{ margin-bottom:0px;}
.own_ser td{ font-size:12px;}
.print_btn{ width:100%; text-align:right; height:40px; margin-top:20px;}
.print_btn a{  padding:10px; background-color:#FF6347; color:white;  border-radius:8px; border-bottom:none; }
</style>

<div class="print_btn"><a href="javascript:window.print()">PRINT</a></div>


<div style="float:left; width:100%;">
	<table class="own_ser" width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" style="font-family:Arial, Helvetica, sans-serif; width:100%;">
  <tbody><tr>
    <td colspan="3" style="border-top: medium none; border-left: thin none;"><h1>CLASS	ROSTER</h1></td>
    <td colspan="2">Date:
      <?php if(isset($course['course_dates']) && !empty($course['course_dates'])){ 
                                    foreach ($course['course_dates'] as $value) { 
                                     echo "<b>".$value->course_date."</b>"."</br>"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp";
                                     }}?>
    </td>
    <td colspan="2">Course No.:
    <b><?= $this->Number->format($course->id) ?></b> </td>
  </tr>
  <tr>
    <td width="19%">Start Time: 
      <?php if(isset($course['course_dates']) && !empty($course['course_dates'])){
      
                                        foreach ($course['course_dates'] as $value) { 
                                          if($value->time_from && isset($value->time_from)){
                                            echo "<br><b>".$value->time_from->format('H:i A') ."</b>";
                                          }else{
                                            echo "<br><b>". 'Null'."</b>";
                                          }
                                            
                                        }}?>
    </td>
    <td width="21%">End Time: 
      <?php if(isset($course['course_dates']) && !empty($course['course_dates'])){ 
                                        foreach ($course['course_dates'] as $value) { 
  
                                            if($value->time_to && isset($value->time_to)){
                                            echo "<br><b>".$value->time_to->format('H:i A') ."</b>";
                                            }else{
                                              echo "<br><b>". 'Null'."</b>";
                                            }
                                            
                                        }}?>

    </td>
    <td width="22%">Total Hrs.: 
      <?php if(isset($course['course_dates']) && !empty($course['course_dates'])){ 
                                        foreach ($course['course_dates'] as $value) {
                                            $a= new DateTime($value->time_from);
                                            $b= new DateTime($value->time_to);
                                            $interval=$a->diff($b);                                   
                                            echo "<br><b>".$interval->format("%H:%I")." hours</b>";
                                            
                                        }}?>
    </td>
    <td colspan="2">Class Type:

      <b><?php echo $course->course_type->name; ?></b>

    </td>
    <td colspan="2">Client:
    <b><?= $course->corporate_client?$course->corporate_client->name:"-"; ?></b>
    </td>
  </tr>
  <tr>
    <td height="52" colspan="7" valign="bottom" style="border-left:none; border-right:none;"><strong><span style="text-decoration:underline;">Disclaimer:</span>	 Please write your name as it should appear on your card. $8.00 WILL BE BILLED FOR CARD REPLACEMENTS. Complete all applicable ﬁelds.</strong></td>
  </tr>
  <tr>
    <td colspan="3">Name</td>
    <td width="12%">Address</td>
    <td width="8%">C/C</td>
    <td width="9%">Test</td>
    <td width="9%">Remarks</td>
  </tr>
       <?php foreach ($course->course_students as $getStudent): ?>

  
    		  <tr>
            <td rowspan="2"> <b> <?php echo $getStudent->student->first_name." ".$getStudent->student->last_name ; ?> </b></td>
            <td>Employee	ID: <b> <?php echo $getStudent->student->id ; ?> </b> </td>
            <td>Email: : <b> <?php echo $getStudent->student->email ; ?> </b> </td>
            <td rowspan="2">&nbsp; <b> <?php echo $getStudent->student->address ; ?> </b></td>
            <td rowspan="2">&nbsp;</td>
            <td rowspan="2">&nbsp;</td>
            <td rowspan="2">&nbsp;</td>
          </tr>
  		    <tr>
            <td>Location #: <b> <?php echo $getStudent->student->city.", ".$getStudent->student->state ; ?> </b></td>
            <td>Phone:<b> <?php echo $getStudent->student->phone1 ; ?> </b> </td>
          </tr>
  		 <?php endforeach; ?> 
    
  <tr>
    <td colspan="7"><strong>C/IC	-	C=Completed	/	IC=	Incomplete			-		Test	SC=Test	Score			-		Rem=Remediated	Yes	/No </strong><br>
    Instructor	Comments:	(AAach	incident	report	if	needed)</td>
  </tr>
  <tr>
    <td colspan="2">Instructor	Name:  
      <b><?php foreach ($course->course_instructors as $getInstructor): 
        echo $getInstructor->instructor->first_name." ".$getInstructor->instructor->last_name."<br>"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp" ; 
       endforeach; ?></b>
    </td>
    <td>Signature:</td>
    <td colspan="1">Instructor	ID:
      <b><?php foreach ($course->course_instructors as $getInstructor): 
        echo $getInstructor->instructor->id."<br>"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp"."&nbsp" ; 
       endforeach; ?></b>
    </td>
    <td colspan="3">Date	Class	Completed: </td>
  </tr>
  <tr>
    <td colspan="7">
    
    <div>
    I	certify that	the	following	information	is	correct	and	can	be	verified.	This	course	was	offered based	on	the	American	Heart	Association	Rules	and	Policies.	Use	of	these	materials	in	an	educational 	course	does	not	represent	course	sponsorship <strong>by	the American	Heart	Association,	and	any	fees	charged	for	such	a	course	do	not	represent	income	to	the	American	Heart	Association.	INSTRUCTOR	PLEASE	MAKE	SURE	NAMES	ARE	LEGIBLE	BEFORE	YOU	LEAVE.</strong>
    </div>
    
    </td>
  </tr>
</tbody></table>
</div>
