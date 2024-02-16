<?php

/* @var $this StudentController */
/* @var $studentModel Student */
Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl . '/css/animate.css');
if(!Yii::app()->request->isAjaxRequest){
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/course/_course.js', CClientScript::POS_END);
}
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/vendor/vex.js", CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/vendor/vex.dialog.js", CClientScript::POS_END);
Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl . "/css/vex/vex.css");
Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl . "/css/vex/vex-theme-plain.css");

$this->options = array(
    array('name' => 'البحث في لوائح الانتظار', 'url' => "#", 'id' => 'search-button', 'glyphicon' => 'glyphicon-search'),
);

$this->widget('application.components.Ajaxmodal', array(
    'name' => 'registerForWaitModal',
    'title' => 'تعديل بيانات الانتظار',
    'width' => '600px',
));

$this->widget('application.components.Ajaxmodal', array(
    'name' => 'editStudentInfoModal',
    'title' => 'تعديل بيانات طالب',
    'width' => '80',
));

$this->widget('application.components.Ajaxmodal', array(
    'name' => 'editRegistrationInfoModal',
    'title' => 'خيارات الانتظار',
    'width' => '600px',
));

$this->widget('application.components.Ajaxmodal', array(
    'name' => 'printStudentContractModal',
    'title' => 'طباعة بيان الاشتراك',
    'width' => '600px',
));

$this->widget('application.components.Ajaxmodal', array(
    'name' => 'viewStudentContactInfo',
    'title' => 'معلومات اتصال الطلاب',
));

