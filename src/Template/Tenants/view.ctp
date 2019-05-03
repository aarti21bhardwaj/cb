<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tenant $tenant
 */
?>
<!-- <div class="tenants view large-9 medium-8 columns content"> -->
<div class = 'row'>
    <div class = 'col-lg-12'>
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <table class="table">
                    <tr>
                        <th scope="row"><?= __('Center Name') ?></th>
                        <td><?= h($tenant->center_name) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('City') ?></th>
                        <td><?= h($tenant->city) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('State') ?></th>
                        <td><?= h($tenant->state) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Zip') ?></th>
                        <td><?= h($tenant->zip) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Address') ?></th>
                        <td><?= $tenant->address ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Domain Type') ?></th>
                        <td><?= h($tenant->domain_type) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Status') ?></th>
                        <td><?= $tenant->status ? __('Yes') : __('No'); ?></td>
                    </tr>
                </table>
                
            </div> <!-- ibox-content end -->
        </div> <!-- ibox end-->
    </div><!-- col-lg-12 end-->
</div> <!-- row end-->