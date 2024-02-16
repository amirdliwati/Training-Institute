<?php
/* @var $this DamascusListEntryController */
/* @var $model DamascusListEntry */

$this->breadcrumbs=array(
	'Damascus List Entries'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List DamascusListEntry', 'url'=>array('index')),
	array('label'=>'Create DamascusListEntry', 'url'=>array('create')),
	array('label'=>'View DamascusListEntry', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage DamascusListEntry', 'url'=>array('admin')),
);
?>

<h1>Update DamascusListEntry <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>