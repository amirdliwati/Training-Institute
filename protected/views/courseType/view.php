<?php
/* @var $this CourseTypeController */
/* @var $model CourseType */

?>

<h1>View CourseType #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'description',
	),
));
?><br/><?php
foreach($model->students as $student){
    echo $student->first_name;
}

?>
