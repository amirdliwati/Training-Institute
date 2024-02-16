<?php
/* @var $this InstructorController */
/* @var $model Instructor */


$this->options = array(
    array('name' => 'العودة الى صفحة ادارة المدرسين', 'url' => $this->createUrl('instructor/admin'), 'active' => true, 'glyphicon' => 'glyphicon-share-alt'),

);

Yii::app()->clientScript->registerScript("course_script",'
$(function(){
    $(".ok-sign").hide();
    $(".error-sign").hide();
});
',CClientScript::POS_END);

?>
<hr/>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>