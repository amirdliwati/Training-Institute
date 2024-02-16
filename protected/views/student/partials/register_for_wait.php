<?php
/* @var $this StudentController */
/* @var $model Registration */
/* @var $form CActiveForm */

CommonFunctions::fixAjax();
Yii::app()->clientScript->registerScript("form-script", '
    $(".ok-sign").hide();
    $(".error-sign").hide();
', CClientScript::POS_END);
?>

<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'register_for_wait-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'focus' => array($model, 'course_type_id'),
        'clientOptions' => array(
            'successCssClass' => 'has-success',
            'errorCssClass' => 'has-error',
            'validatingErrorMessage' => '',
            'inputContainer' => '.form-group',
            'afterValidateAttribute' => 'js:function(form, attribute, data, hasError){
                $("#"+attribute.inputID).siblings(".error-sign").hide();
                $("#"+attribute.inputID).siblings(".ok-sign").hide();
                if(hasError){
                    $("#"+attribute.inputID).siblings(".error-sign").show();
                }else {
                    $("#"+attribute.inputID).siblings(".ok-sign").show();
                }
            }',
        ),
        'htmlOptions' => array(
            'role' => 'form',
            'class' => 'form-horizontal',
        ),
    )); ?>

    <?php echo $form->hiddenField($model, 'student_id')?>

    <div class="form-group has-feedback">
        <?php echo $form->labelEx($model, 'course_type_id', array('class' => 'col-md-4 control-label')); ?>
        <div class="col-md-8 input-container">
            <?php echo $form->dropDownList($model, 'course_type_id', CourseType::model()->getAvailableCourseTypes(), array('prompt' => 'اختر نوع الدورة', 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($model, 'course_type_id'); ?>
        </div>
    </div>

    <div class="form-group has-feedback">
        <?php echo $form->labelEx($model, 'initial_payment', array('class' => 'col-md-4 control-label')); ?>
        <div class="col-md-8 input-container">
            <?php echo $form->textField($model, 'initial_payment', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($model, 'initial_payment'); ?>
        </div>
    </div>
    <div class="form-group has-feedback">
        <?php echo $form->labelEx($model, 'initial_payment_num', array('class' => 'col-md-4 control-label')); ?>
        <div class="col-md-8 input-container">
            <?php echo $form->textField($model, 'initial_payment_num', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($model, 'initial_payment_num'); ?>
        </div>
    </div>
    <div class="form-group has-feedback">
        <?php echo $form->labelEx($model, 'preferred_time', array('class' => 'col-md-4 control-label')); ?>
        <div class="col-md-8 input-container">
            <?php echo $form->dropDownList($model, 'preferred_time', Registration::model()->getAvailableTimeSlots(), array('prompt' => 'اختر الوقت المناسب للدورة', 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($model, 'preferred_time'); ?>
        </div>
    </div>
    <div class="form-group has-feedback">
        <?php echo $form->labelEx($model, 'note', array('class' => 'col-md-4 control-label')); ?>
        <div class="col-md-8 input-container">
            <?php echo $form->textField($model, 'note', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($model, 'note'); ?>
        </div>
    </div>
    <?php if(!$model->isNewRecord):?>
        <div class="form-group has-feedback">
            <?php echo $form->labelEx($model, 'registration_date', array('class' => 'col-md-4 control-label')); ?>
            <div class="col-md-8 input-container">
                <?php echo $form->textField($model, 'registration_date', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
                <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
                <?php echo $form->error($model, 'registration_date'); ?>
            </div>
        </div>
    <?php endif;?>
    <div class="form-group">
        <div class="col-md-offset-4 col-md-8">
            <?php echo CHtml::ajaxSubmitButton($model->isNewRecord? 'تسجيل' :'تعديل بيانات التسجيل',$model->isNewRecord? $this->createUrl('registerForWait'):$this->createUrl('updateRegistration'),
                array(
                    'type' => 'POST',
                    'success' => 'js:function(data){
                        $("#registerForWaitModal").modal("hide");
                        if(data.status){
                            studentId = data.studentId;
                            vex.defaultOptions.className = "vex-theme-plain";
                            vex.dialog.alert(data.message);

                            $("#waiting-course-grid").yiiGridView("update");
                            $("#app_grid").yiiGridView("update");
                        }else{
                            vex.defaultOptions.className = "vex-theme-plain";
                            vex.dialog.alert(data.message);
                        }
                    }',
                    'dataType' => 'json',
                    'beforeSend' => 'js:function(xhr,setting){
                        $("#registerForWaitModal .modal-body").html("الرجاء الانتظار...");
                    }'
                )
                , array(
                    'class' => 'btn btn-danger',
                    'id' => 'link-' . uniqid(),
                )); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->