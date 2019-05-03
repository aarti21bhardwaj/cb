<?php
/**
* @var \App\View\AppView $this
* @var \App\Model\Entity\Email[]|\Cake\Collection\CollectionInterface $emails
*/
?>







<div class="row">
    <div class="col-lg-12">
        <!--<div class="emails index large-9 medium-8 columns content">-->
            <div class="ibox float-e-margins">
                <div class = 'ibox-title'>
                    <h3><?= __('Emails') ?></h3>
                    <div class="text-right">
                        <?=$this->Html->link('Add Email Setting', ['controller' => 'Emails', 'action' => 'add'],['class' => ['btn', 'btn-success']])?>
                    </div>
                </div>
                <div class = "ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables" >
                            <thead>
                                <tr>
                                    <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                    <th scope="col"><?= $this->Paginator->sort('event_id') ?></th>
                                    <th scope="col"><?= $this->Paginator->sort('subject') ?></th>
                                    <th scope="col"><?= $this->Paginator->sort('from_name') ?></th>
                                    <th scope="col"><?= $this->Paginator->sort('from_email') ?></th>
                                    <th scope="col"><?= $this->Paginator->sort('status') ?></th>
                                    <th scope="col"><?= $this->Paginator->sort('use_system_email') ?></th>
                                    <th scope="col" class="actions"><?= __('Actions') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($emails as $email): ?>
                                <tr>
                                    <td><?= $this->Number->format($email->id) ?></td>
                                    <td><?= h($email->event->name) ?></td>
                                    <td><?= h($email->subject) ?></td>
                                    <td><?= h($email->from_name) ?></td>
                                    <td><?= h($email->from_email) ?></td>
                                    <td><?= $email->status? 'Yes':'No'; ?></td>
                                    <td><?= $email->use_system_email? "Yes":"No"; ?></td>
                                    <td class="actions">
                                        <?php 
                                        $viewUrl = $this->Url->build(["action" => "view", $email->id]);
                                        ?>
                                        <a href='#' onclick='openViewPopUp("<?= $viewUrl ?>", "View User")' class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal">
                                            <i class="fa fa-eye fa-fw"></i>
                                        </a>
                                        <?= '<a href='.$this->Url->build(['action' => 'edit', $email->id]).' class="btn btn-xs btn-warning"">' ?>
                                        <i class="fa fa-pencil fa-fw"></i>
                                    </a>
                                    <?= $this->Form->postLink(__(''), ['action' => 'delete', $email->id], ['confirm' => __('Are you sure you want to delete # {0}?', $email->id), 'class' => ['btn', 'btn-sm', 'btn-danger', 'fa', 'fa-trash-o', 'fa-fh']]) ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- <div class="paginator">
                    <ul class="pagination">
                        <?= $this->Paginator->first('<< ' . __('first')) ?>
                        <?= $this->Paginator->prev('< ' . __('previous')) ?>
                        <?= $this->Paginator->numbers() ?>
                        <?= $this->Paginator->next(__('next') . ' >') ?>
                        <?= $this->Paginator->last(__('last') . ' >>') ?>
                    </ul>
                    <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
                </div> -->
                <!-- </div> -->
            </div><!-- .ibox  end -->
        </div><!-- .col-lg-12 end -->
    </div><!-- .row end -->