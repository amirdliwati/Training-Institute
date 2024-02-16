<?php
/**
 * @var $model Course
 * @var $this CourseController
 *
 */

$this->options = array(
    array('name' => 'ادارة الدورات', 'url' => $this->createUrl('course/admin'), 'glyphicon' => 'glyphicon-share-alt'),
    array('name' => 'لوائح الانتظار', 'url' => $this->createUrl('student/waitingList'), 'glyphicon' => 'glyphicon-share-alt'),
);

?>

<br/>
<div class="row">
    <div class="col-md-12">
        <div class=" alert alert-danger">
            <p>هل أنت متأكد من رغبتك في حذف الدورة التالية:</p>

            <p><?php echo $model->courseType->name." ".$model->start_date." -> ".$model->end_date; ?></p>

            <p>لن تعود قادرا على استرجاع اي من بيانات الدورة بما في ذلك بيانات الطلاب المتعلقة بالحضور او مالية
                الدورة</p>
        </div>

    </div>
</div>
<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'course-delete-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'successCssClass' => 'has-success',
            'errorCssClass' => 'has-error',
            'validatingErrorMessage' => '',
            'inputContainer' => '.form-group',
            'afterValidateAttribute' => 'js:function(form, attribute, data, hasError){
                $("#"+attribute.inputID).siblings(".error-sign").hide();
                $("#"+attribute.inputID).siblings(".ok-sign").hide();
                if(hasError){
                    $("#"+attribute.inputID).siblings(".error-sign").show();
                }else {
                    $("#"+attribute.inputID).siblings(".ok-sign").show();
                }
            }',
        ),
        'htmlOptions' => array(
            'role' => 'form',
            'class' => 'form-horizontal',
        ),
    )); ?>
    <?php echo $form->hiddenField($model, 'id'); ?>

    <div class="row">
        <div class="col-md-12"><!-- right column container container -->
            <div class="form-group">
                <div class="col-md-4">
                    <?php echo CHtml::submitButton('حذف الدورة', array(
                        'class' => 'btn btn-danger form-control',
                    )); ?>
                </div>
            </div>
        </div>
    </div>





    <?php $this->endWidget(); ?>

</div><!-- form -->