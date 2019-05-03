<div class = 'row'>
    <div class = 'col-lg-12'>
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <table class="table">
                    <tr>
                        <th scope="row"><?= __('Tenant') ?></th>
                        <td><?=$location->tenant->center_name?></td>
                    </tr>
                    <!-- <?php  if(!$loggedInUser['training_site_id'] && !isset($loggedInUser['training_site_id'])){ ?> -->
                    <?php if($loggedInUser['role']->id !== 5) { ?>
                    <tr>
                        <th scope="row"><?= __('Training Site') ?></th>
                        <td><?=$location->training_site? $location->training_site->name : "";?></td>
                    </tr>
                    <?php } ?>
                    <!-- <?php }?> -->
                    <tr>
                        <th scope="row"><?= __('Corporate Client') ?></th>
                        <td><?=$location->corporate_client? $location->corporate_client->name : "";?></td>
                    </tr>
                     <tr>
                        <th scope="row"><?= __('Site Contact Name') ?></th>
                        <td><?= h($location->contact_name) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Site Contact Email') ?></th>
                        <td><?= h($location->contact_email) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Site Contact Phone') ?></th>
                        <td><?= h($location->contact_phone) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Address') ?></th>
                        <td><?= $location->address ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('City') ?></th>
                        <td><?= h($location->city) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('State') ?></th>
                        <td><?= h($location->state) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Zipcode') ?></th>
                        <td><?= h($location->zipcode) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Location Name') ?></th>
                        <td><?= h($location->name) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Location Notes') ?></th>
                        <td><?= $location->notes ?></td>
                    </tr>
                    
                    <tr>
                        <th scope="row"><?= __('Latitude') ?></th>
                        <td><?= $this->Number->format($location->lat) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Longitude') ?></th>
                        <td><?= $this->Number->format($location->lng) ?></td>
                    </tr>
                </table>
            </div> <!-- ibox-content end -->
        </div> <!-- ibox end-->
    </div><!-- col-lg-12 end-->
</div> <!-- row end-->
 
