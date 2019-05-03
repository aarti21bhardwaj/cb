<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CorporateClientDocument $corporateClientDocument
 */
?>

        
    
<!-- <div class="corporateClientDocuments view large-9 medium-8 columns content"> -->
<div class = 'row'>
    <div class = 'col-lg-12'>
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h3><?= h($corporateClientDocument->id) ?></h3>
            </div> <!-- ibox-title end-->
            <div class="ibox-content">
                <table class="table">
                                                                                                    <tr>
                        <th scope="row"><?= __('Corporate Client') ?></th>
                        <td><?= $corporateClientDocument->has('corporate_client') ? $this->Html->link($corporateClientDocument->corporate_client->name, ['controller' => 'CorporateClients', 'action' => 'view', $corporateClientDocument->corporate_client->id]) : '' ?></td>
                    </tr>
                                                                                <tr>
                        <th scope="row"><?= __('Document Name') ?></th>
                        <td><?= h($corporateClientDocument->document_name) ?></td>
                    </tr>
                                                                                <tr>
                        <th scope="row"><?= __('Document Path') ?></th>
                        <td><?= h($corporateClientDocument->document_path) ?></td>
                    </tr>
                                                                                                                                            <tr>
                        <th scope="row"><?= __('Id') ?></th>
                        <td><?= $this->Number->format($corporateClientDocument->id) ?></td>
                    </tr>
                                                                                                    <tr>
                        <th scope="row"><?= __('Created') ?></th>
                        <td><?= h($corporateClientDocument->created) ?></td>
                    </tr>
                                        <tr>
                        <th scope="row"><?= __('Modified') ?></th>
                        <td><?= h($corporateClientDocument->modified) ?></td>
                    </tr>
                                                                            </table>
                            </div> <!-- ibox-content end -->
        </div> <!-- ibox end-->
    </div><!-- col-lg-12 end-->
</div> <!-- row end-->
<!-- </div>
 -->