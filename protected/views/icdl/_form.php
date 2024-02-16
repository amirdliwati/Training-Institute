<?php
/* @var $this IcdlController */
/* @var $model ICDLCard */
/* @var $form CActiveForm */


Yii::app()->clientScript->registerScript("icdl_script", '
$(function(){
    $(".ok-sign").hide();
    $(".error-sign").hide();
});
', CClientScript::POS_END);
CommonFunctions::fixAjax();
?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'icdl-card-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'focus' => array($model, 'first_names'),
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

    <br/>
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
        <?php echo $form->labelEx($model, 'first_name', array('class' => 'col-md-3 control-label')); ?>
        <div class="col-md-3 input-container">
            <?php echo $form->textField($model, 'first_name', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($model, 'first_name'); ?>
        </div>
        <?php echo $form->labelEx($model, 'last_name', array('class' => 'col-md-3 control-label')); ?>
        <div class="col-md-3 input-container">
            <?php echo $form->textField($model, 'last_name', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($model, 'last_name'); ?>
        </div>
    </div>
    <div class="form-group has-feedback">
        <?php echo $form->labelEx($model, 'first_name_en', array('class' => 'col-md-3 control-label')); ?>
        <div class="col-md-3 input-container">
            <?php echo $form->textField($model, 'first_name_en', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($model, 'first_name_en'); ?>
        </div>
        <?php echo $form->labelEx($model, 'last_name_en', array('class' => 'col-md-3 control-label')); ?>
        <div class="col-md-3 input-container">
            <?php echo $form->textField($model, 'last_name_en', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($model, 'last_name_en'); ?>
        </div>
    </div>

    <?php if(!$model->isNewRecord):?>
        <?php echo $form->hiddenField($model,'id');?>
    <?php endif;?>
    <div class="form-group has-feedback">
        <?php echo $form->labelEx($model, 'father_name', array('class' => 'col-md-3 control-label')); ?>
        <div class="col-md-3 input-container">
            <?php echo $form->textField($model, 'father_name', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($model, 'father_name'); ?>
        </div>
        <?php echo $form->labelEx($model, 'un_code', array('class' => 'col-md-3 control-label')); ?>
        <div class="col-md-3 input-container">
            <?php echo $form->textField($model, 'un_code', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($model, 'un_code'); ?>
        </div>
    </div>

    <div class="form-group has-feedback">
        <?php echo $form->labelEx($model, 'payment', array('class' => 'col-md-3 control-label')); ?>
        <div class="col-md-3 input-container">
            <?php echo $form->textField($model, 'payment', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($model, 'payment'); ?>
        </div>
        <?php echo $form->labelEx($model, 'lang', array('class' => 'col-md-3 control-label')); ?>
        <div class="col-md-3 input-container">
            <?php echo $form->dropDownList($model,'lang',array(
                ICDLCard::LANG_ARABIC=>'العربية',
                ICDLCard::LANG_ENGLISH=>'الإنكليزية',
            ),array(
                'class'=>'form-control',
                'prompt'=>'لغة الامتحان',
            )); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($model, 'payment'); ?>
        </div>
    </div>

       <?php echo $form->hiddenField($model, 'student_id'); ?>

    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-8 col-md-offset-4 col-md-8">
            <?php echo CHtml::ajaxSubmitButton($model->isNewRecord?"إنشاء بطاقة جديدة":"تعديل البطاقة",$model->isNewRecord?Yii::app()->createUrl('icdl/create'):Yii::app()->createUrl('icdl/update',array('id'=>$model->id)),array(
                'type'=>'POST',
                'dataType'=>'json',
                'success'=>'js:function(data){
                    $("#createICDLCardModal .modal-body").html(data.message);
                    $("#updateICDLCardModal .modal-body").html(data.message);
                    if(data.status){
                        $.fn.yiiGridView.update("icdl-card-grid", {
                            data: $("#search-form-container form").serialize()
                        });
                    }
                }',
                'beforeSend'=>'js:function(){
                    $("#createICDLCardModal .modal-body").html("الرجاء الانتظار ...");
                    $("#updateICDLCardModal .modal-body").html("الرجاء الانتظار ...");
                }',
                'error'=>'js:function(){
                    $("#createICDLCardModal").modal("hide");
                    $("#updateICDLCardModal").modal("hide");
                }'
            ),array(
                'class'=>'btn btn-success',
                'id'=>'link-'.uniqid(),
            )); ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->