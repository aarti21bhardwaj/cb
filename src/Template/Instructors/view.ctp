<div class="text-center">
 <h3>Instructor Info<h3/>
 </div>    
<!-- <div class="instructors view large-9 medium-8 columns content"> -->
<div class = 'row'>
    <div class = 'col-lg-12'>
        <div class="ibox float-e-margins">
            <!-- <div class="ibox-title">
                <h3><?= h($instructor->id) ?></h3>
            </div> --> <!-- ibox-title end-->
            <div class="ibox-content">
                <table class="table">
                </tr>
                <tr>
                    <th scope="row"><?= __('Tenant') ?></th>
                    <td><?=$instructor->tenant->center_name?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Training Site') ?></th>
                    <td><?=$instructor->training_site->name?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('First Name') ?></th>
                    <td><?= h($instructor->first_name) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Last Name') ?></th>
                    <td><?= h($instructor->last_name) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Email') ?></th>
                    <td><?= h($instructor->email) ?></td>
                </tr>
                <!-- <tr>
                    <th scope="row"><?= __('Password') ?></th>
                    <td><?= h($instructor->password) ?></td>
                </tr> -->
               <!--  <tr>
                    <th scope="row"><?= __('Image Name') ?></th>
                    <td><?= h($instructor->image_name) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Image Path') ?></th>
                    <td><?= h($instructor->image_path) ?></td>
                </tr> -->
                <tr>
                    <th scope="row"><?= __('Phone 1') ?></th>
                    <td><?= h($instructor->phone_1) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Phone 2') ?></th>
                    <td><?= h($instructor->phone_2) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('City') ?></th>
                    <td><?= h($instructor->city) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('State') ?></th>
                    <td><?= h($instructor->state) ?></td>
                </tr>
                <tr>
                    <th scope="row"><?= __('Zipcode') ?></th>
                    <td><?= h($instructor->zipcode) ?></td>
                </tr>
                <tr>
                        <th scope="row"><?= __('Address') ?></th>
                        <td><?= $instructor->address ?></td>
                    </tr>
                <tr>
                    <th scope="row"><?= __('Status') ?></th>
                    <td><?= $instructor->status ? __('Active') : __('Inactive'); ?></td>
                </tr>
            </table> 
        </div> <!-- ibox-content end -->
    </div> <!-- ibox end-->
</div><!-- col-lg-12 end-->
</div> <!-- row end-->
<!-- </div>
-->
