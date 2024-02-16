<?php
/* @var $this StudentController */
/* @var $model Payment */
/* @var $form CActiveForm */

Yii::app()->clientScript->registerScript("payment_student_script", '
$(function(){
    $(".ok-sign").hide();
    $(".error-sign").hide();
});
', CClientScript::POS_END);
CommonFunctions::fixAjax();

?>

<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'payment-add-form',
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
    <div class="alert alert-info">
        <p class="note">الحقول بعلامة <span class="required">*</span> هي حقول مطلوبة</p>
    </div>

    <div class="hidden">
        <?php echo $form->hiddenField($model, 'student_id'); ?>
        <?php echo $form->hiddenField($model, 'course_id'); ?>
        <?php echo CHtml::hiddenField('ref',$ref);?>
    </div>


    <div class="form-group has-feedback">
        <?php echo $form->labelEx($model, 'amount', array('class' => 'col-md-2 control-label')); ?>
        <div class="col-md-10 input-container">
            <?php echo $form->textField($model, 'amount', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($model, 'amount'); ?>
        </div>
    </div>
    <div class="form-group has-feedback">
        <?php echo $form->labelEx($model, 'num', array('class' => 'col-md-2 control-label')); ?>
        <div class="col-md-10 input-container">
            <?php echo $form->textField($model, 'num', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($model, 'num'); ?>
        </div>
    </div>
    <div class="form-group has-feedback">
        <?php echo $form->labelEx($model, 'note', array('class' => 'col-md-2 control-label')); ?>
        <div class="col-md-10 input-container">
            <?php echo $form->textField($model, 'note', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($model, 'note'); ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?php echo CHtml::ajaxSubmitButton('دفع فاتورة لدورة '.$course->getCourseNameText() . " - ".$student->getName(), $this->createUrl('addPayment'), array(
                'type' => 'POST',
                'dataType' => 'json',
                'success' => 'js:function(data){

                    vex.defaultOptions.className = "vex-theme-plain";
                    if(data.success==true){
                        $("#course-grid").yiiGridView("update");
                        vex.dialog.alert(data.message);
                    }else{
                        vex.dialog.alert(data.message);
                    }
                }',
                'beforeSend'=>'js:function(){
                    $("#addPaymentModal").modal("hide");
                }',
            ), array(
                'class' => 'btn btn-danger',
                'id'=>'link-'.uniqid(),
                'live'=>false,
            )); ?>
        </div>
    </div>


    <?php $this->endWidget(); ?>

</div><!-- form -->