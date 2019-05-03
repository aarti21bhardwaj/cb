<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TenantUser $tenantUser
 */
?>

        
        
    
<!-- <div class="tenantUsers view large-9 medium-8 columns content"> -->
<div class = 'row'>
    <div class = 'col-lg-12'>
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h3><?= ($tenantUser->first_name." ".$tenantUser->last_name) ?></h3>
            </div> <!-- ibox-title end-->
            <div class="ibox-content">
                <table class="table">
                                                                                                    <tr>

                          <th scope="row"><?= __('Tenant') ?></th>
                          <td><?= $tenantUser->has('tenant') ? $tenantUser->tenant->center_name : '' ?></td>                                                                          <tr>
                    </tr>
                                                                                <tr>
                        <th scope="row"><?= __('First Name') ?></th>
                        <td><?= h($tenantUser->first_name) ?></td>
                    </tr>
                                                                                <tr>
                        <th scope="row"><?= __('Last Name') ?></th>
                        <td><?= h($tenantUser->last_name) ?></td>
                    </tr>
                                                                                <tr>
                        <th scope="row"><?= __('Email') ?></th>
                        <td><?= h($tenantUser->email) ?></td>
                    </tr>
                                                                                <!-- <tr>
                        <th scope="row"><?= __('Password') ?></th>
                        <td><?= h($tenantUser->password) ?></td>
                    </tr> -->
                                                                                <tr>
                        <th scope="row"><?= __('Phone') ?></th>
                        <td><?= h($tenantUser->phone) ?></td>
                    </tr>
                                                                                                                                            <tr>
                        <th scope="row"><?= __('Tenant Id') ?></th>
                        <td><?= $this->Number->format($tenantUser->id) ?></td>
                    </tr>
 
                                                                                                    <tr>
                        <th scope="row"><?= __('Status') ?></th>
                        <td><?= $tenantUser->status ? __('Active') : __('Inactive'); ?></td>
                    </tr>
                                                        </table>
                            </div> <!-- ibox-content end -->
        </div> <!-- ibox end-->
    </div><!-- col-lg-12 end-->
</div> <!-- row end-->
<!-- </div>
 -->