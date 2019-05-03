<?php
/**
* @var \App\View\AppView $this
* @var \App\Model\Entity\Pivotal $pivotal
*/
?>



<!-- <div class="pivotals view large-9 medium-8 columns content"> -->
    <div class = 'row'>
        <div class = 'col-lg-12'>
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3><?= h($pivotal->id) ?></h3>
                </div> <!-- ibox-title end-->
                <div class="ibox-content">
                    <table class="table">
                        <tr>
                            <th scope="row"><?= __('Key Category') ?></th>
                            <td><?= $pivotal->has('key_category') ? $this->Html->link($pivotal->key_category->name, ['controller' => 'KeyCategories', 'action' => 'view', $pivotal->key_category->id]) : '' ?></td>
                        </tr>
                        <tr>
                        <th scope="row"><?= __('Info') ?></th>
                            <td><?= $pivotal->info ?></td>
                        </tr>
                    </table>
                </div> <!-- ibox-content end -->
            </div> <!-- ibox end-->
        </div><!-- col-lg-12 end-->
    </div> <!-- row end-->
<!-- </div>
 -->