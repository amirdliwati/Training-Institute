<?php
/* @var $this InstructorController */
/* @var $model Instructor */
/* @var $form CActiveForm */
$this->cssFiles[] = "login.css";
Yii::app()->clientScript->registerScript("login", '
$(".error-sign").hide();
$(".ok-sign").hide();
', CClientScript::POS_END);
?>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <div class="panel panel-info">

            <div class="panel-body">

                <div class="form">

                    <?php $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'login-form',
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



                    <?php if ($model->hasErrors()): ?>
                        <div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?php echo $form->errorSummary($model, 'رجاء اصلح الأخطاء التالية:') ?>
                        </div>
                    <?php endif; ?>
                    <div class="form-group has-feedback">
                        <?php echo $form->labelEx($model, 'email', array('class' => 'col-md-6 control-label')); ?>
                        <div class="col-md-6 input-container">
                            <?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 255, 'align' => 'left', 'class' => 'form-control')); ?>
                            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
                            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
                            <?php echo $form->error($model, 'email'); ?>
                        </div>
                    </div>

                    <div class="form-group has-feedback">
                        <?php echo $form->labelEx($model, 'password', array('class' => 'col-md-6 control-label')); ?>
                        <div class="col-md-6">
                            <?php echo $form->passwordField($model, 'password', array('size' => 60, 'maxlength' => 255, 'align' => 'left', 'class' => 'form-control')); ?>
                            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
                            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
                            <?php echo $form->error($model, 'password'); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-6 col-md-6">
                            <?php echo CHtml::submitButton('تسجيل الدخول', array(
                                'class' => 'btn btn-danger',
                            )); ?>
                        </div>
                    </div>


                    <?php $this->endWidget(); ?>

                </div>
                <!-- form -->


            </div>
        </div>
    </div>
</div>