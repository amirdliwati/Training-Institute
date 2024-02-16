<?php
/* @var $this PaymentController */
/* @var $model Payment */
/* @var $form CActiveForm */
CommonFunctions::fixAjax();
Yii::app()->clientScript->registerScript("course_script", '
    $(".ok-sign").hide();
    $(".error-sign").hide();
', CClientScript::POS_END);
?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'payment-update-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'focus' => array($model, 'amount'),
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

    <div class="hidden">
        <?php echo $form->hiddenField($model, 'student_id'); ?>
        <?php echo $form->hiddenField($model, 'course_id'); ?>
    </div>

    <div class="form-group has-feedback">
        <?php echo $form->labelEx($model, 'note', array('class' => 'col-md-4 control-label')); ?>
        <div class="col-md-6 input-container">
            <?php echo $form->textField($model, 'note', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($model, 'note'); ?>
        </div>
    </div>

    <div class="form-group has-feedback">
        <?php echo $form->labelEx($model, 'num', array('class' => 'col-md-4 control-label')); ?>
        <div class="col-md-6 input-container">
            <?php echo $form->textField($model, 'num', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($model, 'num'); ?>
        </div>
    </div>

    <div class="form-group has-feedback">
        <?php echo $form->labelEx($model, 'date', array('class' => 'col-md-4 control-label')); ?>
        <div class="col-md-6 input-container">
            <?php echo $form->textField($model, 'date', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($model, 'date'); ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-6">
            <?php echo CHtml::ajaxSubmitButton('تعديل فاتورة', $this->createUrl('updatePayment', array('id' => $model->id)), array(
                'type' => 'POST',
                'dataType' => 'json',
                'success' => 'js:function(data){
                    vex.defaultOptions.className = "vex-theme-plain";
                    vex.dialog.alert(data.message);
                    if(data.status==true){
                        $("#app_grid").yiiGridView("update");
                        $("#bills-grid").yiiGridView("update");
                    }
                    $("#paymentUpdateModal").modal("hide");
                }',
                
            ), array(
                'class' => 'btn btn-danger',
                'id' => 'link-' . uniqid(),
            )); ?>
        </div>
    </div>


    <?php $this->endWidget(); ?>

</div><!-- form -->