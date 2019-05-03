        <?php
        /**
        * @var \App\View\AppView $this
        * @var \App\Model\Entity\InstructorReference $instructorReference
        */
        ?>
        <?php

        $salonTemplate = [
        'button' => '<button class="btn btn-primary m-b col-sm-offset-5" {{attrs}}>{{text}}</button>'
        ];

        $this->Form->setTemplates($salonTemplate);

        ?>
        <div class="row">
            <div class="col-lg-12">
       <div class="ibox float-e-margins">
                  <div class="ibox-content">




                    <div class="instructorReferences form large-9 medium-8 columns content">
                        <?= $this->Form->create($instructorReference) ?>
                        <fieldset>
                            <!-- <div class = 'ibox-title'> -->
                                <legend><?= __('Add Reference') ?></legend>
                            <!-- </div> -->
                            <?php if(!$instructor_id){

                                echo $this->Form->control('instructor_id', ['label'=>'Instructor Name','options' => $instructors]);
                            }
                            ?>
                            <?php
                            echo $this->Form->control('name',['required', 'type'=>'text', 'data-validation'=>'custom', 'data-validation-regexp'=>'^[A-Za-z.\s_-]+$']);
                            echo $this->Form->control('email',['required', 'type' => 'text','data-validation'=> "email"]);
                            echo $this->Form->control('phone_number',['required', 'type' => 'text','data-validation'=> "number length", 'data-validation-length'=>"6-10"]);

                            ?>
                        </fieldset>
                        <?= $this->Form->button(__('Submit')) ?>
                        <?= $this->Html->link('Cancel',$this->request->referer(),['class' => ['btn', 'btn-danger']]);?>
                        <?= $this->Form->end() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            $.validate();
            $.validate({
                modules : 'location',
                onModulesLoaded : function() {
                    $('input[name="state"]').suggestState();
                }
            });
        });
    </script>
