<?php
/* @var $this InstructorController */
/* @var $model Instructor */
/* @var $form CActiveForm */
?>

<div class="panel panel-info">
    <div class="panel-heading">البحث المتقدم في الأساتذة</div>
    <div class="panel-body">
        <?php $form=$this->beginWidget('CActiveForm', array(
            'action'=>Yii::app()->createUrl($this->route),
            'method'=>'get',
            'htmlOptions'=>array(
                'role'=>'form',
                'class'=>'form-horizontal',
            ),
        )); ?>
        <div class="form-group">
            <?php echo $form->label($model,'first_name',array('class'=>'col-md-2','for'=>'name')); ?>
            <div class="col-md-4">
                <?php echo $form->textField($model,'first_name',array('size'=>60,'maxlength'=>255,'id'=>'name','class'=>'form-control')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo $form->label($model,'last_name',array('class'=>'col-md-2','for'=>'name')); ?>
            <div class="col-md-4">
                <?php echo $form->textField($model,'last_name',array('size'=>60,'maxlength'=>255,'id'=>'name','class'=>'form-control')); ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-2 col-md-4">
                <?php echo CHtml::submitButton('   فلترة   ',array(
                    'class'=>'btn btn-success',
                )); ?>
            </div>
        </div>

        <?php $this->endWidget(); ?>

    </div>

</div><!-- search-form -->