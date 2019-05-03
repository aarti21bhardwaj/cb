
<!-- <div class="corporateClients view large-9 medium-8 columns content"> -->
<div class = 'row'>
    <div class = 'col-lg-12'>
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <h2 style="font-weight: 500">Corporate Client Information</h2>
                <table class="table">
                    <tr>
                        <th scope="row"><?= __('Training Site') ?></th>
                        <td><?=$corporateClient->training_site->name?></td>
                    </tr>
                    
                    <tr>
                        <th scope="row"><?= __('Name') ?></th>
                        <td><?= h($corporateClient->name) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Address') ?></th>
                        <td><?= $corporateClient->address ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('City') ?></th>
                        <td><?= h($corporateClient->city) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('State') ?></th>
                        <td><?= h($corporateClient->state) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Zipcode') ?></th>
                        <td><?= h($corporateClient->zipcode) ?></td>
                    </tr>
                    

                    <tr>
                        <th scope="row"><?= __('Web Page') ?></th>
                        <td><?= $corporateClient->web_page ? __('Yes') : __('No'); ?></td>
                    </tr>
                    <?php if($corporateClient->web_page == 1){?>
                    <tr>
                        <th scope="row"><?= __('Web ID') ?></th>
                        <td><?= $this->Html->link($corporateClient->web_url) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Corporate Client Detail') ?></th>
                        <td><?= $corporateClient->corporate_details ?></td>
                    </tr>
                    <?php }?>

                    <tr>
                        <th scope="row"><?= __('Status') ?></th>
                        <td><?= $corporateClient->status ? __('Active') : __('Not Active'); ?></td>
                    </tr>

                </table>


            </div> <!-- ibox-content end -->
        </div> <!-- ibox end-->
    </div><!-- col-lg-12 end-->
</div> <!-- row end-->

