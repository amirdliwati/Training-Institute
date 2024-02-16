<?php
/**
 * Created by PhpStorm.
 * User: Dell 3521
 * Date: 18/06/14
 * Time: 07:58 م
 */
Yii::app()->clientScript->registerScript('courses-list', "

$('.Tabled table').addClass('table');
$('.Tabled table').addClass('subtable');
",CClientScript::POS_END);

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'course-grid',
    'summaryText' => '',
    'afterAjaxUpdate' => 'js:function(){
        	$(".Tabled table").addClass("table");
            $(".Tabled table").addClass("subtable");
         }',
    'htmlOptions' => array(
        'class' => 'Tabled',
    ),
    'cssFile' => Yii::app()->baseUrl . '/css/main.css',
    'dataProvider' => $courseDataProvider,
    'columns' => array(
        array(
            'header'=>'اسم الدورة',
            'value'=>'$data->getCourseNameText()',
        ),
        'cost',
        'start_date',
        'end_date',

        array(
            'name'=>'status',
            'type'=>'html',
            'value'=>'CommonFunctions::getLabel($data->status,CommonFunctions::COURSE_STATUS)',
        ),
        array(
            'header'=>'التقييم',
            'value'=>'CommonFunctions::getLabel($data->getStudent()->getAssessmentValue(),CommonFunctions::STUDENT_ASSESSMENT_STATUS)',
            'type'=>'html',
        ),
        array(
            'header'=>'الذمة المالية',
            'type'=>'html',
            'value'=>'CommonFunctions::getLabel($data->getStudentCourseFinancialStatus(),CommonFunctions::STUDENT_COURSE_FINANCIAL_STATUS)',
        ),
        array(
            'header'=>'وضع الترحيل',
            'type'=>'html',
            'value'=>'CommonFunctions::getLabel($data->getStudentTransferStatus(),CommonFunctions::STUDENT_IS_TRANSFERED)',
        ),
        array(
            'header' => 'دفع فاتورة',
            'class' => 'CButtonColumn',
            'template' => '{options}',
            'buttons' => array(
                'options' => array(
                    'label' => 'دفع فاتورة',
                    'click' => 'js:function(event){
                        var ajaxUrl = $(this).attr("href");
                        $.ajax({
                          "url":ajaxUrl,
                          "type":"GET",
                          "success":function(data){
                                $("#payModal .modal-body").html(data);
                          },
                          "beforeSend":function(){
                                $("#payModal .modal-body").html("الرجاء الانتظار");
                                $("#payModal").modal("show");
                          }
                        });
                        return false;
                    }',
                    'url' => 'Yii::app()->createUrl("payment/getPaymentForm",array("sId"=>$data->student_id,"cId"=>$data->id,"ref"=>"course_page"))',
                    'options' => array(
                        'class'=>'btn btn-danger btn-sm',
                        'id'=>'link-'.uniqid(),
                    ),
                )
            )
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
                            $("#studentOptionsModal .modal-body").html(data);
                            $("#studentOptionsModal").modal("show");
                          }
                        });
                        return false;
                    }',
                    'url' => 'Yii::app()->createUrl("student/getStudentCourseOptions",array("sId"=>$data->student_id,"cId"=>$data->id,"ref"=>"student_profile"))',
                    'options' => array(
                        'class' => 'btn btn-warning btn-sm',
                        'data-toggle' => 'dropdown',
                    ),
                )
            )
        ),
    ),
)); ?>
