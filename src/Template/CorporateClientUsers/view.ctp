<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CorporateClientUser $corporateClientUser
 */
?>




<!-- <div class="corporateClientUsers view large-9 medium-8 columns content"> -->
<div class = 'row'>
    <div class = 'col-lg-12'>
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h3><?= h($corporateClientUser->first_name) ?></h3>
            </div> <!-- ibox-title end-->
            <div class="ibox-content">
                <table class="table">
                </tr>
                    <th scope="row"><?= __('Id') ?></th>
                    <td><?= $this->Number->format($corporateClientUser->id) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Corporate Client') ?></th>
                        <td><?= $corporateClientUser->corporate_client->name?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('First Name') ?></th>
                        <td><?= h($corporateClientUser->first_name) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Last Name') ?></th>
                        <td><?= h($corporateClientUser->last_name) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Email') ?></th>
                        <td><?= h($corporateClientUser->email) ?></td>
                    </tr>
                    
                    <tr>
                        <th scope="row"><?= __('Phone') ?></th>
                        <td><?= h($corporateClientUser->phone) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Role') ?></th>
                        <td><?= $corporateClientUser->role->name ?></td>
                    

                    <tr>
                        <th scope="row"><?= __('Status') ?></th>
                        <td><?= $corporateClientUser->status ? __('Active') : __('Inactive'); ?></td>
                    </tr>
            </table>
        </div> <!-- ibox-content end -->
    </div> <!-- ibox end-->
</div><!-- col-lg-12 end-->
</div> <!-- row end-->
<!-- </div>
 -->