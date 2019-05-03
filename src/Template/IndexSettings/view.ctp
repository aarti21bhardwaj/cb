<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\IndexSetting $indexSetting
 */
?>
<!-- <div class="indexSettings view large-9 medium-8 columns content"> -->
    <div class = 'row'>
        <div class = 'col-lg-12'>
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3><?= h($indexSetting->for_name) ?></h3>
                </div> <!-- ibox-title end-->
                <!-- <div class="ibox-content"> -->
                    <table class="table">
                     <tr>
                        <th scope="row"><?= __('For Name') ?></th>
                        <td><?= h($indexSetting->for_name) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('For Id') ?></th>
                        <td><?= $this->Number->format($indexSetting->for_id) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Index Name') ?></th>
                        <td><?= h($indexSetting->index_name) ?></td>
                    </tr>
                    <!-- <tr>
                        <th scope="row"><?= __('Id') ?></th>
                        <td><?= $this->Number->format($indexSetting->id) ?></td>
                     --></tr>
                     <tr>
                         <th scope="row"><?= __('Meta') ?></th>
                         <td><?= h(json_encode($indexSetting->meta)); ?></td>
                     </tr>
                </table>
<!--                 <div class="row">
                    <div class="col-sm-2">
                        <h4><?= __('Meta') ?></h4>
                    </div>
                    <div class="col-sm-10">
                        <?= $this->Text->autoParagraph(h(json_encode($indexSetting->meta))); ?>
                    </div>

                </div> -->
                <!-- </div> ibox-content end -->
            </div> <!-- ibox end-->
        </div><!-- col-lg-12 end-->
    </div> <!-- row end-->
<!-- </div>
 -->