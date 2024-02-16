<?php
/* @var $this CourseController */
/* @var $model Course */

$this->options = array(
    array('name' => 'عرض سجل حضور الدورة', 'url' => $this->createUrl('view', array('id' => $model->id)), 'active' => true, 'glyphicon' => 'glyphicon-file'),
    array('name' => 'تعديل بيانات الدورة', 'url' => "#", 'id' => 'updateCourse', 'glyphicon' => 'glyphicon-pencil'),
    array('name' => 'عرض معلومات الاتصال للطباعة', 'url' => Yii::app()->createUrl('course/viewStudentContactInfo',array('cId'=>$model->id)), 'glyphicon' => 'glyphicon-print'),

    array('name' => 'العودة الى لوحة ادارة الدورات', 'url' => $this->createUrl('admin'), 'glyphicon' => 'glyphicon-share-alt'),
    array('name' => 'حذف الدورة', 'url' => $this->createUrl('delete',array('id'=>$model->id)), 'glyphicon' => 'glyphicon-trash'),
);

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/jquery.ba-bbq.min.js", CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/vendor/vex.js", CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/vendor/vex.dialog.js", CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/main.js", CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/course/_course.js", CClientScript::POS_END);

Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl . "/css/vex/vex.css");
Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl . "/css/vex/vex-theme-plain.css");
Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl . "/css/vex/vex-theme-flat-attack.css");

