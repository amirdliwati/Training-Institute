<?php
/* @var $this CourseController */
/* @var $model Course */
$this->options = array(
    array('name' => 'العودة الى صفحة ادارة الدورات', 'url' => $this->createUrl('admin'), 'glyphicon' => 'glyphicon-share-alt'),
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>