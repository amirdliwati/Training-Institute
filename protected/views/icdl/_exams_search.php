<?php
/**
 * Created by PhpStorm.
 * User: Dell 3521
 * Date: 17/05/15
 * Time: 06:13 م
 */

?>


<?php
/* @var $this IcdlController */
/* @var $model ICDLCard */
/* @var $form CActiveForm */
?>
<div class="panel panel-info">
    <div class="panel-heading">البحث في الامتحانات</div>
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
            <?php echo $form->label($model,'date',array('class'=>'col-md-2','for'=>'name')); ?>
            <div class="col-md-4">
                <?php echo $form->textField($model,'date',array('size'=>60,'maxlength'=>255,'id'=>'date-field','class'=>'form-control')); ?>
            </div>
        </div>
        <div class="form-group bootstrap-timepicker timepicker">
            <?php echo $form->label($model,'time',array('class'=>'col-md-2','for'=>'name')); ?>
            <div class="col-md-4">
                <?php echo $form->textField($model,'time',array('size'=>60,'maxlength'=>255,'id'=>'time-field','class'=>'form-control input-small')); ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-offset-2 col-md-4">
                <?php echo CHtml::submitButton('   فلترة   ',array(
                    'class'=>'btn btn-success',
                )); ?>
                <?php echo CHtml::button('   طباعة   ',array(
                    'class'=>'btn btn-warning',
                    'id'=>'print-btn',
                )); ?>
            </div>

        </div>

        <?php $this->endWidget(); ?>

    </div>

</div><!-- search-form -->