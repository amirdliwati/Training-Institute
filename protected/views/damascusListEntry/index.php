<?php
/* @var $this DamascusListEntryController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Damascus List Entries',
);

$this->menu=array(
	array('label'=>'Create DamascusListEntry', 'url'=>array('create')),
	array('label'=>'Manage DamascusListEntry', 'url'=>array('admin')),
);
?>

<h1>Damascus List Entries</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
