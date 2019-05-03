<?php
/**
* @var \App\View\AppView $this
* @var \App\Model\Entity\KeyCategory $keyCategory
*/
?>



<?php

$salonTemplate = [
        'button' => '<button class="btn btn-primary m-b col-sm-offset-5" {{attrs}}>{{text}}</button>'
];

$this->Form->setTemplates($salonTemplate);

?>
<!-- <div class="keyCategories view large-9 medium-8 columns content"> -->
    <div class = 'row'>
        <div class = 'col-lg-12'>
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <table class="table">
                        <tr>
                            <th scope="row"><?= __('Category Name') ?></th>
                            <td><?= h($keyCategory->name) ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?= __('Description') ?></th>
                            <td><?= $keyCategory->description ?></td>
                        </tr>
                    </table>
                </div> <!-- ibox-content end -->
            </div> <!-- ibox end-->
        </div><!-- col-lg-12 end-->
    </div> <!-- row end-->
