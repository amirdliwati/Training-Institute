<?php
/* @var $this DamascusListController */
/* @var $model DamascusList */
/* @var $form CActiveForm */
?>

<div class="panel panel-info">
    <div class="panel-heading">البحث ضمن لوائح دمشق</div>
    <div class="panel-body">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'action' => Yii::app()->createUrl($this->route),
            'method' => 'get',
            'htmlOptions' => array(
                'role' => 'form',
                'class' => 'form-horizontal',
            ),
        )); ?>

        <div class="row">
            <div class="col-md-6">
                <h4>البحث ضمن اللوائح</h4>
                <hr style="border-bottom:solid 1px #777;"/>
                <div class="form-group has-feedback">
                    <?php echo CHtml::label("رقم اللائحة","",array('class' => 'col-md-5 control-label'));?>
                    <div class="col-md-7 input-container">
                        <?php echo $form->textField($model, 'num', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
                        <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
                        <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
                        <?php echo $form->error($model, 'num'); ?>
                    </div>
                </div>
                <div class="form-group has-feedback">
                    <?php echo CHtml::label("تاريخ اللائحة","",array('class' => 'col-md-5 control-label'));?>
                    <div class="col-md-7 input-container">
                        <?php echo $form->textField($model, 'date', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
                        <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
                        <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
                        <?php echo $form->error($model, 'date'); ?>
                    </div>
                </div>
                <div class="form-group has-feedback">
                    <?php echo CHtml::label("تاريخ البداية في اللائحة","",array('class' => 'col-md-5 control-label'));?>
                    <div class="col-md-7 input-container">
                        <?php echo $form->textField($model, 'start_date', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
                        <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
                        <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
                        <?php echo $form->error($model, 'start_date'); ?>
                    </div>
                </div>

                <div class="form-group has-feedback">
                    <?php echo CHtml::label("تاريخ النهاية في اللائحة","",array('class' => 'col-md-5 control-label'));?>
                    <div class="col-md-7 input-container">
                        <?php echo $form->textField($model, 'end_date', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
                        <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
                        <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
                        <?php echo $form->error($model, 'end_date'); ?>
                    </div>
                </div>


            </div>
            <div class="col-md-6">
                <h4>البحث المتقدم</h4>
                <hr style="border-bottom:solid 1px #777;"/>
                <div class="form-group has-feedback">
                    <?php echo $form->labelEx($model, 'course_type_id', array('class' => 'col-md-5 control-label')); ?>
                    <div class="col-md-7 input-container">
                        <?php echo $form->dropDownList($model, 'course_type_id', CourseType::model()->getAvailableCourseTypes(), array('prompt' => 'اختر نوع الدورة', 'class' => 'form-control')); ?>
                        <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
                        <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
                        <?php echo $form->error($model, 'course_type_id'); ?>
                    </div>
                </div>

                <div class="form-group has-feedback">
                    <?php echo $form->labelEx($model, 'first_name', array('class' => 'col-md-5 control-label')); ?>
                    <div class="col-md-7 input-container">
                        <?php echo $form->textField($model, 'first_name', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
                        <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
                        <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
                        <?php echo $form->error($model, 'first_name'); ?>
                    </div>
                </div>
                <div class="form-group has-feedback">
                    <?php echo $form->labelEx($model, 'last_name', array('class' => 'col-md-5 control-label')); ?>
                    <div class="col-md-7 input-container">
                        <?php echo $form->textField($model, 'last_name', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
                        <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
                        <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
                        <?php echo $form->error($model, 'last_name'); ?>
                    </div>
                </div>
                <div class="form-group has-feedback">
                    <?php echo $form->labelEx($model, 'father_name', array('class' => 'col-md-5 control-label')); ?>
                    <div class="col-md-7 input-container">
                        <?php echo $form->textField($model, 'father_name', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
                        <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
                        <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
                        <?php echo $form->error($model, 'father_name'); ?>
                    </div>
                </div>
            </div>

        </div>


        <div class="form-group">
            <div class="col-sm-12">
                <?php echo CHtml::submitButton('فلترة', array(
                    'class' => 'btn btn-success btn-block btn-lg',
                )); ?>
            </div>
        </div>

        <?php $this->endWidget(); ?>

    </div>

</div><!-- search-form -->