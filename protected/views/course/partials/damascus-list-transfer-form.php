<?php
CommonFunctions::fixAjax();
echo CHtml::beginForm($this->createUrl("transfer"), 'post', array(
    'role' => 'form',
    'class' => 'form-horizontal',
));?>
    <div class="form-group">
        <?php echo CHtml::label("رقم اللائحة", 'damascus_list_no', array('class' => 'col-md-3 control-label')); ?>
        <div class="col-md-9 input-container">
            <?php echo CHtml::textField("damascus_list_no", 0, array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
        </div>
    </div>
<?php echo CHtml::hiddenField('student_id', $student_id) ?>
<?php echo CHtml::hiddenField('course_id', $course_id) ?>
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            <?php echo CHtml::ajaxSubmitButton('ترحيل الطالب', $this->createUrl('transfer'), array(
                'type' => 'POST',
                'dataType' => 'json',
                'success' => 'js:function(data){
                    if(data.status){
                        $("#student-course-grid").yiiGridView("update");
                        vex.defaultOptions.className = "vex-theme-plain";
                        vex.dialog.alert(data.message);
                    }else{
                        vex.defaultOptions.className = "vex-theme-plain";
                        vex.dialog.alert(data.message);
                    }
                }',
                'beforeSend' => 'js:function(){
                    $("#studentTransferModal").modal("hide");
                }',
            ), array(
                'class' => 'btn btn-danger',
                'id' => 'link-' . uniqid(),
            ))?>
        </div>
    </div>
<?php echo CHtml::endForm(); ?>