<?php
/* @var $this StudentController */
/* @var $model Student */

$this->options = array(
    array('name' => 'العودة الى صفحة ادارة الطلاب', 'url' => $this->createUrl('student/index'), 'active' => true, 'glyphicon' => 'glyphicon-share-alt'),
    array('name' => 'العودة الى صفحة الطالب', 'url' => $this->createUrl('student/view', array('id' => $model->id)), 'active' => true, 'glyphicon' => 'glyphicon-user'),

);

Yii::app()->clientScript->registerScript("course_script", '
$(function(){
    $(".ok-sign").hide();
    $(".error-sign").hide();
});
', CClientScript::POS_END);

?>
    <br/>
<?php $this->renderPartial('_form', array('studentModel' => $model, 'phoneNoModel' => $phoneNoModel, 'mobileNoModel' => $mobileNoModel, 'phoneNoModelExtra' => $phoneNoModelExtra,
    'mobileNoModelExtra' => $mobileNoModelExtra, 'message' => $message)); ?>