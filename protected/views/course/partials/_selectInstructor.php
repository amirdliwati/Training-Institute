<?php
Yii::app()->clientScript->registerScript('search-instructor', "
 $('.ok-sign').hide();
 $('.error-sign').hide();

$('.search-form form').submit(function(){
	$('#instructor-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
$('.Tabled table').addClass('table');
$('.Tabled table').addClass('subtable');
",CClientScript::POS_END);
?>

<div class="panel panel-info search-form">
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
        <div class="form-group has-feedback">
            <?php echo $form->labelEx($model, 'first_name', array('class' => 'col-md-2 control-label')); ?>
            <div class="col-md-10 input-container">
                <?php echo $form->textField($model, 'first_name', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
                <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
                <?php echo $form->error($model, 'first_name'); ?>
            </div>
        </div>

        <div class="form-group has-feedback">
            <?php echo $form->labelEx($model, 'last_name', array('class' => 'col-md-2 control-label')); ?>
            <div class="col-md-10">
                <?php echo $form->textField($model, 'last_name', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
                <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
                <?php echo $form->error($model, 'last_name'); ?>
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
<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'instructor-grid',
    'summaryText' => '',

    'afterAjaxUpdate' => 'js:function(){
        	$(".Tabled table").addClass("table");
            $(".Tabled table").addClass("subtable");
     }',
    'htmlOptions' => array(
        'class' => 'Tabled',
    ),
    'cssFile' => Yii::app()->baseUrl . '/css/main.css',
    'dataProvider' => $model->search(),

    'columns' => array(
        array(
            'name' => 'first_name',
            'filter' => array(),
        ),
        'last_name',
        'mobile',
        'tel',
        array(
            'class' => 'CButtonColumn',
            'template' => ' {instructor} ',
            'buttons' => array(
                'instructor' => array(
                    'url' => 'Yii::app()->createUrl("course/setInstructor",array("id"=>$data->id))',
                    'label' => '<span class="glyphicon glyphicon-user" style="color: #EEEEEE;"></span>',
                    'options' => array(
                        'class' => 'btn btn-primary tooltip-btn',
                        'data-toggle' => 'tooltip',
                        'data-placement' => 'left',
                        'title' => 'اختر المدرس',
                        'ajax' => array(
                            'type' => 'POST',
                            'dataType' => 'json',
                            'url' => 'js:$(this).attr("href")',
                            'success' => 'js:function(data){
                                var instructor_id = data.instructor_id+"";
                                var instructor_name = data.instructor_name+"";
                                $("#instructor_id").val(instructor_id);
                                $("#instructor_name").html(instructor_name);
                                $("#selectInstructorModal").modal("hide");
                            }'
                        ),
                    ),
                )
            ),
        ),
    ),
));
?>