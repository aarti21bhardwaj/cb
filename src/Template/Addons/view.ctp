<!-- <div class="addons view large-9 medium-8 columns content"> -->
    <div class = 'row'>
        <div class = 'col-lg-12'>
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <table class="table">
                        <tr>
                            <th scope="row"><?= __('Tenant') ?></th>
                            <td><?= $addon->tenant->center_name?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?= __('Product Code') ?></th>
                            <td><?= h($addon->product_code) ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?= __('Name') ?></th>
                            <td><?= h($addon->name) ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?= __('Price') ?></th>
                            <td><?= h($addon->price) ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?= __('Description') ?></th>
                            <td><?= $addon->description ?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?= __('Product Description') ?></th>
                            <td><?= $addon->short_description?></td>
                        </tr>
                        <tr>
                            <th scope="row"><?= __('Type') ?></th>
                            <td><?php 
                        if($addon->type == 0){
                            echo 'Shippable';
                        }else if($addon->type == 1){
                            echo 'Non Shippable';
                        }else if($addon->type == 2){
                            echo 'Key Categorised';
                             if(isset($addon->key_category->name) && !empty(isset($addon->key_category->name))){ ?>
                                    <tr>
                                        <th scope="row"><?= __('Key Category') ?></th>
                                        <td>
                                            <?php echo $addon->key_category->name;?>
                                        </td>
                                    </tr>
                                    <?php }

                        }
                        ?>
                         </td>
                        </tr>
                        <!-- <?php if(isset($addon->key_category->name) && !empty(isset($addon->key_category->name))){ ?>
                        <tr>
                            <th scope="row"><?= __('Key Category') ?></th>
                            <td>
                                <?php echo $addon->key_category->name;?>
                            </td>
                        </tr>
                        <?php }?> -->
                        <tr>
                            <th scope="row"><?= __('Product Status') ?></th>
                            <td><?= $addon->option_status ? __('Active') : __('Inactive'); ?></td>
                        </tr>
                    </table>
                     
                </div> <!-- ibox-content end -->
            </div> <!-- ibox end-->
        </div><!-- col-lg-12 end-->
    </div> <!-- row end-->
    