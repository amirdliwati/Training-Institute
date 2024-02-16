<?php
/* @var $this IcdlController */
/* @var $model ICDLCard */

$this->breadcrumbs=array(
	'Icdlcards'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ICDLCard', 'url'=>array('index')),
	array('label'=>'Create ICDLCard', 'url'=>array('create')),
	array('label'=>'View ICDLCard', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ICDLCard', 'url'=>array('admin')),
);
?>

<h1>Update ICDLCard <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>