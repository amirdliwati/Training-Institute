<?php
/* @var $this IcdlController */
/* @var $model ICDLCard */
$this->options = array(
    array('name' => 'صفحة ادارة البطاقات', 'url' => $this->createUrl('index'), 'glyphicon' => 'glyphicon-share-alt'),
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>