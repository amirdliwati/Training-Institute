<?php
/**
 * Created by PhpStorm.
 * User: Dell 3521
 * Date: 16/05/14
 * Time: 11:47 م
 */
Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl . '/css/animate.css');
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/vendor/vex.js", CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/vendor/vex.dialog.js", CClientScript::POS_END);
Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl . "/css/vex/vex.css");
Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl . "/css/vex/vex-theme-plain.css");


Yii::app()->clientScript->registerScript("script", '
    $(function(){
        var availableCoursesUrl = ' . CJavaScript::encode($this->createUrl("course/courses")) . ';

        $(".course_type_id_drop_down").change(function(){
            $(".available-courses").addClass("animated");
            $(".available-courses").addClass("bounceOutDown");

            $.ajax({
                "type":"GET",
                "url": availableCoursesUrl,
                "data":{
                    "course_type_id": $(this).val()
                },
                "success":function(data, status, xhr){
                    $(".available-courses").html(data);
                    $(".available-courses").removeClass("bounceOutDown");
                    $(".available-courses").addClass("bounceInDown");
                }
            });
            return false;
        });
    })', CClientScript::POS_END);
?>
<br/>
<div class="assign-form">
    <?php echo CHtml::beginForm($this->createUrl('assign',array('id'=>$model->id)), 'POST', array(
        'class' => 'form-horizontal',
        'role' => 'form',
    ))?>

    <?php echo CHtml::hiddenField('instructor_id', $model->id) ?>

    <div class="form-group has-feedback">
        <?php echo Chtml::label('اختر أحد الدورات','course_type_id',array('class'=>'control-label col-md-2')) ?>
        <div class="col-md-10">
            <?php echo CHtml::dropDownList('course_type_id', '', CourseType::model()->getAvailableCourseTypes(), array(
                'class' => 'course_type_id_drop_down form-control',
            ));?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?php echo CHtml::submitButton('تعيين', array(
                'class' => 'btn btn-success',
            )); ?>
        </div>
        <div class="available-courses col-md-6 height-transition">

        </div>

    </div>
    <?php echo CHtml::endForm(); ?>
</div>