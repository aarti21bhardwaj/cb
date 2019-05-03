<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CorporateClientDocument[]|\Cake\Collection\CollectionInterface $corporateClientDocuments
 */

use Cake\Core\Configure;
$sitePath = Configure::read('fileUpload');
// $sitePath = Configure::read('siteUrl');
?>

<div class="row">
    <div class="col-lg-12">
        <!--<div class="corporateClientDocuments index large-9 medium-8 columns content">-->

        <div class="ibox float-e-margins">
            <div class = 'ibox-title'>
                <h3><?= __('Corporate Client Documents') ?></h3>
                <div class="text-right">
                    <?=$this->Html->link('Add Corporate Client Documents', ['controller' => 'corporateClientDocuments', 'action' => 'add', $id, '?'=>['layoutType'=>'popUp']], ['class' => ['btn', 'btn-success']])?>
                </div>
            </div>
            <div class = "ibox-content">
                <table class = 'table' cellpadding="0" cellspacing="0">
                    <thead>
                        <?php
                        if(!$corporateClientDocuments): ?>
                        <h5 class="text-center">No document exists</h5>
                    <?php else: ?>
                        <tr>
                            <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                            <th scope="col"><?= $this->Paginator->sort('Uploaded file') ?></th>
                            <th scope="col" class="actions"><?= __('Actions') ?></th>
                        </tr>
                    <?php endif; ?>
                </thead>
                <tbody>
                    <?php foreach ($corporateClientDocuments as $key=>$corporateClientDocument): ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td><a href="<?= h($corporateClientDocument->image_url) ?>" class="btn btn-xs btn-success" target="_blank">View Upload</a></td>
                            <td class="actions">

                                <?= '<a href='.$this->Url->build(['action' => 'edit', '?'=> ['layoutType'=>'popUp'], $corporateClientDocument->id, $corporate_client_id]).' class="btn btn-xs btn-warning"">' ?>
                                <i class="fa fa-pencil fa-fw"></i>
                            </a>
                            <?= $this->Form->postLink(__(''), ['action' => 'delete', '?'=> ['layoutType'=>'popUp'], $corporateClientDocument->id, $corporate_client_id], ['confirm' => __('Are you sure you want to delete # {0}?', $corporateClientDocument->id), 'class' => ['btn', 'btn-sm', 'btn-danger', 'fa', 'fa-trash-o', 'fa-fh']]) ?>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- </div> -->
</div><!-- .ibox  end -->
</div><!-- .col-lg-12 end -->
</div><!-- .row end -->
