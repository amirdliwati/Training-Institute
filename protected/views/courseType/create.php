<?php
/* @var $this CourseTypeController */
/* @var $model CourseType */

$this->pageTitle = 'إنشاء نوع دورة جديد';

$this->options = array(
    array('name' => 'العودة الى صفحة ادارة انواع الدورات', 'url' => $this->createUrl('admin'), 'id' => 'search-button', 'glyphicon' => 'glyphicon-share-alt'),

);

Yii::app()->clientScript->registerScript("course_script",'
$(function(){
    $(".ok-sign").hide();
    $(".error-sign").hide();
});
',CClientScript::POS_END);
?>


<?php $this->renderPartial('_form', array('model'=>$model)); ?>