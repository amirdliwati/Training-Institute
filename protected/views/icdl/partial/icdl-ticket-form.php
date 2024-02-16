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
        'id' => 'icdl-ticket-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'focus' => array($model, 'first_name_en'),
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
    <?php echo $form->hiddenField($model,'icdl_card_id');?>
    <?php if(!$model->isNewRecord):?>
        <?php echo $form->hiddenField($model,'id');?>
    <?php endif;?>
    <div class="form-group has-feedback">
        <?php echo $form->labelEx($model, 'exam_type', array('class' => 'col-md-4 control-label')); ?>
        <div class="col-md-8 input-container">
            <?php echo $form->dropDownList($model,'exam_type',ICDLTicket::getModuleList(),array(
                'class'=>'form-control',
                'prompt'=>'اختر امتحان',
            )); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($model, 'exam_type'); ?>
        </div>
    </div>

    <?php if(!$model->isNewRecord):?>
        <?php echo $form->hiddenField($model,'id');?>
    <?php endif;?>
    <div class="form-group has-feedback">
        <?php echo $form->labelEx($model, 'status', array('class' => 'col-md-4 control-label')); ?>
        <div class="col-md-8 input-container">
            <?php echo $form->dropDownList($model,'status',ICDLTicket::getStatusList(),array(
                'class'=>'form-control',
                'prompt'=>'اختر حالة الطالب',
            )); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($model, 'status'); ?>
        </div>
    </div>
    <div class="form-group has-feedback">
        <?php echo $form->labelEx($model, 'payment', array('class' => 'col-md-4 control-label')); ?>
        <div class="col-md-8 input-container">
            <?php echo $form->textField($model, 'payment', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($model, 'payment'); ?>
        </div>
    </div>
    <div class="form-group has-feedback">
        <?php echo $form->labelEx($model, 'date', array('class' => 'col-md-4 control-label')); ?>
        <div class="col-md-8 input-container">
            <?php echo $form->textField($model, 'date', array('size' => 60, 'maxlength' => 255, 'class' => 'date-field form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($model, 'date'); ?>
        </div>
    </div>
    <div class="form-group has-feedback">
        <?php echo $form->labelEx($model, 'time', array('class' => 'col-md-4 control-label')); ?>
        <div class="col-md-8 input-container bootstrap-timepicker">
            <?php echo $form->textField($model, 'time', array('size' => 60, 'maxlength' => 255,

                'class' => 'time-field form-control input-small')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($model, 'time'); ?>
        </div>
    </div>


    <div class="form-group">
        <div class="col-sm-offset-4 col-sm-8 col-md-offset-4 col-md-8">
            <?php echo CHtml::ajaxSubmitButton($model->isNewRecord?"إنشاء تذكرة امتحان":"تعديل تذكرة امتحان",$model->isNewRecord?Yii::app()->createUrl('icdl/iCDLTicketCreate'):Yii::app()->createUrl('icdl/iCDLTicketUpdate',array('id'=>$model->id)),array(
                'type'=>'POST',
                'dataType'=>'json',
                'success'=>'js:function(data){
                    $("#createICDLTicketModal .modal-body").html(data.message);
                    $("#updateICDLTicketModal .modal-body").html(data.message);
                    setTimeout(function(){
                        $("#createICDLTicketModal").modal("hide");
                        $("#updateICDLTicketModal").modal("hide");
                    },2000);
                    if(data.status){
                        updateICDLCardTicketList();
                    }
                }',
                'beforeSend'=>'js:function(){
                    $("#createICDLTicketModal .modal-body").html("الرجاء الانتظار ...");
                    $("#updateICDLTicketModal .modal-body").html("الرجاء الانتظار ...");
                }',
                'error'=>'js:function(){
                    $("#createICDLTicketModal").modal("hide");
                    $("#updateICDLTicketModal").modal("hide");
                }'
            ),array(
                'class'=>'btn btn-success',
                'id'=>'link-'.uniqid(),
            )); ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->