<?php
/* @var $this DamascusListController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Damascus Lists',
);

$this->menu=array(
	array('label'=>'Create DamascusList', 'url'=>array('create')),
	array('label'=>'Manage DamascusList', 'url'=>array('admin')),
);
?>

<h1>Damascus Lists</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
