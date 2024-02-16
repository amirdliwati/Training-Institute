<?php
/* @var $this DamascusListEntryController */
/* @var $model DamascusListEntry */

$this->breadcrumbs=array(
	'Damascus List Entries'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List DamascusListEntry', 'url'=>array('index')),
	array('label'=>'Manage DamascusListEntry', 'url'=>array('admin')),
);
?>

<h1>Create DamascusListEntry</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>