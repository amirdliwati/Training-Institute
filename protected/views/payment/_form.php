<?php
/**
 * Created by PhpStorm.
 * User: Burhan
 * Date: 1/16/2016
 * Time: 9:32 AM
 */

Yii::app()->clientScript->registerScript("course_script", '
$(function(){
    $(".ok-sign").hide();
    $(".error-sign").hide();

});
', CClientScript::POS_END);


?>
<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'payment-add-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
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

    <?php if(strlen($message)>0):?>
        <div class="col-md-12">
            <div class="alert alert-success">
                <?php echo $message;?>
            </div>
        </div>
    <?php endif;?>
    <?php if($model->hasErrors()):?>
    <div class="col-md-12">
        <div class="alert alert-danger">
            <?php echo $form->errorSummary($model,'رجاء اصلح الأخطاء التالية');?>
        </div>
    </div>
    <?php endif;?>


    <div class="form-group has-feedback">
        <?php echo $form->labelEx($model, 'course_type_id', array('class' => 'col-md-2 control-label')); ?>
        <div class="col-md-6 input-container">
            <?php echo $form->dropDownList($model, 'course_type_id', CourseType::model()->getAvailableCourseTypes(), array(
                'prompt' => 'اختر نوع الدورة',
                'class' => 'form-control',
                'ajax' => array(
                    'url'=>Yii::app()->createUrl('payment/getStudentDropList'),
                    'data'=>array(
                        'course_type_id'=>'js:$(this).val()',
                    ),
                    'type'=>'GET',
                    'success'=>'js:function(data){
                        $("#students_drop_select").html(data);
                    }',
                    'beforeSend'=>'js:function(){
                        $("#students_drop_select").html("<option value=\"\">الرجاء الانتظار...</option>");
                    }',
                    'error'=>'js:function(){
                        $("#students_drop_select").html("");
                    }',
                ),

            )); ?>
            <?php echo $form->error($model, 'course_type_id'); ?>
        </div>
    </div>


    <div class="form-group has-feedback">
        <?php echo $form->labelEx($model, 'student_course_id', array('class' => 'col-md-2 control-label')); ?>
        <div class="col-md-6 input-container">
            <?php echo $form->dropDownList($model, 'student_course_id',array(), array(
                'prompt' => '',
                'class' => 'form-control',
                'id'=>'students_drop_select',
            )); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($model, 'student_course_id'); ?>
        </div>
    </div>

    <div class="form-group has-feedback">
        <?php echo $form->labelEx($model, 'amount', array('class' => 'col-md-2 control-label')); ?>
        <div class="col-md-6 input-container">
            <?php echo $form->textField($model, 'amount', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($model, 'amount'); ?>
        </div>
    </div>
    <div class="form-group has-feedback">
        <?php echo $form->labelEx($model, 'num', array('class' => 'col-md-2 control-label')); ?>
        <div class="col-md-6 input-container">
            <?php echo $form->textField($model, 'num', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($model, 'num'); ?>
        </div>
    </div>
    <div class="form-group has-feedback">
        <?php echo $form->labelEx($model, 'date', array('class' => 'col-md-2 control-label')); ?>
        <div class="col-md-6 input-container">
            <?php echo $form->textField($model, 'date', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>

            <?php echo $form->error($model, 'date'); ?>
        </div>
    </div>
    <div class="form-group has-feedback">
        <?php echo $form->labelEx($model, 'note', array('class' => 'col-md-2 control-label')); ?>
        <div class="col-md-6 input-container">
            <?php echo $form->textField($model, 'note', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>

            <?php echo $form->error($model, 'note'); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?php echo CHtml::submitButton('دفع فاتورة', array(
                'class' => 'btn btn-danger',
            )); ?>
        </div>
    </div>


    <?php $this->endWidget(); ?>

</div><!-- form -->

