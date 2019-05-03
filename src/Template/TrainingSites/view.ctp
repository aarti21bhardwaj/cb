<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TrainingSite $trainingSite
 */
use Cake\I18n\Time;

use Cake\Core\Configure;
$sitePath = Configure::read('fileUpload');

// $sitePath = Configure::read('siteUrl');
?>

<!-- <div class="trainingSites view large-9 medium-8 columns content"> -->
<div class = 'row'>
    <div class = 'col-lg-12'>
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h3><?= h($trainingSite->name) ?></h3>
            </div> <!-- ibox-title end-->
            <div class="ibox-content">
                <table class="table">
                    <tr>
                        <th scope="row"><?= __('Tenant') ?></th>
                        <td><?= $trainingSite->tenant->center_name ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Training Site Code') ?></th>
                        <td><?= h($trainingSite->training_site_code) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Name') ?></th>
                        <td><?= h($trainingSite->name) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Phone') ?></th>
                        <td><?= h($trainingSite->phone) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Address') ?></th>
                        <td><?= $trainingSite->address ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('City') ?></th>
                        <td><?= h($trainingSite->city) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('State') ?></th>
                        <td><?= h($trainingSite->state) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Zipcode') ?></th>
                        <td><?= h($trainingSite->zipcode) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Site Contract Document') ?></th>
                    <?php if(!empty($trainingSite->site_contract_path)){ ?>
                        <td><a href="<?= $sitePath.h($trainingSite->site_contract_path) ?>/<?= h($trainingSite->site_contract_name) ?>" class="btn btn-xs btn-success" target="_blank">Download file</a>
                        </td>
                    <?php }else{ ?>
                    <td> No File Uploaded </td>
                    <?php } ?>
                    </tr>

                    <tr>
                        <th scope="row"><?= __('Site Monitoring Form') ?></th>
                    <?php if(!empty($trainingSite->site_monitoring_path)){ ?>
                        <td><a href="<?= $sitePath.h($trainingSite->site_monitoring_path) ?>/<?= h($trainingSite->site_monitoring_name) ?>" class="btn btn-xs btn-success" target="_blank">Download file</a>
                        </td> 
                     <?php }else{ ?>
                    <td> No File Uploaded </td>
                    <?php } ?>

                    </tr>
                    <tr>
                    
                        <th scope="row"><?= __('Site Monitoring Date') ?></th>
                        <td><?= $trainingSite->site_monitoring_date?$trainingSite->site_monitoring_date->format('m/d/Y'):""; ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Site Insurance Document') ?></th>
                    <?php if(!empty($trainingSite->site_insurance_path)){ ?>
                        <td><a href="<?= $sitePath.h($trainingSite->site_insurance_path) ?>/<?= h($trainingSite->site_insurance_name) ?>" class="btn btn-xs btn-success" target="_blank">Download file</a>
                        </td>
                     <?php }else{ ?>
                    <td> No File Uploaded </td>
                    <?php } ?>
                    </tr>
                    
                    <tr>
                        <th scope="row"><?= __('Site Insurance Expiry Date') ?></th>
                        <td><?= $trainingSite->site_insurance_expiry_date?$trainingSite->site_insurance_expiry_date->format('m/d/Y'):""; ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Contact Name') ?></th>
                        <td><?= h($trainingSite->contact_name) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Contact Email') ?></th>
                        <td><?= h($trainingSite->contact_email) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Contact Phone') ?></th>
                        <td><?= h($trainingSite->contact_phone) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Status') ?></th>
                        <td><?= $trainingSite->status ? __('Active') : __('Inactive'); ?></td>
                    </tr>
                </table>
                
            </div> <!-- ibox-content end -->
        </div> <!-- ibox end-->
    </div><!-- col-lg-12 end-->
</div> <!-- row end-->

