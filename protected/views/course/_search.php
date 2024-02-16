<?php
/* @var $this CourseController */
/* @var $model Course */
/* @var $form CActiveForm */
?>

<div class="panel panel-info">
    <div class="panel-heading">البحث المتقدم في الدورات</div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'htmlOptions' => array(
                'role' => 'form',
                'class' => 'form-horizontal',
            ),
        )); ?>


        <div class="form-group has-feedback">
            <?php echo $form->labelEx($model, 'course_type_id', array('class' => 'col-md-3 control-label')); ?>
            <div class="col-md-9 input-container">
                <?php echo $form->dropDownList($model, 'course_type_id', CourseType::model()->getAvailableCourseTypes(), array('prompt' => 'اختر نوع الدورة', 'class' => 'form-control')); ?>
                <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
                <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
                <?php echo $form->error($model, 'course_type_id'); ?>
            </div>
        </div>

        <div class="form-group has-feedback">
            <?php echo $form->labelEx($model, 'cost', array('class' => 'col-md-3 control-label')); ?>
            <div class="col-md-9 input-container">
                <?php echo $form->textField($model, 'cost', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
                <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
                <?php echo $form->error($model, 'cost'); ?>
            </div>
        </div>
        <div class="form-group has-feedback">
            <?php echo $form->labelEx($model, 'start_date', array('class' => 'col-md-3 control-label')); ?>
            <div class="col-md-9 input-container">
                <?php echo $form->textField($model, 'start_date', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
                <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
                <?php echo $form->error($model, 'start_date'); ?>
            </div>
        </div>

        <div class="form-group has-feedback">
            <?php echo $form->labelEx($model, 'end_date', array('class' => 'col-md-3 control-label')); ?>
            <div class="col-md-9 input-container">
                <?php echo $form->textField($model, 'end_date', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
                <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
                <?php echo $form->error($model, 'end_date'); ?>
            </div>
        </div>

        <div class="form-group has-feedback">
            <?php echo $form->labelEx($model, 'note', array('class' => 'col-md-3 control-label')); ?>
            <div class="col-md-9 input-container">
                <?php echo $form->textField($model, 'note', array('col' => 400, 'row' => 8)); ?>
                <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
                <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
                <?php echo $form->error($model, 'note'); ?>
            </div>
        </div>

        <div class="form-group has-feedback">
            <?php echo $form->labelEx($model, 'status', array('class' => 'col-md-3 control-label')); ?>
            <div class="col-md-9 input-container">
                <?php echo $form->dropDownList($model, 'status', Course::model()->getAvailableCourseStatus(), array('prompt' => 'اختر حالة الدورة', 'class' => 'form-control')); ?>
                <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
                <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
                <?php echo $form->error($model, 'status'); ?>
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