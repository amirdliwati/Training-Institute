<?php
/* @var $this CourseController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    array(
        'name'=>'الرئيسية',
        'url'=>$this->createUrl("site/index"),
    ),
    'الدورات',
);

$this->options=array(
    array('name'=>'إنشاء دورة جديدة', 'url'=>$this->createUrl('create'),'glyphicon'=>'glyphicon-file'),
);

?>

<h1>Courses</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
