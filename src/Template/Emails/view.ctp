<?php

$salonTemplate = [
'button' => '<button class="btn btn-primary m-b col-sm-offset-5" {{attrs}}>{{text}}</button>'
];

$this->Form->setTemplates($salonTemplate);

?>
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Email $email
 */
?>
<!-- <div class="emails view large-9 medium-8 columns content"> -->
    <div class = 'row'>
        <div class = 'col-lg-12'>
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h3><?= $email->subject ?></h3>
                </div> <!-- ibox-title end-->
                <div class="ibox-content">
                    <table class="table">
                        <tr>
                            <th scope="row"><?= __('Tenant') ?></th>
                            <td><?= $email->tenant->center_name ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?= __('Event') ?></th>
                            <td><?= $email->event->name ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?= __('Subject') ?></th>
                            <td><?= h($email->subject) ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?= __('From Name') ?></th>
                            <td><?= h($email->from_name) ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?= __('From Email') ?></th>
                            <td><?= h($email->from_email) ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?= __('Status') ?></th>
                            <td><?= $email->status ? __('Active') : __('Inactive'); ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?= __('System Email') ?></th>
                            <td><?= $email->use_system_email ? __('Yes') : __('No'); ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?= __('Body') ?></th>
                            <td><?= $email->body; ?></td>
                        </tr>
                    </table>
                </div> <!-- ibox-content end -->
            </div> <!-- ibox end-->
        </div><!-- col-lg-12 end-->
    </div> <!-- row end-->
    