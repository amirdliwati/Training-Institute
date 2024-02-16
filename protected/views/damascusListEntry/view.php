<?php
/* @var $this DamascusListEntryController */
/* @var $model DamascusListEntry */

$this->breadcrumbs=array(
	'Damascus List Entries'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List DamascusListEntry', 'url'=>array('index')),
	array('label'=>'Create DamascusListEntry', 'url'=>array('create')),
	array('label'=>'Update DamascusListEntry', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete DamascusListEntry', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage DamascusListEntry', 'url'=>array('admin')),
);
?>

<h1>View DamascusListEntry #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'damascus_list_id',
		'course_id',
		'student_id',
	),
)); ?>
