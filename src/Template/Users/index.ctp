<?php

$salonTemplate = [
        'button' => '<button class="btn btn-primary m-b" {{attrs}}>{{text}}</button>',
        'input' => '<input type="{{type}}" class="form-control" name="{{name}}"{{attrs}}/>',
        'inputContainer' => '<div class="form-group {{type}}{{required}}">{{content}}</div>',
        'label' => '<label class="col-sm-2 control-label" {{attrs}}>{{text}}</label>',
];

$this->Form->setTemplates($salonTemplate);

?>
<div class="row">
    <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class = 'ibox-title'>
                    <h3><?= __('Users') ?></h3>
                    <div class="col-sm-offset-10">
                        <?= $this->Html->link('Add Super Admin', ['controller' => 'Users' , 'action' => 'add'],['class' => ['btn', 'btn-success']]);?>
                    </div>
                </div>
                
                <div class = "ibox-content">
                    <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables" >
                        <thead>
                            <tr>
                                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('first_name') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('last_name') ?></th>
                                <th scope="col"><?= $this->Paginator->sort('email') ?></th>
                                <th scope="col" class="actions"><?= __('Actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= $this->Number->format($user->id) ?></td>
                                <td><?= h($user->first_name) ?></td>
                                <td><?= h($user->last_name) ?></td>
                                <td><?= h($user->email) ?></td>
                                <td class="actions">
                                    <?php 
                                        $viewUrl = $this->Url->build(["action" => "view", $user->id]);
                                    ?>
                                     <a href='#' onclick='openViewPopUp("<?= $viewUrl ?>", "View User")' class="btn btn-xs btn-success" data-toggle="modal" data-target="#myModal">
                                    <i class="fa fa-eye fa-fw"></i></a>

                                    <!-- <?= '<a href='.$this->Url->build(['action' => 'edit', $user->id]).' class="btn btn-xs btn-warning"">' ?>
                                    <i class="fa fa-pencil fa-fw"></i> -->
                                    </a>
                                </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            </div>
        </div><!-- .ibox  end -->
    </div><!-- .col-lg-12 end -->
</div><!-- .row end -->