// JS Code
Yii::app()->clientScript->registerScript("course_script_view", '
var courseScope = {
    statusCode: ' . CJSON::encode($model->getAvailableCourseStatus()) . '
};
var updateCount = 0;
var transferStudentUrl = "' . $this->createUrl('transferStudents') . '";
var showStudentContactUrl = "' . $this->createUrl('showStudentContact') . '";
var courseInfo = {
    "id":' . CJavaScript::encode($model->id) . ',
    "name":' . CJavaScript::encode($model->courseType->name) . ',
    "description":' . CJavaScript::encode($model->courseType->getDescriptionText()) . ',
    "alterCourseStatusUrl":' . CJavaScript::encode($this->createUrl('course/alterCourseStatus')) . ',
    "startDate":' . CJavaScript::encode($model->start_date) . ',
    "endDate":' . CJavaScript::encode($model->end_date) . ',
    "cost":' . CJavaScript::encode($model->getCostText()) . ',
    "status":' . CJavaScript::encode($model->getStatusText()) . ',
    "note":' . CJavaScript::encode($model->getNoteText()) . ',
    "courseUpdateViewLink":' . CJavaScript::encode($this->createUrl('course/courseUpdate', array("id" => $model->id))) . ',
    "courseUpdateLink":' . CJavaScript::encode($this->createUrl('course/callUpdate', array("id" => $model->id))) . ',
    "isStudentListAvailable":"true"
};

var statusDropDownList = ' . CJavaScript::encode($this->renderPartial("partials/update-course-status-vex-form", array("model" => $model), true)) . ';
', CClientScript::POS_END);

if (empty($students)) {
    Yii::app()->clientScript->registerScript("No Students", '
courseInfo.isStudentListAvailable = false;
', CClientScript::POS_END);
}


Yii::app()->clientScript->registerScript("course_view_update", '
courseViewUpdate();
$("#transfer_button").click(function(){

    var course_id = ' . CJavaScript::encode($model->id) . ';
    var studentId = [];
    var damascus_list_no = $("#damascus_list_no").val();
    $(".student_select input:checked").each(function(){
        studentId.push($(this).val());
    });
    studentId = studentId.join(",");
            $.ajax({
                url:transferStudentUrl,
                type:"POST",
                dataType:"json",
                data:{"course_id":course_id,"student_id":studentId,"damascus_list_no":damascus_list_no},
                success:function(data,status,xhr){
                    $("#pleaseWaitModal").modal("hide");
                    if(data.status){
                        vex.defaultOptions.className = "vex-theme-plain";
                        vex.dialog.alert(data.message);
                        $("#student-course-grid").yiiGridView("update");
                    }else{
                        vex.defaultOptions.className = "vex-theme-plain";
                        vex.dialog.alert(data.message);
                    }
                },
                beforeSend:function(){
                    $("#pleaseWaitModal .modal-body").html("الرجاء الانتظار");
                    $("#pleaseWaitModal").modal("show");
                }
            });
});

$("#view_contact_button").click(function(){

    var course_id = ' . CJavaScript::encode($model->id) . ';
    var studentId = [];
    $(".student_select input:checked").each(function(){
        studentId.push($(this).val());
    });
    studentId = studentId.join(",");
            $.ajax({
                url:showStudentContactUrl,
                type:"GET",
                data:{"course_id":course_id,"student_ids":studentId},
                success:function(data,status,xhr){
                    $("#viewStudentContactInfo .modal-body").html(data);
                },
                beforeSend:function(){
                    $("#viewStudentContactInfo .modal-body").html(" الرجاء الانتظار...");
                    $("#viewStudentContactInfo").modal("show");
                },
                error: function(){
                 $("#viewStudentContactInfo .modal-body").html("تأكد من اختيار طلاب في الدورة");
                }
            });

});


', CClientScript::POS_END);


$this->widget('application.components.Ajaxmodal', array(
    'name' => 'updateCourseFormModal',
    'title' => 'تعديل بيانات دورة ' . $model->courseType->name,
));


$this->widget('application.components.Ajaxmodal', array(
    'name' => 'viewStudentContactInfo',
    'title' => 'عرض معلومات اتصال الطلاب في دورة: ' . $model->courseType->name,
));

$this->widget('application.components.Ajaxmodal', array(
    'name' => 'sessionOptionsModal',
    'title' => 'خيارات الجلسة',
    'width' => '600px',
));


$this->widget('application.components.Ajaxmodal', array(
    'name' => 'pleaseWaitModal',
    'title' => 'خيارات الجلسة',
    'width' => '600px',
));
$this->widget('application.components.Ajaxmodal', array(
    'name' => 'studentTransferModal',
    'title' => 'ترحيل طالب',
    'width' => '600px',
));
$this->widget('application.components.Ajaxmodal', array(
    'name' => 'sessionUpdateFormModal',
    'title' => 'تعديل بيانات الجلسة',
    'width' => '600px',
));
$this->widget('application.components.Ajaxmodal', array(
    'name' => 'studentOptionsModal',
    'title' => 'خيارات الطالب ضمن دورة ' . $model->getCourseNameText(),
    'width' => '600px',
));
$this->widget('application.components.Ajaxmodal', array(
    'name' => 'editStudentAssessmentModal',
    'title' => 'تقييم الطالب ضمن الدورة ' . $model->getCourseNameText(),
    'width' => '600px',
));

$this->widget('application.components.Ajaxmodal', array(
    'name' => 'payModal',
    'title' => 'دفع فاتورة ضمن الدورة ' . $model->getCourseNameText(),
    'width' => '70',
));

?>
<br/>
<ul class="nav nav-tabs" id="myTab">
    <li><a href="#profile" id="profile-tab" data-toggle="tab">المعلومات الاساسية للدورة</a></li>
    <li class="active"><a href="#students" data-toggle="tab" id="students-tab">جدول الطلاب</a></li>
    <li><a href="#schedule" data-toggle="tab">جدول الدوام</a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane fade" id="profile">
        <br/>
        <br/>
        <?php $this->renderPartial('partials/_details', array(
            'model' => $model,
        ))?>
    </div>
    <div class="tab-pane fade in active" id="students"><?php
        if (!empty($students)) {
            $this->renderPartial('partials/_student-list', array(
                'model' => $model,
                'students' => $students,
                'studentDataProvider' => $studentDataProvider,
            ));
        } else {

            echo "لايوجد طلاب مسجلين في الدورة";
        }
        ?></div>
    <div class="tab-pane fade" id="schedule">
        <?php $this->renderPartial('partials/course-sessions', array(
            'courseModel' => $model,
        ));?>
    </div>
</div>
<?php
$courseSession = new Session;
$courseSession->course_id = $model->id;
$this->widget('application.components.Modal', array(
    'model' => $courseSession,
    'form' => 'course.partials.create-session-form',
    'modalName' => 'courseSessionSetupModal',
    'title' => 'اعداد يوم دوام',
    'id' => 'createSessionForm',
));
?>
