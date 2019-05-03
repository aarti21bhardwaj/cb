<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Student $student
 */
?>

<!-- <div class="students view large-9 medium-8 columns content"> -->
<div class = 'row'>
    <div class = 'col-lg-12'>
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h3><?php echo $student->first_name.' '.$student->last_name ; ?></h3>
            </div> <!-- ibox-title end-->
            <div class="ibox-content">
                <table class="table">
                <tr>
                        <th scope="row"><?= __('Student Id') ?></th>
                        <td><?= $this->Number->format($student->id) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Training Site') ?></th>
                    <?php if(isset($student->training_site) && !empty($student->training_site)){  ?> 
                        <td><?= $student->training_site->name ?></td>
                        <?php }else{ ?>
                        <td> -- </td>
                    <?php }?>
                    </tr>

                    
                    <tr>
                        <th scope="row"><?= __('Corporate Client') ?></th>
                        <?php if(isset($student->corporate_client) && !empty($student->corporate_client)){  ?>
                        <td><?= $student->corporate_client->name ?></td>
                        <?php }else{ ?>
                        <td>--</td>
                    <?php } ?>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Subcontracted Client') ?></th>
                        <td><?= ($student->subcontracted_client)? $student->subcontracted_client->name:"--" ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('First Name') ?></th>
                        <td><?= h($student->first_name) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Last Name') ?></th>
                        <td><?= h($student->last_name) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Email') ?></th>
                        <td><?= h($student->email) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Address') ?></th>
                        <td><?= $student->address ?></td>
                    </tr>
                    
                    <tr>
                        <th scope="row"><?= __('City') ?></th>
                        <td><?= h($student->city) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('State') ?></th>
                        <td><?= h($student->state) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Zipcode') ?></th>
                        <td><?= h($student->zipcode) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Phone1') ?></th>
                        <td><?= h($student->phone1) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Phone2') ?></th>
                        <td><?= h($student->phone2) ?></td>
                    </tr>
                    
                    
                    <tr>
                        <th scope="row"><?= __('Status') ?></th>
                        <td><?= $student->status ? __('Active') : __('Inactive'); ?></td>
                    </tr>
                </table>
                
            </div> <!-- ibox-content end -->
        </div> <!-- ibox end-->
    </div><!-- col-lg-12 end-->
</div> <!-- row end-->
<!-- </div>
 -->