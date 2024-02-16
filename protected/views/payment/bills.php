<?php
/** @var  $paymentModel Payment */
/** @var $this PaymentController */

$this->options = array(
    array('name' => 'البحث في الفواتير', 'url' => "#",'id'=>'searchBills', 'glyphicon' => 'glyphicon-search'),
    array('name' => 'العودة الى الرئيسية', 'url' => Yii::app()->createUrl("site/index"), 'glyphicon' => 'glyphicon-star'),
    array('name' => 'العودة الى صفحة ادارة الدورات', 'url' => $this->createUrl('course/admin'), 'glyphicon' => 'glyphicon-list-alt'),
    array('name' => 'االعودة الى صفحة ادارة الطلاب', 'url' => $this->createUrl('student/index'), 'glyphicon' => 'glyphicon-user'),
);

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/vendor/vex.js", CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/vendor/vex.dialog.js", CClientScript::POS_END);

Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl . "/css/vex/vex.css");
Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl . "/css/vex/vex-theme-plain.css");

$this->widget('application.components.Ajaxmodal', array(
    'name' => 'paymentOptionsModal',
    'title' => 'خيارات فاتورة',
    'width' => '600px',
));
$this->widget('application.components.Ajaxmodal', array(
    'name' => 'paymentUpdateModal',
    'title' => 'تعديل بيانات فاتورة',
    'width' => '600px',
));

Yii::app()->clientScript->registerScript('search', "
$('.ok-sign').hide();
$('.error-sign').hide();
var slide = 0;
$('#search-button').click(function(){
    if(slide == 0){
        $('.search-form').slideDown();
        slide =1;
    }else {
        $('.search-form').slideUp();
        slide =0;
    }
	return false;
	});
$('.search-form form').submit(function(){
	$('#bills-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
$('.Tabled table').addClass('table');
$('.Tabled table').addClass('subtable');
",CClientScript::POS_END);
$dataProvider = $paymentModel->search();

$this->renderPartial('partials/search-form',array(
    'model'=>$paymentModel,
));

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'bills-grid',
    'summaryText' => '',
    'afterAjaxUpdate' => 'js:function(id, data){
            $(".Tabled table").addClass("table");
            $(".Tabled table").addClass("subtable");
            $(".optionsButton").on("click",function(e){
                e.preventDefault();
                $.get( $(this).attr("href") ,{

                },
                function(data){
                    $("#paymentOptionsModal .modal-body").html(data);
                    $("#paymentOptionsModal").modal("show");
                }
                ,
                "html");
            });
        }',
    'dataProvider' => $dataProvider,
    'columns' => array(
        'num',
        'amount',
        'date',
        'note',
        array(
            'header'=>'اسم الطالب',
            'value'=>'$data->student->getName()',
        ),
        array(
            'header'=>'اسم الدورة',
            'value'=>'$data->course->courseType->name'
        ),
        array(
            'header'=>'بداية الدورة',
            'value'=>'Course::model()->findByPk($data->course_id)->start_date',
        ),
        array(
            'header'=>'نهاية الدورة',
            'value'=>'Course::model()->findByPk($data->course_id)->end_date',
        ),
        array(
            'class' => 'CButtonColumn',
            'header' => 'خيارات الفواتير',
            'template' => '{options}',
            'buttons' => array(
                'options' => array(
                    'label' => 'خيارات',
                    'url' => 'Yii::app()->createUrl("payment/getPaymentOptions",array("id"=>$data->id,"extra_payment_options_token"=>PaymentController::EXTRA_PAYMENT_OPTIONS_TOKEN))',
                    'options' => array(
                        'class' => 'btn btn-danger optionsButton',
                        'ajax' => array(
                            'url' => 'js:$(this).attr("href")',
                            'type' => 'GET',
                            'success' => 'js:function(data){
                                    $("#paymentOptionsModal .modal-body").html(data);
                             }',
                            'beforeSend' => 'js:function(xhr,setting){
                                    $("#paymentOptionsModal").modal("show");
                                    $("#paymentOptionsModal .modal-body").html("الرجاء الانتظار ...");

                                }',
                        ),
                    ),
                ),
            ),
        ),
    ),
)); ?>
<br/>
