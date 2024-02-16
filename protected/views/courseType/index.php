<?php
/* @var $this CourseTypeController */
/* @var $dataProvider CActiveDataProvider */

?>

<h1>Course Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
