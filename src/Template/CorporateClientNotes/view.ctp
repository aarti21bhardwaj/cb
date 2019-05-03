<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CorporateClientNote $corporateClientNote
 */
?>

        
    
<!-- <div class="corporateClientNotes view large-9 medium-8 columns content"> -->
<div class = 'row'>
    <div class = 'col-lg-12'>
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h3><?= h($corporateClientNote->id) ?></h3>
            </div> <!-- ibox-title end-->
            <div class="ibox-content">
                <table class="table">
                                                                                                    <tr>
                        <th scope="row"><?= __('Corporate Client') ?></th>
                        <td><?= $corporateClientNote->has('corporate_client') ? $this->Html->link($corporateClientNote->corporate_client->name, ['controller' => 'CorporateClients', 'action' => 'view', $corporateClientNote->corporate_client->id]) : '' ?></td>
                    </tr>
                                                                                                                                            <tr>
                        <th scope="row"><?= __('Id') ?></th>
                        <td><?= $this->Number->format($corporateClientNote->id) ?></td>
                    </tr>
                                                                                                    <tr>
                        <th scope="row"><?= __('Created') ?></th>
                        <td><?= h($corporateClientNote->created) ?></td>
                    </tr>
                                        <tr>
                        <th scope="row"><?= __('Modified') ?></th>
                        <td><?= h($corporateClientNote->modified) ?></td>
                    </tr>
                                                                            </table>
                                                <div class="row">
                    <div class="col-sm-2">
                        <h4><?= __('Description') ?></h4>
                    </div>
                    <div class="col-sm-10">
                        <?= $this->Text->autoParagraph(h($corporateClientNote->description)); ?>
                    </div>
                   
                </div>
                                            </div> <!-- ibox-content end -->
        </div> <!-- ibox end-->
    </div><!-- col-lg-12 end-->
</div> <!-- row end-->
<!-- </div>
 -->