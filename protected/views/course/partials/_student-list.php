<?php
/* @var $this CourseController */
/* @var $model Course */
/* @var $students @array of Student Models */

Yii::app()->clientScript->registerScript("student-course-list", '
$(function(){
    $(".Tabled table").addClass("table");
    $(".Tabled table").addClass("subtable");
});
', CClientScript::POS_END);

?>


<br/>
<div class="panel panel-success">
    <div class="panel-heading">عدد الطلاب في الدورة</div>
    <div class="panel-body">
        <?php echo $model->student_no?>
    </div>
</div>
<br/>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'student-course-grid',
    'summaryText' => '',
    'afterAjaxUpdate' => 'js:function(){
        	$(".Tabled table").addClass("table");
            $(".Tabled table").addClass("subtable");
         }',
    'htmlOptions' => array(
        'class' => 'Tabled',
    ),
    'cssFile' => Yii::app()->baseUrl . '/css/main.css',
    'dataProvider' => $studentDataProvider,
    'columns' => array(
        array(
            'class'=>'CCheckBoxColumn',
            'selectableRows'=>2,
            'id' => 'student_select',
            //'disabled'=>'$data->isTransfered();',
            'footerHtmlOptions'=>array(),
            'htmlOptions'=>array(
                'class'=>'student_select'
            ),
        ),
        array(
            'header'=>'الاسم',
            'value'=>'$data->getName()',
        ),
        array(
            'header'=>'حالة البيانات',
            'value'=>array($this,'renderInfoCompletenessStatus'),
        ),
        array(
            'header'=>'التقييم',
            'value'=>'CommonFunctions::getLabel($data->getAssessmentValue(),CommonFunctions::STUDENT_ASSESSMENT_STATUS)',
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
        /*array(
            'header' => 'رقم الخليوي',
            'value' => '!empty($data->mobileNo(array("limit"=>1)))?$data->mobileNo(array("limit"=>1))[0]->number:"----------"',
        ),
        array(
            'header' => 'رقم الأرضي',
            'value' => '!empty($data->telNo(array("limit"=>1)))?$data->telNo(array("limit"=>1))[0]->number:"----------"',
        ),*/
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
                    'url' => 'Yii::app()->createUrl("payment/getPaymentForm",array("sId"=>$data->id,"cId"=>$data->getContextCourseId(),"ref"=>"course_page"))',
                    'options' => array(
                        'class' => 'btn btn-danger btn-sm',
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
                    'url' => 'Yii::app()->createUrl("course/getCourseStudentOptions",array("sId"=>$data->id,"cId"=>$data->getContextCourseId(),"ref"=>"course_page"))',
                    'options' => array(
                        'class' => 'btn btn-warning btn-sm',
                        'id'=>'link-'.uniqid(),
                    ),
                )
            )
        ),
    ),
)); ?>

<br/>
<div class="row">

    <div class="col-md-6">
        <?php echo CHtml::textField('damascus_list_no','',array(
            'class'=>'form-control',
            'id'=>'damascus_list_no',
            'placeholder'=>'رقم اللائحة',
        ))?>
        <br/>
        <?php echo CHtml::link('ترحيل', '#', array(
            'id' => 'transfer_button',
            'class' => 'btn btn-danger',
        ));?>
        <?php echo CHtml::link('عرض ارقام الهواتف', '#', array(
            'id' => 'view_contact_button',
            'class' => 'btn btn-success',
        ));?>
    </div>

</div>
