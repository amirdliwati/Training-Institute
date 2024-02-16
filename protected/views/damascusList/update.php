<?php
/* @var $this DamascusListController */
/* @var $model DamascusList */

$this->breadcrumbs=array(
	'Damascus Lists'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List DamascusList', 'url'=>array('index')),
	array('label'=>'Create DamascusList', 'url'=>array('create')),
	array('label'=>'View DamascusList', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage DamascusList', 'url'=>array('admin')),
);
?>

<h1>Update DamascusList <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>