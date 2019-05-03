<div class = 'row'>
    <div class = 'col-lg-12'>
        <div class="ibox float-e-margins">
            <div class="ibox-title pull-left">
                 <h2>Promo Code Information</h2>
                <!-- <h2>Promo Code Information</h2> -->
            </div>
            <!-- <div class="ibox-content"> -->
                <table class="table">
                    <tr>
                        <th scope="row"><?= __('Tenant') ?></th>
                        <td><?=($promoCode->tenant->tenant_users[0]->first_name).' '.($promoCode->tenant->tenant_users[0]->last_name)?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Code') ?></th>
                        <td><?= h($promoCode->code) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Corporate Client') ?></th>
                        <td>
                            <?php if(empty($promoCode->corporate_client)): ?>
                                <?= h("None") ?>
                            <?php else: 
                            echo $promoCode->corporate_client->name."<br>";
                            endif;
                            ?>     
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Subcontracted Client Id') ?></th>
                        <td>
                            <?php if(empty($promoCode->subcontracted_client)): ?>
                                <?= h("None") ?>
                            <?php else: 
                            echo $promoCode->subcontracted_client->name."<br>";
                            endif;
                            ?>     
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Description') ?></th>
                        <td>
                            <?php if(empty($promoCode->description)): ?>
                                <?= h("None") ?>
                            <?php else: 
                            echo $promoCode->description;
                            endif;
                            ?>     
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Start Date') ?></th>
                        <td><?= h($promoCode->start_date) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('End Date') ?></th>
                        <td><?= h($promoCode->end_date) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Discount Type') ?></th>
                        <td><?= h($promoCode->discount_type ? 'Percentage Off' : 'Dollars Off') ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Discount') ?></th>
                        <td><?= $this->Number->format($promoCode->discount) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('No Of Uses') ?></th>
                        <td><?= $this->Number->format($promoCode->no_of_uses) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Restrict use by Course Types') ?></th>
                        <td>
                            <?php if(empty($promoCode->restrict_by_course_types)): ?>
                                <?= h("None") ?>
                            <?php else: 
                            echo 'Yes';
                            endif;
                            ?>     
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Restrict use by Email') ?></th>
                        <td>
                            <?php if(empty($promoCode->restrict_by_email)): ?>
                                <?= h("None") ?>
                            <?php else: 
                            echo 'Yes';
                            endif;
                            ?>     
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Course Types') ?></th>
                        <td>
                            <?php if(empty($promoCode->course_types)): ?>
                                <?= h("None") ?>
                            <?php else: 
                            foreach ($promoCode->course_types as $courseType) {
                                echo $courseType->name."<br>";
                            } 
                            endif;
                            ?>     
                        </td>

                    </tr>
                    <tr>
                        <th scope="row"><?= __('Emails Allowed') ?></th>
                        <td>
                            <?php if(empty($promoCode->promo_code_emails)): ?>
                                <?= h("None") ?>
                            <?php else: 
                            foreach ($promoCode->promo_code_emails as $emailAllowed) {
                                echo $emailAllowed->email."<br>";
                            } 
                            endif;
                            ?>     
                        </td>

                    </tr>
                    <tr>
                        <th scope="row"><?= __('Created') ?></th>
                        <td><?= h($promoCode->created) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Modified') ?></th>
                        <td><?= h($promoCode->modified) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Status') ?></th>
                        <td><?= $promoCode->status ? __('Yes') : __('No'); ?></td>
                    </tr>
                </table>
            <!-- </div> -->
        </div>
    </div>
</div>