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
if(isset($ref)){
    CommonFunctions::fixAjax();
}
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
    <br/>
    <?php if(isset($ref) && $ref=="course_page"):?>
        <div class="row">
            <div class="col-md-4">تكلفة الدورة</div>
            <div class="col-md-6"><?php echo $paymentInfo['cost'];?></div>
        </div>
        <div class="row">
            <div class="col-md-4">المدفوع</div>
            <div class="col-md-6"><?php echo $paymentInfo['paid'];?></div>
        </div>
        <div class="row">
            <div class="col-md-4">الخصم</div>
            <div class="col-md-6"><?php echo $paymentInfo['discount'];?></div>
        </div>
        <div class="row">
            <div class="col-md-4">المتبقي للدفع</div>
            <div class="col-md-6"><?php echo $paymentInfo['remaining'];?></div>
        </div>
    <?php endif;?>
    <br/>
    <div class="hidden">
        <?php echo $form->hiddenField($model, 'student_id'); ?>

    </div>
    <?php if(isset($ref) && $ref=="course_page"):?>
        <div class="form-group has-feedback">
            <?php echo CHtml::label('اسم الطالب','',array('class'=>'control-label col-md-2')) ?>
            <div class="col-md-10 input-container">
                <?php echo $student->getName(); ?>
            </div>
        </div>
    <?php endif;?>
    <?php if(!isset($_GET['ref'])):?>
        <?php echo $form->hiddenField($model, 'course_id'); ?>
    <?php endif;?>
    <?php if(isset($ref)):?>
        <?php if($_GET['ref']=='course_page'):?>
            <?php echo $form->hiddenField($model, 'course_id'); ?>
        <?php endif;?>
        <?php if($_GET['ref']=='student_page'):?>
            <div class="form-group has-feedback">
                <?php echo $form->labelEx($model, 'course_id', array('class' => 'col-md-2 control-label')); ?>
                <div class="col-md-10 input-container">
                    <?php echo $form->dropDownList($model, 'course_id',$courseList, array('class' => 'form-control')); ?>
                    <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
                    <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
                    <?php echo $form->error($model, 'course_id'); ?>
                </div>
            </div>
        <?php endif;?>
    <?php endif;?>


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
    <?php if(!isset($ref)):?>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <?php echo CHtml::ajaxSubmitButton('دفع فاتورة', $this->createUrl('pay'), array(
                    'type' => 'POST',
                    'dataType' => 'json',
                    'success' => 'js:function(data){
                    $("#addNewPaymentModal").modal("hide");
                    if(data.status=="success"){
                        $("#app_grid").yiiGridView("update");
                        refreshPaymentInfo();
                    }else{
                        vex.defaultOptions.className = "vex-theme-plain";
                        vex.dialog.alert(data.message);
                    }
                }',
                ), array(
                    'class' => 'btn btn-danger',
                    'id'=>'link-'.uniqid(),
                )); ?>
            </div>
        </div>
    <?php endif;?>
    <?php if(isset($ref)):?>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <?php echo CHtml::ajaxSubmitButton('دفع فاتورة', $this->createUrl('pay'), array(
                    'type' => 'POST',
                    'dataType' => 'json',
                    'success' => 'js:function(data){
                        $("#payModal").modal("hide");
                        vex.defaultOptions.className = "vex-theme-plain";
                        if(data.status=="success"){
                             vex.dialog.alert(data.message);
                            $("#student-course-grid").yiiGridView("update");
                        }else{
                            vex.dialog.alert(data.message);
                        }
                }',
                ), array(
                    'class' => 'btn btn-danger',
                    'id'=>'link-'.uniqid(),
                )); ?>
            </div>
        </div>
    <?php endif;?>

    <?php $this->endWidget(); ?>

</div><!-- form -->