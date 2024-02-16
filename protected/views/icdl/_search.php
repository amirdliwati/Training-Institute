<?php
/* @var $this IcdlController */
/* @var $model ICDLCard */
/* @var $form CActiveForm */
?>
<div class="panel panel-info">
    <div class="panel-heading">البحث في بطاقات ال ICDL</div>
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
            <?php echo $form->label($model,'first_name_en',array('class'=>'col-md-3','for'=>'name')); ?>
            <div class="col-md-3">
                <?php echo $form->textField($model,'first_name_en',array('size'=>60,'maxlength'=>255,'id'=>'name','class'=>'form-control')); ?>
            </div>
            <?php echo $form->label($model,'last_name_en',array('class'=>'col-md-3','for'=>'name')); ?>
            <div class="col-md-3">
                <?php echo $form->textField($model,'last_name_en',array('size'=>60,'maxlength'=>255,'id'=>'name','class'=>'form-control')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo $form->label($model,'first_name',array('class'=>'col-md-3','for'=>'name')); ?>
            <div class="col-md-3">
                <?php echo $form->textField($model,'first_name',array('size'=>60,'maxlength'=>255,'id'=>'name','class'=>'form-control')); ?>
            </div>
            <?php echo $form->label($model,'last_name',array('class'=>'col-md-3','for'=>'name')); ?>
            <div class="col-md-3">
                <?php echo $form->textField($model,'last_name',array('size'=>60,'maxlength'=>255,'id'=>'name','class'=>'form-control')); ?>
            </div>
        </div>

        <div class="form-group">
            <?php echo $form->label($model,'un_code',array('class'=>'col-md-3','for'=>'name')); ?>
            <div class="col-md-3">
                <?php echo $form->textField($model,'un_code',array('size'=>60,'maxlength'=>255,'id'=>'name','class'=>'form-control')); ?>
            </div>
            <?php echo $form->label($model,'father_name',array('class'=>'col-md-3','for'=>'name')); ?>
            <div class="col-md-3">
                <?php echo $form->textField($model,'father_name',array('size'=>60,'maxlength'=>255,'id'=>'name','class'=>'form-control')); ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo $form->label($model,'payment',array('class'=>'col-md-3','for'=>'name')); ?>
            <div class="col-md-3">
                <?php echo $form->textField($model,'payment',array('size'=>60,'maxlength'=>255,'id'=>'name','class'=>'form-control')); ?>
            </div>

        </div>


        <div class="form-group">
            <div class="col-md-offset-3 col-md-4">
                <?php echo CHtml::submitButton('   بحث   ',array(
                    'class'=>'btn btn-success',
                )); ?>
            </div>
        </div>

        <?php $this->endWidget(); ?>

    </div>

</div><!-- search-form -->