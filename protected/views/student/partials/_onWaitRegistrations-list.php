<?php
/* @var $onWaitRegistrations Registration */

Yii::app()->clientScript->registerScript('courses-list', "

$('.Tabled table').addClass('table');
$('.Tabled table').addClass('subtable');
", CClientScript::POS_END);
$dataProvider = new CActiveDataProvider('Registration');
$dataProvider->setData($onWaitRegistrations);
$this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'waiting-course-grid',
        'summaryText' => '',
        'afterAjaxUpdate' => 'js:function(){
        	$(".Tabled table").addClass("table");
            $(".Tabled table").addClass("subtable");
         }',
        'htmlOptions' => array(
            'class' => 'Tabled',
        ),
        'cssFile' => Yii::app()->baseUrl . '/css/main.css',
        'dataProvider'=>$dataProvider,
        'columns'=>array(
            array(
                'header'=>'اسم الدورة',
                'value'=>'$data->getCourseType()->name',
            ),
            'preferred_time',
            'initial_payment',
            'registration_date',
            'note',
            array(
                'type'=>'raw',
                'header' => 'طريقة التسجيل',
                'value' => 'CommonFunctions::getLabel($data->registration_method,CommonFunctions::REGISTRATION_METHOD)',
            ),
            array(
                'header' => 'خيارات',
                'class' => 'CButtonColumn',
                'template' => '{options}',
                'buttons' => array(
                    'options' => array(
                        'label' => 'خيارات',
                        'click' => 'js:function(event){
                        var ajaxUrl = $(this).attr("href");
                        $.ajax({
                          "url":ajaxUrl,
                          "type":"GET",
                          "success":function(data){
                            $("#registrationOptionsModal .modal-body").html(data);
                          },
                          "beforeSend":function(){
                            $("#registrationOptionsModal .modal-body").html("الرجاء الانتظار");
                            $("#registrationOptionsModal").modal("show");
                          }
                        });
                        return false;
                    }',
                        'url' => 'Yii::app()->createUrl("student/getRegistrationOptions",array("sId"=>$data->student_id,"cTId"=>$data->course_type_id,"ref"=>"student_profile"))',
                        'options' => array(
                            'class' => 'btn btn-danger',
                        ),
                    )
                )
            ),
        ),
    )
);
