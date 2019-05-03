    <?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CourseTypeCategory $courseTypeCategory
 */
?>

<!-- <div class="courseTypeCategories view large-9 medium-8 columns content"> -->
<div class = 'row'>
    <div class = 'col-lg-12'>
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <table class="table">
                    <tr>
                        <th scope="row"><?= __('Name') ?></th>
                        <td><?= h($courseTypeCategory->name) ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?= __('Description') ?></th>
                        <td><?= $courseTypeCategory->description ?></td>
                    </tr>
                </table>
                
            </div> <!-- ibox-content end -->
        </div> <!-- ibox end-->
    </div><!-- col-lg-12 end-->
</div> <!-- row end-->


