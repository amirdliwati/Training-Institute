<?php
/* @var $this StudentController */
/* @var $studentModel Student */
/* @var $phoneNoModel PhoneNumber */

$this->options = array(
    array('name' => 'العودة الى صفحة ادارة الطلاب', 'url' => $this->createUrl('student/index'), 'active' => true, 'glyphicon' => 'glyphicon-share-alt'),

);

Yii::app()->clientScript->registerScript("course_script",'
$(function(){
    $(".ok-sign").hide();
    $(".error-sign").hide();
});
',CClientScript::POS_END);

?>
<br/>
<?php $this->renderPartial('_form', array(
    'studentModel'=>$studentModel,
    'phoneNoModel'=>$phoneNoModel,
    'registrationModel' => $registrationModel,
    'mobileNoModel' => $mobileNoModel,
    'phoneNoModelExtra' => $phoneNoModelExtra,
    'mobileNoModelExtra'=> $mobileNoModelExtra,
    'message'=>$message,
)); ?>

