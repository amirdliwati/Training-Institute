<?php
/**
 * Created by PhpStorm.
 * User: Dell 3521
 * Date: 02/06/14
 * Time: 06:54 ص
 */

CommonFunctions::fixAjax();
Yii::app()->clientScript->registerScript("course_script_session_form", '
$(function(){
    $(".ok-sign").hide();
    $(".error-sign").hide();
});
', CClientScript::POS_END);

?>
<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'course-session-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
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

    ));
    ?>
    <?php echo $form->hiddenField($model, 'course_id'); ?>
    <div class="form-group has-feedback">
        <?php echo $form->labelEx($model, 'date', array('class' => 'col-md-3 control-label')); ?>
        <div class="col-md-9 input-container">
            <?php echo $form->textField($model, 'date', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($model, 'date'); ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            <?php echo CHtml::ajaxSubmitButton($model->isNewRecord ? "إضافة جلسة درسية" : "تعديل جلسة درسية", $model->isNewRecord ? $this->createUrl('addCourseSession') : $this->createUrl('updateCourseSession', array('id' => $model->id)), array(
                'type' => "POST",
                'dataType' => 'json',
                'success' => 'js:function(data,status,xhr){
                    vex.defaultOptions.className = "vex-theme-plain";
                    vex.dialog.alert(data.message);
                    $("#courseSessionSetupModal").modal("hide");
                    $("#sessionUpdateFormModal").modal("hide");
                    if(data.success){
                        $("#sessions-grid").yiiGridView("update");
                        courseViewUpdate();
                    }
                }',
            ), array(
                'class' => 'btn btn-success',
                'id'=>'link-'.uniqid(),
            )); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
