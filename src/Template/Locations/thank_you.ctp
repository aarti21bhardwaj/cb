<div class="jumbotron text-xs-center">
  <h4 class="display-1">New Location Added</h4>
  <p class="lead"><smalll><strong>Close this window</strong> and click on the refresh icon to get this location on the dropdown</small></p>
  <hr>
  <p>
    Add another? 
    <?php  $variable = 'variable'; 
                                $viewUrl = $this->Url->build(["controller"=>"Locations","action" => "add", $variable]);
                                ?>
                                <a href='<?= $viewUrl ?>' class="btn btn-w-m btn-primary" >Add New Location
                            </a>
  </p>
  
</div>