Yii::app()->clientScript->registerScript("script", '
var summaryAvailable=false;


var updateStudentsCount = function(){
    var studentId = 0;
    var course_type_id = $("#course_type").val();
    var waitingListCountUrl = ' . CJavaScript::encode($this->createUrl("student/getWaitingListCount")) . ';
    $.ajax({
                "type":"GET",
                "url": waitingListCountUrl,
                "data":{
                    "course_type_id": course_type_id
                },
                "dataType":"json",
                "success":function(data, status, xhr){
                    $("#waitingCountHeading").html(data.caption);
                    $("#waitingCountNo").html(data.studentCount);
                }
            });
}
    $(function(){
        updateStudentsCount();
        var availableCoursesUrl = ' . CJavaScript::encode($this->createUrl("course/courses")) . ';
        var activateForCourseUrl = ' . CJavaScript::encode($this->createUrl("course/registerForCourse")) . ';
        var showStudentContactUrl = ' . CJavaScript::encode($this->createUrl("student/showStudentContact")) . ';

        var studentNoUrl =' . CJavaScript::encode($this->createUrl("student/getPlainPhones")) . ';

        $(".search-form form").submit(function(){
            $("#app_grid").yiiGridView("update", {
                data: $(this).serialize()
            });
            return false;
        });
        $(".course_type_id_drop_down").change(function(){
            $("#app_grid").yiiGridView("update",{
                data:$(this).serialize()
            });
            if($(this).val()==""){
                $("#view_contact").addClass("disabled");
                $("#view_contact_button").addClass("disabled");
            }else{
                $("#view_contact").removeClass("disabled");
                $("#view_contact_button").removeClass("disabled");
            }
            updateStudentsCount();
            $(".course_type_id_drop_down").val();
            //$(".available-courses").addClass("animated");
            //$(".available-courses").addClass("bounceOutDown");
            //$("#activate_button").addClass("animated");
            //$("#activate_button").addClass("bounceOutDown");
            $.ajax({
                "type":"GET",
                "url": availableCoursesUrl,
                "data":{
                    "course_type_id": $(this).val()
                },
                "success":function(data, status, xhr){
                    $(".available-courses").html(data);
                    $(".popover-btn").popover();
                    //$(".available-courses").removeClass("bounceOutDown");
                    //$(".available-courses").addClass("bounceInDown");
                    //$("#activate_button").removeClass("bounceOutDown");
                    //$("#activate_button").addClass("bounceInDown");
                },
                "beforeSend":function(){
                    $(".available-courses").html("الرجاء الانتظار...");
                },
                "error":function(){
                    $(".available-courses").html("");
                }
            });
            return false;
        });

        $("#phones_button").click(function(){
            var studentId = [];
            $(".student_select input:checked").each(function(){
                studentId.push($(this).val());
            });
            studentId = studentId.join(",");
            $.ajax({
                url:studentNoUrl,
                type:"GET",
                data:{"student_id":studentId},
                success:function(data,status,xhr){
                    $("#phoneNoModal .modal-body").html(data);
                    $("#phoneNoModal").modal("show");
                }
            });

        });
        $("#activate_button").click(function(){
            var course_id = $(".course_id:checked").val();
            var studentId = [];
            $(".student_select input:checked").each(function(){
                studentId.push($(this).val());
            });
            studentId = studentId.join(",");
            $.ajax({
                url:activateForCourseUrl,
                type:"POST",
                data:{"course_id":course_id,"student_id":studentId},
                success:function(data,status,xhr){
                    $("#editRegistrationInfoModal").modal("hide");
                    vex.defaultOptions.className = "vex-theme-plain";
                    vex.dialog.alert("تم تفعيل الطلاب بنجاح");
                    $("#app_grid").yiiGridView("update");
                },
                error:function(xhr,status,message){
                    $("#editRegistrationInfoModal").modal("hide");
                    showMessage("حدد المعلومات كاملة: اسم الطالب و الدورة");
                },
                beforeSend:function(){
                    $("#editRegistrationInfoModal .modal-body").html("الرجاء الانتظار");
                    $("#editRegistrationInfoModal").modal("show");
                }
            });
        });
        $("#filter-student-waiting-list-form").submit(function(){
                $("#app_grid").yiiGridView("update",{
                    data:$("#filter-student-waiting-list-form").serialize()
                });
                return false;
        });
        var slide = 0;
        $("#search-button").click(function(){

                if(slide == 0){
                    $(".search-form").slideDown();
                    slide =1;
                }else {
                    $(".search-form").slideUp();
                    slide =0;
                }
                return false;
        });
        $("#view_contact_button").click(function(event){
            event.preventDefault();
            var studentId = [];
            $(".student_select input:checked").each(function(){
                studentId.push($(this).val());
            });
            studentId = studentId.join(",");
            $.ajax({
                        url: showStudentContactUrl,
                        type:"GET",
                        data: {"student_ids":studentId},
                        success:function(data,status,xhr){
                            $("#viewStudentContactInfo .modal-body").html(data);
                        },
                        beforeSend: function(){
                            $("#viewStudentContactInfo .modal-body").html(" الرجاء الانتظار...");
                            $("#viewStudentContactInfo").modal("show");
                        },
                        error: function(){
                            $("#viewStudentContactInfo .modal-body").html("تأكد من اختيار طلاب من القائمة");
                        }
            });
        });
        $("#view_contact").click(function(e){
            var ctid = $(".course_type_id_drop_down").val();
            var studentId = [];
            $(".student_select input:checked").each(function(){
                studentId.push($(this).val());
            });
            studentId = studentId.join(",");
            var viewStudentContactUrl = ' . CJavaScript::encode(Yii::app()->createUrl('student/viewContactInfo')) . ';
            window.href = viewStudentContactUrl+"?ids="+studentId+"&ctid="+ctid;
            $(this).attr("href",viewStudentContactUrl+"?ids="+studentId+"&ctid="+ctid)

        });
        $("#refresh_button").click(function(){
            updateStudentsCount();
            $("#app_grid").yiiGridView("update",{
                data:$(".course_type_id_drop_down").serialize()
            });

            $(".course_type_id_drop_down").val();
            //$(".available-courses").addClass("animated");
            //$(".available-courses").addClass("bounceOutDown");
            //$("#activate_button").addClass("animated");
            //$("#activate_button").addClass("bounceOutDown");
            $.ajax({
                "type":"GET",
                "url": availableCoursesUrl,
                "data":{
                    "course_type_id": $(".course_type_id_drop_down").val()
                },
                "success":function(data, status, xhr){
                    $(".available-courses").html(data);
                    $(".popover-btn").popover();
                    //$(".available-courses").removeClass("bounceOutDown");
                    //$(".available-courses").addClass("bounceInDown");
                    //$("#activate_button").removeClass("bounceOutDown");
                    //$("#activate_button").addClass("bounceInDown");
                },
                "beforeSend":function(){
                    $(".available-courses").html("الرجاء الانتظار...");
                }
            });
            return false;
        });
});
');?>

<!-- Boostrap modal dialog -->
<div style="z-index:99999;overflow: visible;" class="modal fade" id="waitingListSummaryModal" tabindex="-1"
     role="dialog" aria-labelledby="updateActionLabel" aria-hidden="true" style="display:none;">
    <div class="modal-dialog" style="width: 70%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">ملخص عن اعداد المنتظرين</h4>
            </div>
            <div class="modal-body">
                <div style="overflow-y: scroll">

                </div>
            </div>
            <div class="modal-footer">

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="row">
<div class="col-md-8">
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'app_grid',
        'summaryText' => '',
        'beforeAjaxUpdate' => 'js:function(){
        $("#blocker").fadeIn(300);
    }',
        'afterAjaxUpdate' => 'js:function(){
            $("#blocker").fadeOut(300);
        	$(".Tabled table").addClass("table");
            $(".Tabled table").addClass("subtable");
            colorEffectedRow();
         }',
        'htmlOptions' => array(
            'class' => 'Tabled',
        ),
        'cssFile' => Yii::app()->baseUrl . '/css/main.css',
        'dataProvider' => $registrationModel->search(),
        'rowHtmlOptionsExpression'=>'array("student_id"=>$data->student_id)',
        'columns' => array(
            array(
                'class' => 'CCheckBoxColumn',
                'id' => 'student_select',
                'selectableRows' => 2,
                'value' => '$data->student_id',
                'htmlOptions' => array(
                    'class' => 'student_select select_checkbox'
                ),
            ),
            array(
                'header' => 'اسم الطالب',
                'class' => 'CLinkColumn',
                'labelExpression' => '$data->getStudent()->getName()',
                'urlExpression' => 'Yii::app()->createUrl("student/view",array("id"=>$data->student_id))',
            ),
            array(
                'header' => 'حالة البيانات',
                'value' => array($this, 'renderInfoCompletenessStatus'),
            ),
            array(
                'header' => 'اسم الدورة',
                'value' => '$data->getCourseType()->name',
            ),
            'preferred_time',
            'initial_payment',
            'registration_date',
            /*array(
                'header' => 'رقم الأرضي',
                'value' => '!empty($data->getStudent()->telNo(array("limit"=>1)))?$data->getStudent()->telNo(array("limit"=>1))[0]->number:"----------"',
            ),
            array(
                'header' => 'رقم الخليوي',
                'value' => '!empty($data->getStudent()->mobileNo(array("limit"=>1)))?$data->getStudent()->mobileNo(array("limit"=>1))[0]->number:"----------"',
            ),*/
            'note',
            array(
                'type'=>'raw',
                'header' => 'طريقة التسجيل',
                'value' => 'CommonFunctions::getLabel($data->registration_method,CommonFunctions::REGISTRATION_METHOD)',
            ),
            array(
                'header' => 'طباعة بيان',
                'class' => 'CButtonColumn',
                'template' => '{print}',
                'buttons' => array(
                    'print' => array(
                        'label' => '<span class="glyphicon glyphicon-user"></span>',
                        'options' => array(
                            'class' => 'btn btn-danger btn-sm',
                            'ajax' => array(
                                'url' => 'js:$(this).attr("href")',
                                'type' => 'GET',
                                'success' => 'js:function(data){
                                            $("#printStudentContractModal .modal-body").html(data);
                                        }',
                                'beforeSend' => 'js:function(){
                                            $("#printStudentContractModal .modal-body").html("الرجاء الانتظار...");
                                            $("#printStudentContractModal").modal("show");
                                        }'

                            ),
                        ),
                        'url' => 'Yii::app()->createUrl("student/getPrintContractForm",array("sId"=>$data->student_id,"course_type_id"=>$data->course_type_id))',

                    )
                )
            ),
            array(
                'header' => 'اكمال البيانات',
                'class' => 'CButtonColumn',
                'template' => '{edit}',
                'buttons' => array(
                    'edit' => array(
                        'label' => '<span class="glyphicon glyphicon-list-alt"></span>',
                        'options' => array(
                            'class' => 'btn btn-danger btn-sm',
                            'ajax' => array(
                                'url' => 'js:$(this).attr("href")',
                                'type' => 'GET',
                                'success' => 'js:function(data){
                                            $("#editStudentInfoModal .modal-body").html(data);
                                        }',
                                'beforeSend' => 'js:function(){
                                            $("#editStudentInfoModal .modal-body").html("الرجاء الانتظار...");
                                            $("#editStudentInfoModal").modal("show");
                                        }'

                            ),
                        ),
                        'url' => 'Yii::app()->createUrl("student/getStudentUpdateForm", array("id" => $data->student_id, "cTId" => $data->course_type_id))',
                    )
                )
            ),
            array(
                'header' => 'تعديل',
                'class' => 'CButtonColumn',
                'template' => '{edit}',
                'buttons' => array(
                    'edit' => array(
                        'label' => '<span class="glyphicon glyphicon-pencil"></span>',
                        'options' => array(
                            'class' => 'btn btn-danger btn-sm',
                            'ajax' => array(
                                'url' => 'js:$(this).attr("href")',
                                'type' => 'GET',
                                'success' => 'js:function(data){
                                            $("#registerForWaitModal .modal-body").html(data);
                                        }',
                                'beforeSend' => 'js:function(){
                                            $("#registerForWaitModal .modal-body").html("الرجاء الانتظار...");
                                            $("#registerForWaitModal").modal("show");
                                        }'

                            ),
                        ),
                        'url' => 'Yii::app()->createUrl("student/getRegistrationUpdateForm", array("sId" => $data->student_id, "cTId" => $data->course_type_id))',
                    )
                )
            ),
            array(
                'header' => 'حذف',
                'class' => 'CButtonColumn',
                'template' => '{delete_registration}',
                'buttons' => array(
                    'delete_registration' => array(
                        'label' => '<span class="glyphicon glyphicon-trash"></span>',
                        'options' => array(
                            'class' => 'btn btn-danger btn-sm',
                            'confirm' => 'هل انت متاكد من انك تريد حذف الطالب من الانتظار؟',
                            'ajax' => array(
                                'url' => 'js:$(this).attr("href")',
                                'type' => 'GET',
                                'success' => 'js:function(data){

                                vex.defaultOptions.className = "vex-theme-plain";
                                if(data.status){
                                    vex.dialog.alert(data.message);
                                    $("#app_grid").yiiGridView("update", {
                                        data: $(".search-form form").serialize()
                                    });
                                }else{
                                    vex.dialog.alert(data.message);
                                }
                            }',
                            ),
                        ),
                        'url' => 'Yii::app()->createUrl("student/deleteFromRegistration", array("sId" => $data->student_id, "cTId" => $data->course_type_id,"ref"=>"waiting_list"))',
                    )
                )
            ),

        ),
    ))
    ?>
