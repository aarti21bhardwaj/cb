<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TrainingSiteNote $trainingSiteNote
 */
?>

        
    
<!-- <div class="trainingSiteNotes view large-9 medium-8 columns content"> -->
<div class = 'row'>
    <div class = 'col-lg-12'>
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h3><?= h($trainingSiteNote->id) ?></h3>
            </div> <!-- ibox-title end-->
            <div class="ibox-content">
                <table class="table">
                                                                                                    <tr>
                        <th scope="row"><?= __('Training Site') ?></th>
                        <td><?= $trainingSiteNote->has('training_site') ? $this->Html->link($trainingSiteNote->training_site->name, ['controller' => 'TrainingSites', 'action' => 'view', $trainingSiteNote->training_site->id]) : '' ?></td>
                    </tr>
                                                                                                                                            <tr>
                        <th scope="row"><?= __('Id') ?></th>
                        <td><?= $this->Number->format($trainingSiteNote->id) ?></td>
                    </tr>
                                                                                                    <tr>
                        <th scope="row"><?= __('Created') ?></th>
                        <td><?= h($trainingSiteNote->created) ?></td>
                    </tr>
                                        <tr>
                        <th scope="row"><?= __('Modified') ?></th>
                        <td><?= h($trainingSiteNote->modified) ?></td>
                    </tr>
                                                                            </table>
                                                <div class="row">
                    <div class="col-sm-2">
                        <h4><?= __('Description') ?></h4>
                    </div>
                    <div class="col-sm-10">
                        <?= $this->Text->autoParagraph(h($trainingSiteNote->description)); ?>
                    </div>
                   
                </div>
                                            </div> <!-- ibox-content end -->
        </div> <!-- ibox end-->
    </div><!-- col-lg-12 end-->
</div> <!-- row end-->
<!-- </div>
 -->