<?php
/* @var $this InstructorController */
/* @var $model Instructor */

$this->breadcrumbs=array(
	'Instructors'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);
$this->options = array(
    array('name' => 'العودة الى صفحة ادارة المدرسين', 'url' => $this->createUrl('instructor/admin'), 'active' => true, 'glyphicon' => 'glyphicon-share-alt'),

);

Yii::app()->clientScript->registerScript("course_script",'
$(function(){
    $(".ok-sign").hide();
    $(".error-sign").hide();
});
',CClientScript::POS_END);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>