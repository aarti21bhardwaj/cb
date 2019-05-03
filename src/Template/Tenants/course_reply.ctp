<?php 
// pr($transferCourse); ?>
<center>

<div class="jumbotron text-xs-center">
  <h3 class="display-1">You have successfully <?= $reply ?> course# <?= $transferCourse->course_id ?></h3>
  <h2>Course Name: <?= $course->course_type->name ?></h2>
  <hr>
  <p>
    Login to portal? 
    <?php  $variable = 'variable'; 
                                $viewUrl = $this->Url->build(["controller"=>"tenants","action" => "login"]);
                                ?>
                                <a href='<?= $viewUrl ?>' class="btn btn-w-m btn-primary" >Login
                            </a>
  </p>
  
</div>
</center>