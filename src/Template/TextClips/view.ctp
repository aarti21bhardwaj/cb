<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TextClip $textClip
 */
?>

        
    
<!-- <div class="textClips view large-9 medium-8 columns content"> -->
<div class = 'row'>
    <div class = 'col-lg-12'>
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h3><?= h($textClip->name) ?></h3>
            </div> <!-- ibox-title end-->
            <div class="ibox-content">
                <table class="table">
                                                                                                    <tr>
                        <th scope="row"><?= __('Tenant') ?></th>
                        <td><?= $textClip->has('tenant') ? $this->Html->link($textClip->tenant->id, ['controller' => 'Tenants', 'action' => 'view', $textClip->tenant->id]) : '' ?></td>
                    </tr>
                                                                                <tr>
                        <th scope="row"><?= __('Name') ?></th>
                        <td><?= h($textClip->name) ?></td>
                    </tr>
                                                                                                                                            <tr>
                        <th scope="row"><?= __('Id') ?></th>
                        <td><?= $this->Number->format($textClip->id) ?></td>
                    </tr>
                                                                                                    <tr>
                        <th scope="row"><?= __('Created') ?></th>
                        <td><?= h($textClip->created) ?></td>
                    </tr>
                                        <tr>
                        <th scope="row"><?= __('Modified') ?></th>
                        <td><?= h($textClip->modified) ?></td>
                    </tr>
                                                                                                    <tr>
                        <th scope="row"><?= __('Status') ?></th>
                        <td><?= $textClip->status ? __('Yes') : __('No'); ?></td>
                    </tr>
                    </tr>
                                        <tr>
                        <th scope="row"><?= __('Description') ?></th>
                        <td><?= $textClip->description ?></td>
                    </tr>

                                                        </table>
                                                <div class="row">
                   
                </div>
                                            </div> <!-- ibox-content end -->
        </div> <!-- ibox end-->
    </div><!-- col-lg-12 end-->
</div> <!-- row end-->
<!-- </div>
 -->