<?php
/* @var $this IcdlController */
/* @var $model ICDLCard */

$this->breadcrumbs=array(
	'Icdlcards'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ICDLCard', 'url'=>array('index')),
	array('label'=>'Create ICDLCard', 'url'=>array('create')),
	array('label'=>'Update ICDLCard', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ICDLCard', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ICDLCard', 'url'=>array('admin')),
);
?>

<h1>View ICDLCard #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'first_name_en',
		'last_name_en',
		'un_code',
		'payment',
		'lang',
		'status',
		'student_id',
	),
)); ?>
