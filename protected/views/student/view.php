<?php
/* @var $this StudentController */
/* @var $model Student */
/* @var  $courseDataProvider CActiveDataProvider */
$this->breadcrumbs = array(
    array(
        'name' => 'الرئيسية',
        'url' => $this->createUrl("site/index"),
    ),
    array(
        'name' => 'الطلاب',
        'url' => $this->createUrl("student/index"),
    ),
    $model->first_name . " " . $model->father_name . " " . $model->last_name,
);
$this->options = array(
    array('name' => 'العودة الى صفحة ادارة الطلاب', 'url' => $this->createUrl('student/index'), 'active' => true, 'glyphicon' => 'glyphicon-share-alt'),
    array('name' => 'تعديل سجل الطالب', 'url' => $this->createUrl('update', array('id' => $model->id)), 'glyphicon' => 'glyphicon-pencil'),
    array('name' => 'تسجيل الطالب في لائحة انتظار', 'url' => "#",'id'=>'registerForWaitLink', 'glyphicon' => 'glyphicon-pushpin'),
);

if($model->isDeletable()){
    $this->options[] = array('name' => 'حذف الطالب من النظام', 'url' => $this->createUrl('student/delete',array('id'=>$model->id)), 'active' => true, 'glyphicon' => 'glyphicon-trash');
}

$this->widget('application.components.Ajaxmodal', array(
    'name' => 'studentOptionsModal',
    'title' => 'خيارات الطالب ضمن الدورة',
    'width' => '600px',
));
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/vendor/vex.js", CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/vendor/vex.dialog.js", CClientScript::POS_END);

Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl . "/css/vex/vex.css");
Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl . "/css/vex/vex-theme-plain.css");


Yii::app()->clientScript->registerScript("register-for-wait",'
$(function(){
    $("#registerForWaitLink").click(function(event){
        $.ajax({
            "url":"'.$this->createUrl('getRegisterForWaitForm',array('sId'=>$model->id)).'",
            "type":"GET",
            "success":function(data){
                $("#registerForWaitModal .modal-body").html(data);

            },
            "beforeSend":function(){
                $("#registerForWaitModal .modal-body").html("الرجاء الانتظار...");
                $("#registerForWaitModal").modal("show");
            }
        });
    });
});
',CClientScript::POS_END);

$this->widget('application.components.Ajaxmodal', array(
    'name' => 'registerForWaitModal',
    'title' => 'تسجيل الطالب في لائحة انتظار',
    'width' => '800px',
));

$this->widget('application.components.Ajaxmodal', array(
    'name' => 'registrationOptionsModal',
    'title' => 'خيارات الانتظار',
    'width' => '600px',
));

$this->widget('application.components.Ajaxmodal', array(
    'name' => 'courseOptionsModal',
    'title' => 'خيارات الطالب في الدورة',
    'width' => '600px',
));

$this->widget('application.components.Ajaxmodal', array(
    'name' => 'editStudentAssessmentModal',
    'title' => 'تعديل تقييم الطالب',
    'width' => '600px',
));


$this->widget('application.components.Ajaxmodal', array(
    'name' => 'addPaymentModal',
    'title' => 'إضافة فاتورة',
    'width' => '600px',
));
$this->widget('application.components.Ajaxmodal', array(
    'name' => 'payModal',
    'title' => 'دفع فاتورة',
    'width' => '70',
));
?>

<br/>
<ul class="nav nav-tabs" id="myTab">
    <li class="active"><a href="#profile" id="profile-tab" data-toggle="tab">معلومات الطالب الاساسية</a></li>
    <li><a href="#student_courses" data-toggle="tab" id="students-tab">دورات الطالب الحالية</a></li>
    <li><a href="#student_waiting_list" data-toggle="tab" id="students-tab">دورات الطالب المنتظرة</a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane fade in active" id="profile">
        <?php $this->renderPartial('partials/_details', array(
            'model' => $model,
        ))?>
    </div>
    <div class="tab-pane fade" id="student_courses">
        <?php

        $this->renderPartial('partials/_course-list', array(
            'model' => $model,
            'courseDataProvider' => $courseDataProvider,
        ));

        ?>
    </div>
    <div class="tab-pane fade" id="student_waiting_list">
        <?php

        $this->renderPartial('partials/_onWaitRegistrations-list', array(
            'model' => $model,
            'onWaitRegistrations' => $onWaitRegistrations,
        ));

        ?>
    </div>
</div>