</div>

<div class="col-md-4">
    <div class="panel panel-success">
        <div class="panel-body">

            <div class="search-form">
                <?php $form = $this->beginWidget('CActiveForm', array(
                    'action' => Yii::app()->createUrl($this->route),
                    'method' => 'get',
                    'htmlOptions' => array(
                        'role' => 'form',
                        'class' => 'form-horizontal',
                    ),
                )); ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <?php echo $form->labelEx($registrationModel, 'course_type_id', array('class' => 'col-md-4 control-label')); ?>
                            <div class="col-md-6">
                                <?php echo $form->dropDownList($registrationModel, 'course_type_id', CourseType::model()->getAvailableCourseTypes(), array(
                                    'class' => 'course_type_id_drop_down form-control', 'prompt' => 'اختر نوع دورة',
                                    'id' => 'course_type',
                                ));?>

                            </div>
                            <div class="col-md-2">
                                <?php echo CHtml::link("<span class='glyphicon glyphicon-refresh'></span>", "#", array(
                                    'id' => 'refresh_button',
                                    'class' => 'btn btn-primary btn-block'
                                ));
                                ?>
                            </div>
                        </div>
                        <div class="form-group">

                            <div class="col-md-12">
                                <button class="btn btn-default btn-block" type="button">
                                    <span id="waitingCountHeading"></span> <span class="badge"
                                                                                 id="waitingCountNo"></span>
                                </button>
                                <?php echo CHtml::ajaxLink('عرض ملخص الانتظار', $this->createUrl('getWaitingListSummary'),
                                    array(
                                        'success' => 'js:function(data){
                                    $("#waitingListSummaryModal .modal-body div").html(data);
                                    $("#waitingListSummaryModal").modal("show");
                                    summaryAvailable=true;
                                }',
                                        'beforeSend' => 'js:function(){
                                    if(summaryAvailable==true){
                                        $("#waitingListSummaryModal").modal("show");
                                        return false;
                                    }else{
                                        $("#waitingListSummaryModal .modal-body div").html("الرجاء الانتظار ...");
                                        $("#waitingListSummaryModal").modal("show");
                                    }
                                }'
                                    ),
                                    array(
                                        'class' => 'btn btn-primary btn-block btn-sm',
                                        'id' => 'link-' . uniqid(),
                                    ))?>
                                <?php echo CHtml::link("عرض معلومات الاتصال", "#", array(
                                    'class' => 'btn btn-block btn-sm btn-success disabled',
                                    'id' => 'view_contact',
                                ));?>


                            </div>
                        </div>


                    </div>

                </div>
                <?php $this->endWidget(); ?>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <p>
                        <?php echo CHtml::link('تفعيل', '#', array(
                            'id' => 'activate_button',
                            'class' => 'btn btn-danger btn-sm btn-block',
                        ));?>
                    </p>

                </div>
                <div class="col-md-6">
                    <p>
                        <?php echo CHtml::link('عرض ارقام الهواتف', '#', array(
                            'id' => 'view_contact_button',
                            'class' => 'btn btn-success btn-sm btn-block disabled',
                        ));?>
                    </p>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="available-courses height-transition">
            </div>
        </div>
    </div>
</div>
</div>
