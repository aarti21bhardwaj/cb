<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\KeyInventory $keyInventory
 */
?>

        
    
<!-- <div class="keyInventories view large-9 medium-8 columns content"> -->
<div class = 'row'>
    <div class = 'col-lg-12'>
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h3><?= h($keyInventory->name) ?></h3>
            </div> <!-- ibox-title end-->
            <div class="ibox-content">
                <table class="table">
                                                                                                    <tr>
                        <th scope="row"><?= __('Key Category') ?></th>
                        <td><?= $keyInventory->has('key_category') ? $this->Html->link($keyInventory->key_category->name, ['controller' => 'KeyCategories', 'action' => 'view', $keyInventory->key_category->id]) : '' ?></td>
                    </tr>
                                                                                                                                            <tr>
                        <th scope="row"><?= __('Id') ?></th>
                        <td><?= $this->Number->format($keyInventory->id) ?></td>
                    </tr>
                                                                                                    <tr>
                        <th scope="row"><?= __('Created') ?></th>
                        <td><?= h($keyInventory->created) ?></td>
                    </tr>
                                        <tr>
                        <th scope="row"><?= __('Modified') ?></th>
                        <td><?= h($keyInventory->modified) ?></td>
                    </tr>
                                                                                                    <tr>
                        <th scope="row"><?= __('Status') ?></th>
                        <td><?= $keyInventory->status ? __('Yes') : __('No'); ?></td>
                    </tr>
                                                        </table>
                                                <div class="row">
                    <div class="col-sm-2">
                        <h4><?= __('Name') ?></h4>
                    </div>
                    <div class="col-sm-10">
                        <?= $this->Text->autoParagraph(h($keyInventory->name)); ?>
                    </div>
                   
                </div>
                                            </div> <!-- ibox-content end -->
        </div> <!-- ibox end-->
    </div><!-- col-lg-12 end-->
</div> <!-- row end-->
<!-- </div>
 -->