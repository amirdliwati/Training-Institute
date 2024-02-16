<?php
echo CHtml::hiddenField('course_id',$model->id);
echo CHtml::dropDownList('status',0,$model->getAvailableCourseStatus(),array('class'=>'form-control'));
?>