<?php
/* @var $this InstructorController */
/* @var $model Instructor */

$this->breadcrumbs=array(
	'Instructors'=>array('index'),
	$model->id,
);


$this->options = array(
    array('name' => 'العودة الى صفحة ادارة المدرسين', 'url' => $this->createUrl('instructor/admin'), 'active' => true, 'glyphicon' => 'glyphicon-share-alt'),
);

if($model->isDeletable()){
    $this->options[] = array('name' => 'حذف الاستاذ من النظام', 'url' => $this->createUrl('instructor/delete',array('id'=>$model->id)), 'active' => true, 'glyphicon' => 'glyphicon-trash');
}

Yii::app()->clientScript->registerScript('instructor-view','
var hidden = true;
$("#teaching-details").hide();
$("#toggleDetails").click(function(){
    if(!hidden){
        $("#teaching-details").slideUp(400);
        hidden = true;
    }else{
        $("#teaching-details").slideDown(400);
        hidden = false;
    }
});

');
?>
<h4>المعلومات الشخصية</h4>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'first_name',
		'last_name',
		'tel',
		'mobile',
		'added_date',
		'note',
	),
)); ?>
<br/>
<?php echo CHtml::link("اخفاء/اظهار تفاصيل التدريس","#",array(
    'id'=>'toggleDetails',
))?>
<br/>
<b><?php echo CHtml::encode("عدد الدورات التي درسها"); ?>:</b>
<?php echo CHtml::encode($model->courseNo); ?>
<br />
<div id="teaching-details">
<?php if(!empty($currentCourses)):?>
<?php echo $this->renderPartial('available_courses',array(
    'courses'=>$currentCourses,
))?>
<?php endif;?>
</div>
