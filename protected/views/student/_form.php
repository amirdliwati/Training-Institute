<?php
/* @var $this StudentController */
/* @var $studentModel Student */
/* @var $phoneNoModel PhoneNumber */
/* @var $mobileNoModel PhoneNumber */
/* @var $form CActiveForm */
/* @var $registrationModel Registration */

if (Yii::app()->controller->action->id != 'create' && Yii::app()->controller->action->id != 'update') {
    CommonFunctions::fixAjax();
    Yii::app()->clientScript->registerScript("form-script", '
        $(".ok-sign").hide();
        $(".error-sign").hide();
    ', CClientScript::POS_END);
}

?>

<?php if (Yii::app()->controller->action->id == 'create' || Yii::app()->controller->action->id == 'update'): ?>

    <?php if (strlen($message) > 0): ?>

        <div class="alert alert-success alert-dismissable">
            <?php echo $message ?>
        </div>

    <?php endif; ?>

<?php endif; ?>

<br>

<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'student-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => false,
    'enableClientValidation' => true,
    'focus' => array($studentModel, 'first_name'),
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
<?php if ($studentModel->hasErrors()): ?>
    <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?php echo $form->errorSummary($studentModel, 'رجاء اصلح الأخطاء التالية:', $studentModel->isNewRecord ? 'بعد الإصلاح اضغط إنشاء' : 'بعد الإصلاح اضغط تعديل') ?>
    </div>
<?php endif; ?>

<div class="row">
<div class="col-md-6"><!-- right column container container -->
    <h4>المعلومات الشخصية</h4>
    <hr style="border-bottom:solid 1px #777;"/>
    <div class="form-group has-feedback">
        <?php echo $form->labelEx($studentModel, 'first_name', array('class' => 'col-md-4 control-label')); ?>
        <div class="col-md-8 input-container">
            <?php echo $form->textField($studentModel, 'first_name', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($studentModel, 'first_name'); ?>
        </div>
    </div>
    <div class="form-group has-feedback">
        <?php echo $form->labelEx($studentModel, 'father_name', array('class' => 'col-md-4 control-label')); ?>
        <div class="col-md-8 input-container">
            <?php echo $form->textField($studentModel, 'father_name', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($studentModel, 'father_name'); ?>
        </div>
    </div>
    <div class="form-group has-feedback">
        <?php echo $form->labelEx($studentModel, 'last_name', array('class' => 'col-md-4 control-label')); ?>
        <div class="col-md-8 input-container">
            <?php echo $form->textField($studentModel, 'last_name', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($studentModel, 'last_name'); ?>
        </div>
    </div>

    <div class="form-group has-feedback">
        <?php echo $form->labelEx($studentModel, 'mother_name', array('class' => 'col-md-4 control-label')); ?>
        <div class="col-md-8 input-container">
            <?php echo $form->textField($studentModel, 'mother_name', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($studentModel, 'mother_name'); ?>
        </div>
    </div>

    <div class="form-group has-feedback">
        <?php echo $form->labelEx($studentModel, 'DOB', array('class' => 'col-md-4 control-label')); ?>
        <div class="col-md-8 input-container">
            <?php echo $form->textField($studentModel, 'DOB', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($studentModel, 'DOB'); ?>
        </div>
    </div>
    <div class="form-group has-feedback">
        <?php echo $form->labelEx($studentModel, 'national_no', array('class' => 'col-md-4 control-label')); ?>
        <div class="col-md-8 input-container">
            <?php echo $form->textField($studentModel, 'national_no', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($studentModel, 'national_no'); ?>
        </div>
    </div>
    <div class="form-group has-feedback">
        <?php echo $form->labelEx($studentModel, 'nationality', array('class' => 'col-md-4 control-label')); ?>
        <div class="col-md-8 input-container">
            <?php echo $form->textField($studentModel, 'nationality', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($studentModel, 'nationality'); ?>
        </div>
    </div>
    <div class="form-group has-feedback">
        <?php echo $form->labelEx($studentModel, 'occupation', array('class' => 'col-md-4 control-label')); ?>
        <div class="col-md-8 input-container">
            <?php echo $form->textField($studentModel, 'occupation', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($studentModel, 'occupation'); ?>
        </div>
    </div>
    <div class="form-group has-feedback">
        <?php echo $form->labelEx($studentModel, 'qualification', array('class' => 'col-md-4 control-label')); ?>
        <div class="col-md-8 input-container">
            <?php echo $form->textField($studentModel, 'qualification', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($studentModel, 'qualification'); ?>
        </div>
    </div>
    <div class="form-group has-feedback">
        <?php echo $form->labelEx($studentModel, 'residency', array('class' => 'col-md-4 control-label')); ?>
        <div class="col-md-8 input-container">
            <?php echo $form->textField($studentModel, 'residency', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($studentModel, 'residency'); ?>
        </div>
    </div>
    <?php if (Yii::app()->controller->action->id == 'create' || Yii::app()->controller->action->id == 'update'): ?>

        <div class="form-group">
            <div class="col-md-12">
                <?php echo CHtml::submitButton($studentModel->isNewRecord ? 'تسجيل' : 'تعديل', array(
                    'class' => 'btn btn-danger form-control',
                )); ?>
            </div>
        </div>
    <?php endif; ?>

</div>
<!-- end of right column container -->

<div class="col-md-6">
    <h4>معلومات التواصل و التسجيل</h4>
    <hr style="border-bottom:solid 1px #777;"/>

    <div class="form-group has-feedback">
        <?php echo CHtml::label('الرقم الأرضي الأول', 'phone_no', array(
            'class' => 'col-md-4 control-label',
        )); ?>
        <div class="col-md-8 input-container">
            <?php echo $form->textField($phoneNoModel, '[1]number', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($phoneNoModel, '[1]number'); ?>
        </div>
    </div>

    <div class="form-group has-feedback">
        <?php echo CHtml::label('الرقم الأرضي الثاني', 'phone_no', array(
            'class' => 'col-md-4 control-label',
        )); ?>
        <div class="col-md-8 input-container">
            <?php echo $form->textField($phoneNoModelExtra, '[3]number', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($phoneNoModelExtra, '[3]number'); ?>
        </div>
    </div>

    <div class="form-group has-feedback">
        <?php echo CHtml::label('الرقم الخليوي الأول', 'phone_no', array(
            'class' => 'col-md-4 control-label',
        )); ?>
        <div class="col-md-8 input-container">
            <?php echo $form->textField($mobileNoModel, '[2]number', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($mobileNoModel, '[2]number'); ?>
        </div>
    </div>

    <div class="form-group has-feedback">
        <?php echo CHtml::label('الرقم الخليوي الثاني', 'phone_no', array(
            'class' => 'col-md-4 control-label',
        )); ?>
        <div class="col-md-8 input-container">
            <?php echo $form->textField($mobileNoModelExtra, '[4]number', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($mobileNoModelExtra, '[4]number'); ?>
        </div>
    </div>

    <div class="form-group has-feedback">
        <?php echo $form->labelEx($studentModel, 'how_to_know_us', array('class' => 'col-md-4 control-label')); ?>
        <div class="col-md-8 input-container">
            <?php echo $form->dropDownList($studentModel, 'how_to_know_us',
                array(
                    'عن طريق شبكة تواصل اجتماعي' => 'عن طريق شبكة تواصل اجتماعي',
                    'موقع المعهد على الإنترنت' => 'موقع المعهد على الإنترنت',
                    'عن طريق إعلان' => 'عن طريق إعلان',
                    'عن طريق صديق' => 'عن طريق صديق',
                    'عن طريق دعوة من قبل المعهد' => 'عن طريق دعوة من قبل المعهد',
                ), array('prompt' => 'كيف تعرفت الينا', 'class' => 'form-control')); ?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($studentModel, 'how_to_know_us'); ?>
        </div>
    </div>
    <?php if (Yii::app()->controller->action->id != 'create' && Yii::app()->controller->action->id != 'update'): ?>
        <hr style="border-bottom:solid 1px #777;"/>
        <div class="form-group has-feedback">
            <?php echo $form->labelEx($registration, 'initial_payment', array('class' => 'col-md-4 control-label')); ?>
            <div class="col-md-8 input-container">
                <?php echo $form->textField($registration, 'initial_payment', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
                <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
                <?php echo $form->error($registration, 'initial_payment'); ?>
            </div>
        </div>
        <div class="form-group has-feedback">
            <?php echo $form->labelEx($registration, 'initial_payment_num', array('class' => 'col-md-4 control-label')); ?>
            <div class="col-md-8 input-container">
                <?php echo $form->textField($registration, 'initial_payment_num', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
                <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
                <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
                <?php echo $form->error($registration, 'initial_payment_num'); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-8 col-md-offset-4">
                <?php echo CHtml::ajaxSubmitButton('اكمال البيانات', $this->createUrl('updateStudentInfo', array('id' => $studentModel->id,'cTId'=>$registration->course_type_id)),
                    array(
                        'type' => 'POST',
                        'success' => 'js:function(data){
                        $("#editStudentInfoModal").modal("hide");
                        if(data.status){
                            studentId = data.studentId;
                            vex.defaultOptions.className = "vex-theme-plain";
                            vex.dialog.alert(data.message);
                            $("#waiting-course-grid").yiiGridView("update");

                            $("#app_grid").yiiGridView("update");
                        }else{
                            vex.defaultOptions.className = "vex-theme-plain";
                            vex.dialog.alert(data.message);
                        }
                    }',
                        'dataType' => 'json',
                        'beforeSend' => 'js:function(xhr,setting){
                        $("#editStudentInfoModal .modal-body").html("الرجاء الانتظار...");
                    }'
                    )
                    , array(
                        'class' => 'btn btn-danger btn-block',
                        'id' => 'link-' . uniqid(),
                    )); ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($studentModel->isNewRecord): ?>
        <h4>معلومات التسجيل في الدورة</h4>
        <div class="alert alert-warning">
            <div class="form-group has-feedback">
                <?php echo $form->labelEx($registrationModel, 'course_type_id', array('class' => 'col-md-4 control-label')); ?>
                <div class="col-md-8 input-container">
                    <?php echo $form->dropDownList($registrationModel, 'course_type_id', CourseType::model()->getAvailableCourseTypes(), array('prompt' => 'اختر نوع الدورة', 'class' => 'form-control')); ?>
                    <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
                    <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
                    <?php echo $form->error($registrationModel, 'course_type_id'); ?>
                </div>
            </div>

            <div class="form-group has-feedback">
                <?php echo $form->labelEx($registrationModel, 'initial_payment', array('class' => 'col-md-4 control-label')); ?>
                <div class="col-md-8 input-container">
                    <?php echo $form->textField($registrationModel, 'initial_payment', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
                    <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
                    <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
                    <?php echo $form->error($registrationModel, 'initial_payment'); ?>
                </div>
            </div>
            <div class="form-group has-feedback">
                <?php echo $form->labelEx($registrationModel, 'initial_payment_num', array('class' => 'col-md-4 control-label')); ?>
                <div class="col-md-8 input-container">
                    <?php echo $form->textField($registrationModel, 'initial_payment_num', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
                    <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
                    <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
                    <?php echo $form->error($registrationModel, 'initial_payment_num'); ?>
                </div>
            </div>
            <div class="form-group has-feedback">
                <?php echo $form->labelEx($registrationModel, 'preferred_time', array('class' => 'col-md-4 control-label')); ?>
                <div class="col-md-8 input-container">
                    <?php echo $form->dropDownList($registrationModel, 'preferred_time', Registration::model()->getAvailableTimeSlots(), array('prompt' => 'اختر الوقت المناسب للدورة', 'class' => 'form-control')); ?>
                    <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
                    <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
                    <?php echo $form->error($registrationModel, 'preferred_time'); ?>
                </div>
            </div>
            <div class="form-group has-feedback">
                <?php echo $form->labelEx($registrationModel, 'note', array('class' => 'col-md-4 control-label')); ?>
                <div class="col-md-8 input-container">
                    <?php echo $form->textField($registrationModel, 'note', array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
                    <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
                    <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
                    <?php echo $form->error($registrationModel, 'note'); ?>
                </div>
            </div>
        </div>
    <?php endif; ?>


</div>

</div>





<?php $this->endWidget(); ?>

</div>
<!-- form -->