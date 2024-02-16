<?php
/* @var $this InstructorController */
/* @var $model Instructor */
/* @var $form CActiveForm */

?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'instructor-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'focus' => array($model, 'first_name'),
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

    <div class="alert alert-info">
        <p class="note">الحقول بعلامة <span class="required">*</span> هي حقول مطلوبة</p>
    </div>

    <?php if ($model->hasErrors()): ?>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?php echo $form->errorSummary($model, 'رجاء اصلح الأخطاء التالية:', $model->isNewRecord ? 'بعد الإصلاح اضغط إنشاء' : 'بعد الإصلاح اضغط تعديل') ?>
        </div>
    <?php endif; ?>
    <div class="form-group has-feedback">
        <?php echo $form->labelEx($model, 'first_name', array('class' => 'col-md-2 control-label')); ?>
        <div class="col-md-10 input-container">
            <?php echo $form->textField($model, 'first_name', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($model, 'first_name'); ?>
        </div>
    </div>

    <div class="form-group has-feedback">
        <?php echo $form->labelEx($model, 'last_name', array('class' => 'col-md-2 control-label')); ?>
        <div class="col-md-10">
            <?php echo $form->textField($model, 'last_name', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($model, 'last_name'); ?>
        </div>
    </div>

    <div class="form-group has-feedback">
        <?php echo $form->labelEx($model, 'tel', array('class' => 'col-md-2 control-label')); ?>
        <div class="col-md-10">
            <?php echo $form->textField($model, 'tel', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($model, 'tel'); ?>
        </div>
    </div>

    <div class="form-group has-feedback">
        <?php echo $form->labelEx($model, 'mobile', array('class' => 'col-md-2 control-label')); ?>
        <div class="col-md-10">
            <?php echo $form->textField($model, 'mobile', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($model, 'mobile'); ?>
        </div>
    </div>
    <div class="form-group has-feedback">
        <?php echo $form->labelEx($model, 'note', array('class' => 'col-md-2 control-label')); ?>
        <div class="col-md-10">
            <?php echo $form->textArea($model, 'note', array('rows' => 10, 'cols' => 200, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($model, 'note'); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'إنشاء' : 'تعديل', array(
                'class' => 'btn btn-success',
            )); ?>
        </div>
    </div>


    <?php $this->endWidget(); ?>

</div><!-- form -->