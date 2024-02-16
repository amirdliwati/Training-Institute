<?php
/* @var $this PaymentController */
/* @var $model Payment */
/* @var $form CActiveForm */

Yii::app()->clientScript->registerScript("course_script", '
$(function(){
    $(".ok-sign").hide();
    $(".error-sign").hide();
});
', CClientScript::POS_END);

?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'damascus-list-add-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'focus' => array($model, 'num'),
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

    <div class="form-group has-feedback">
        <?php echo $form->labelEx($model, 'num', array('class' => 'col-md-4 control-label')); ?>
        <div class="col-md-8 input-container">
            <?php echo $form->textField($model, 'num', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($model, 'num'); ?>
        </div>
    </div>
    <div class="form-group has-feedback">
        <?php echo $form->labelEx($model, 'date', array('class' => 'col-md-4 control-label')); ?>
        <div class="col-md-8 input-container">
            <?php echo $form->textField($model, 'date', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($model, 'date'); ?>
        </div>
    </div>
    <div class="form-group has-feedback">
        <?php echo $form->labelEx($model, 'start_date', array('class' => 'col-md-4 control-label')); ?>
        <div class="col-md-8 input-container">
            <?php echo $form->textField($model, 'start_date', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($model, 'start_date'); ?>
        </div>
    </div>
    <div class="form-group has-feedback">
        <?php echo $form->labelEx($model, 'end_date', array('class' => 'col-md-4 control-label')); ?>
        <div class="col-md-8 input-container">
            <?php echo $form->textField($model, 'end_date', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($model, 'end_date'); ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-8">
            <?php echo CHtml::ajaxSubmitButton('إنشاء لائحة دمشق جديدة', $this->createUrl('create'), array(
                'type' => 'POST',
                'beforeSend'=>'js:function(){
                    $("#addNewDamascusListModal").modal("hide");
                    $("#filterPleaseWaitModal .modal-body").html("الرجاء الانتظار ....");
                    $("#filterPleaseWaitModal").modal("show");
                }',
                'success' => 'js:function(data){
                    $("#filterPleaseWaitModal").modal("hide");
                    $("#damascusListCreationSuccessModal .modal-body").html(data);
                    $("#damascusListCreationSuccessModal").modal("show");
                    $("#damascus-list-grid").yiiGridView("update");
                }',
            ), array(
                'class' => 'btn btn-danger',
                'id'=>'link-'.uniqid(),
            )); ?>
        </div>
    </div>


    <?php $this->endWidget(); ?>

</div><!-- form -->