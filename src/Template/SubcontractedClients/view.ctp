<!-- <div class="subcontractedClients view large-9 medium-8 columns content"> -->
<div class = 'row'>
    <div class = 'col-lg-12'>
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h3><?= h($subcontractedClient->name) ?></h3>
            </div> <!-- ibox-title end-->
            <div class="ibox-content">
                <table class="table">
                    <tr>
                        <th scope="row"><?= __('Training Site') ?></th>
                        <td><?= $subcontractedClient->training_site? $subcontractedClient->training_site->name : ""; ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Corporate Client') ?></th>
                        <td><?= $subcontractedClient->corporate_client->name ?></td>
                    </tr>
                    <tr>
                            <th scope="row"><?= __('Address') ?></th>
                            <td><?= $subcontractedClient->address  ?></td>
                        </tr>
                    <tr>
                        <th scope="row"><?= __('City') ?></th>
                        <td><?= h($subcontractedClient->city) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('State') ?></th>
                        <td><?= h($subcontractedClient->state) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Zipcode') ?></th>
                        <td><?= h($subcontractedClient->zipcode) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Contact Name') ?></th>
                        <td><?= h($subcontractedClient->contact_name) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Contact Phone') ?></th>
                        <td><?= h($subcontractedClient->contact_phone) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Contact Email') ?></th>
                        <td><?= h($subcontractedClient->contact_email) ?></td>
                    </tr>

                        <tr>
                            <th scope="row"><?= __('Web Page') ?></th>
                            <td><?= $subcontractedClient->web_page ? __('Yes') : __('No'); ?></td>
                        </tr>
                        <!-- <?php if($subcontractedClient->web_page == 1){?>
                    <tr>
                        <th scope="row"><?= __('Web ID') ?></th>
                        <td><?= h($subcontractedClient->web_url) ?></td>
                    </tr>
                    <?php }?> -->
                    
                    <tr>
                        <th scope="row"><?= __('Subcontrated Client Detail') ?></th>
                        <td><?= $subcontractedClient->subcontractedclient_detail ?></td>
                    </tr>
                        <tr>
                            <th scope="row"><?= __('Status') ?></th>
                            <td><?= $subcontractedClient->status ? __('Active') : __('Inactive'); ?></td>
                        </tr>
                        
                    </table>

                    </div>
                </div> <!-- ibox-content end -->
            </div> <!-- ibox end-->
        </div><!-- col-lg-12 end-->
    </div> <!-- row end-->
   