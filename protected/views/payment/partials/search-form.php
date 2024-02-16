<?php
/* @var $this PaymentController */
/* @var $model Payment */
/* @var $form CActiveForm */
?>
<br/>
<div class="panel panel-info search-form">
    <div class="panel-heading">البحث المتقدم في الفواتير</div>
    <div class="panel-body">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'action'=>Yii::app()->createUrl($this->route),
            'method'=>'get',
            'htmlOptions'=>array(
                'role'=>'form',
                'class'=>'form-horizontal',
            ),
        )); ?>
        <div class="form-group has-feedback">
            <?php echo CHtml::label("الاسم الأول للطالب","", array('class' => 'col-md-3 control-label')); ?>
            <div class="col-md-9 input-container">
                <?php echo CHtml::textField("student_first_name","",array('size' => 60, 'maxlength' => 255, 'class' => 'form-control'));?></span>
                <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
                <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>

            </div>
        </div>
        <div class="form-group has-feedback">
            <?php echo CHtml::label("الاسم الاخير للطالب","", array('class' => 'col-md-3 control-label')); ?>
            <div class="col-md-9 input-container">
                <?php echo CHtml::textField("student_last_name","",array('size' => 60, 'maxlength' => 255, 'class' => 'form-control'));?></span>
                <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
                <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            </div>
        </div>

        <div class="form-group has-feedback">
            <?php echo $form->labelEx($model, 'course_id', array('class' => 'col-md-3 control-label')); ?>
            <div class="col-md-9 input-container">
                <?php echo $form->dropDownList($model, 'course_id', CourseType::model()->getAvailableCourseTypes(), array('prompt' => 'اختر نوع الدورة', 'class' => 'form-control')); ?>
                <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
                <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
                <?php echo $form->error($model, 'course_id'); ?>
            </div>
        </div>


        <div class="form-group has-feedback">
            <?php echo $form->labelEx($model, 'num', array('class' => 'col-md-3 control-label')); ?>
            <div class="col-md-9 input-container">
                <?php echo $form->textField($model, 'num', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
                <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
                <?php echo $form->error($model, 'num'); ?>
            </div>
        </div>


        <div class="form-group has-feedback">
            <?php echo $form->labelEx($model, 'amount', array('class' => 'col-md-3 control-label')); ?>
            <div class="col-md-9 input-container">
                <?php echo $form->textField($model, 'amount', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
                <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
                <?php echo $form->error($model, 'amount'); ?>
            </div>
        </div>
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
                <?php echo CHtml::submitButton('فلترة', array(
                    'class' => 'btn btn-success',
                )); ?>
            </div>
        </div>

        <?php $this->endWidget(); ?>

    </div>

</div><!-- search-form -->