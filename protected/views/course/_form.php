<?php
/* @var $this CourseController */
/* @var $model Course */
/* @var $form CActiveForm */

CommonFunctions::fixAjax();
if ($model->isNewRecord) {
    Yii::app()->clientScript->registerScript("course_script", '
$(function(){
    $(".ok-sign").hide();
    $(".error-sign").hide();
    $(".Tabled table").addClass("table");
    $(".Tabled table").addClass("subtable");
    $("#createCourseButton").click(function( event ){
        var courseCost = $(".course_cost_form").val();
        if(courseCost == 0){
            courseCost= "لم يتم ادخال بيانات مالية للدورة";
        }
        var instructorName = $("#instructor_name").html();
        if(instructorName ==""){
            instructorName="لم يتم ادخال استاذ الى اعدادات الدورة";
        }
        $("#course_instructor_confirm_field").html(instructorName);
        $("#course_cost_confirm_field").html(courseCost);
        $("#confirmCreateCourseModal").modal("show");
    });
});
', CClientScript::POS_END);

}
if ($model->isNewRecord) {

    $this->widget('application.components.Modal', array(
        'model' => $instructorModel,
        'form' => 'course.partials._selectInstructor',
        'modalName' => 'selectInstructorModal',
        'title' => 'اختر استاذ للدورة',
    ));
}

?>

<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'course-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'focus' => array($model, 'course_type_id'),
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

<div class="alert alert-info">
    <p class="note">الحقول بعلامة <span class="required">*</span> هي حقول مطلوبة</p>
</div>

<?php if ($model->hasErrors()): ?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $form->errorSummary($model, 'رجاء اصلح الأخطاء التالية:', $model->isNewRecord ? 'بعد الإصلاح اضغط إنشاء' : 'بعد الإصلاح اضغط تعديل') ?>
    </div>
<?php endif; ?>
<?php if ($model->isNewRecord == false): ?>
    <table class="table subtable">
        <tr>
            <td><?php echo $model->getAttributeLabel("course_type_id") ?></td>
            <td><?php echo $model->getCourseNameText(); ?></td>
        </tr>
        <?php if(!$model->isCostEditable()):?>
        <tr>
            <td><?php echo $model->getAttributeLabel("cost") ?></td>
            <td><?php echo $model->getCostText() ?></td>
        </tr>
        <?php endif;?>
    </table>
<?php endif; ?>
<?php if ($model->isNewRecord): ?>
    <div class="form-group has-feedback">
        <?php echo $form->labelEx($model, 'course_type_id', array('class' => 'col-md-3 control-label')); ?>
        <div class="col-md-9 input-container">
            <?php echo $form->dropDownList($model, 'course_type_id', CourseType::model()->getAvailableCourseTypes(), array('prompt' => 'اختر نوع الدورة', 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($model, 'course_type_id'); ?>
        </div>
    </div>
<?php endif; ?>
<?php if ($model->isNewRecord || $model->isCostEditable()): ?>
    <div class="form-group has-feedback">
        <?php echo $form->labelEx($model, 'cost', array('class' => 'col-md-3 control-label')); ?>
        <div class="col-md-9 input-container">
            <?php echo $form->textField($model, 'cost', array('size' => 60, 'maxlength' => 255,'class' => 'course_cost_form form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($model, 'cost'); ?>
        </div>
    </div>
<?php endif; ?>
<div class="form-group has-feedback">
    <?php echo $form->labelEx($model, 'start_date', array('class' => 'col-md-3 control-label')); ?>
    <div class="col-md-9 input-container">
        <?php echo $form->textField($model, 'start_date', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
        <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
        <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
        <?php echo $form->error($model, 'start_date'); ?>
    </div>
</div>
<div class="form-group has-feedback">
    <?php echo $form->labelEx($model, 'end_date', array('class' => 'col-md-3 control-label')); ?>
    <div class="col-md-9 input-container">
        <?php echo $form->textField($model, 'end_date', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
        <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
        <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
        <?php echo $form->error($model, 'end_date'); ?>
    </div>
</div>

<div class="form-group has-feedback">
    <?php echo $form->labelEx($model, 'note', array('class' => 'col-md-3 control-label')); ?>
    <div class="col-md-9 input-container">
        <?php echo $form->textArea($model, 'note', array('col' => 400, 'row' => 8)); ?>
        <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
        <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
        <?php echo $form->error($model, 'note'); ?>
    </div>
</div>

<div class="form-group has-feedback">
    <?php echo $form->labelEx($model, 'instructor_id', array('class' => 'col-md-3 control-label')); ?>
    <div class="col-md-3 input-container">
        <?php if ($model->isNewRecord): ?>
            <?php echo CHtml::link('اختر مدرس للدورة', '#selectInstructorModal', array('class' => 'btn btn-primary', 'data-toggle' => 'modal', 'data-target' => '#selectInstructorModal')) ?>
        <?php endif; ?>
        <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
        <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
        <?php echo $form->hiddenField($model, 'instructor_id', array('id' => 'instructor_id')) ?>
        <?php echo $form->error($model, 'instructor_id'); ?>
    </div>
    <div class="col-md-3 input-container">
        <?php if (!isset($model->instructor_id) || $model->instructor_id == 0): ?>
            <div><span class="label label-success" id="instructor_name"></span></div>
        <?php endif; ?>
        <?php if (isset($model->instructor_id) && $model->instructor_id > 0): ?>
            <div><span class="label label-success">
                        <?php
                        echo $model->instructor->first_name . " " . $model->instructor->last_name;
                        ?>
                </span></div>
        <?php endif; ?>
    </div>
</div>


<div class="form-group has-feedback">
    <?php echo $form->labelEx($model, 'status', array('class' => 'col-md-3 control-label')); ?>
    <div class="col-md-9 input-container">
        <?php echo $form->dropDownList($model, 'status', Course::model()->getAvailableCourseStatus(), array('prompt' => 'اختر حالة الدورة', 'class' => 'form-control')); ?>
        <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
        <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
        <?php echo $form->error($model, 'course_type_id'); ?>
    </div>
</div>
<?php if ($model->isNewRecord): ?>

    <!-- Boostrap modal dialog -->
    <div style="z-index:99999;overflow: visible;" class="modal fade" id="confirmCreateCourseModal" tabindex="-1"
         role="dialog" aria-labelledby="updateActionLabel" aria-hidden="true" style="display:none;">
        <div class="modal-dialog" style="width: 600px;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">هل انت متأكد من انك تريد انشاء الدورة التالية؟</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <span>قسط الدورة:</span>
                        </div>
                        <div class="col-sm-9">
                            <span id="course_cost_confirm_field"></span>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-sm-3">
                            <span>استاذ الدورة:</span>
                        </div>
                        <div class="col-sm-9">
                            <span id="course_instructor_confirm_field"></span>
                        </div>
                    </div>
                    <br/>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <?php echo CHtml::submitButton('إنشاء الدورة', array(
                                'class' => 'btn btn-success',
                            )); ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            <?php echo CHtml::button('إنشاء', array(
                'class' => 'btn btn-success',
                'id' => 'createCourseButton',
            )); ?>
        </div>
    </div>
<?php endif; ?>

<?php if (!$model->isNewRecord): ?>
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            <?php echo CHtml::ajaxSubmitButton("تعديل", $this->createUrl('update', array('id' => $model->id)), array(
                'type' => "POST",
                'dataType' => 'json',
                'success' => 'js:function(data,status,xhr){
                        if(data.success){
                            $("#updateCourseFormModal").modal("hide");
                            $("#course-grid").yiiGridView("update");
                            courseViewUpdate();
                        }else{
                            alert("حصل خطأ!");
                        };
                    }',
                'beforeSend' => 'js:function(setting,xhr){
                        $("#updateCourseFormModal .modal-body").html("الرجاء الانتظار ...");
                    }'
            ), array(
                'class' => 'btn btn-success',
                'id' => 'link-' . uniqid(),
            )); ?>
        </div>
    </div>
<?php endif; ?>
<?php $this->endWidget(); ?>

</div><!-- form -->