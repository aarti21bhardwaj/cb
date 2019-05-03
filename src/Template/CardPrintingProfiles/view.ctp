<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CardPrintingProfile $cardPrintingProfile
 */
?>

        
    
<!-- <div class="cardPrintingProfiles view large-9 medium-8 columns content"> -->
<div class = 'row'>
    <div class = 'col-lg-12'>
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h3><?= h($cardPrintingProfile->name) ?></h3>
            </div> <!-- ibox-title end-->
            <div class="ibox-content">
                <table class="table">
                                                                                <tr>
                        <th scope="row"><?= __('Name') ?></th>
                        <td><?= h($cardPrintingProfile->name) ?></td>
                    </tr>
                                                                                                                                            <tr>
<!--                         <th scope="row"><?= __('Id') ?></th>
                        <td><?= $this->Number->format($cardPrintingProfile->id) ?></td>
                    </tr> -->
                                        <tr>
                        <th scope="row"><?= __('Left Right Adjustment') ?></th>
                        <td><?= $this->Number->format($cardPrintingProfile->left_right_adjustment) ?></td>
                    </tr>
                                        <tr>
                        <th scope="row"><?= __('Up Down Adjustment') ?></th>
                        <td><?= $this->Number->format($cardPrintingProfile->up_down_adjustment) ?></td>
                    </tr>
                                                                                                    <tr>
                        <!-- <th scope="row"><?= __('Created') ?></th>
                        <td><?= h($cardPrintingProfile->created) ?></td>
                    </tr>
                                        <tr>
                        <th scope="row"><?= __('Modified') ?></th>
                        <td><?= h($cardPrintingProfile->modified) ?></td>
                    </tr> -->
                                                                                                    <tr>
                        <th scope="row"><?= __('Status') ?></th>
                        <td><?= $cardPrintingProfile->status ? __('Active') : __('Inactive'); ?></td>
                    </tr>
                                                        </table>
                            </div> <!-- ibox-content end -->
        </div> <!-- ibox end-->
    </div><!-- col-lg-12 end-->
</div> <!-- row end-->