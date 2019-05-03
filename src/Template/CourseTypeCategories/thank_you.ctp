
<div class="jumbotron text-xs-center">
  <h4 class="display-1">New Course Type Category Added</h4>
  <p class="lead"><smalll><strong>Close this window</strong> and click on the refresh icon to get this Course Type Category on the dropdown</small></p>
  <hr>
  <p>
   Add another? 
    <?php  $variable = 'variable'; 
                                $viewUrl = $this->Url->build(["controller"=>"CourseTypeCategories","action" => "add", $variable]);
                                ?>
                                <a href='<?= $viewUrl ?>' class="btn btn-w-m btn-primary" >Add New Course Type Category
                            </a>
  </p>
  
</div>