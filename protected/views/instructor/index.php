<?php
/* @var $this InstructorController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Instructors',
);

$this->menu=array(
	array('label'=>'Create Instructor', 'url'=>array('create')),
	array('label'=>'Manage Instructor', 'url'=>array('admin')),
);
?>

<h1>Instructors</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
