<?php
/* @var $this PaymentController */
/* @var $dataProvider CActiveDataProvider */

// Create the Add a new Payment Modal ....
$model = new Payment;
$model->student_id = intval($_GET['sId']);
$model->course_id = intval($_GET['cId']);
$params = array(
    'form' => 'payment.add_form',
    'model' => $model,
    'title' => 'إضافة فاتورة جديدة',
    'modalName' => 'addNewPaymentModal',
);
$this->widget('application.components.Modal', $params);
// The end of the Add new Payment Modal

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/vendor/vex.js", CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/vendor/vex.dialog.js", CClientScript::POS_END);

Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl . "/css/vex/vex.css");
Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl . "/css/vex/vex-theme-plain.css");
Yii::app()->clientScript->registerScript("refresh_payment_info", '
var refreshPaymentInfo = function(){
    $.ajax({
        "url":"' . $this->createUrl("getPaymentInfo", array("sId" => intval($_GET['sId']), "cId" => intval($_GET["cId"]))) . '",
        "dataType":"json",
        "success":function(data){
            $("#course_cost").html(data.cost);
            $("#course_cost_paid").html(data.paid);
            $("#course_cost_remaining").html(data.remaining);
            $("#discount_no").html(data.discount);
            $("#pleaseWait").modal("hide");
        },
        "beforeSend":function(xhr,setting){
            $("#pleaseWait .modal-body").html("الرجاء الانتظار");
            $("#pleaseWait").modal("show");
        }
    });
};
$(function(){
    $("#addDiscountLink").click(function(){
        $.ajax({
            "url":"'.$this->createUrl("addDiscount",array("sId" => intval($_GET['sId']), "cId" => intval($_GET["cId"]))).'",
            "success":function(data){
                $("#addDiscountModal .modal-body").html(data);
                $("#addDiscountModal").modal("show");
            }
        });
    });
});
refreshPaymentInfo();
', CClientScript::POS_END);

$this->options = array(
    array('name' => 'عرض سجل الطالب الشخصي', 'url' => Yii::app()->createUrl("student/view", array("id" => $this->_student->id)), 'id' => 'updateCourse', 'glyphicon' => 'glyphicon-user'),
    array('name' => 'عرض لوحة ادارة دورة ' . $this->_course->getCourseNameText(), 'url' => $this->createUrl('course/view', array('id' => $this->_course->id)), 'glyphicon' => 'glyphicon-list-alt'),
    array('name' => 'اضافة حسم' ,'url'=> "#",'id'=>"addDiscountLink", 'glyphicon' => 'glyphicon-usd'),

);

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
$this->widget('application.components.Ajaxmodal', array(
    'name' => 'pleaseWait',
    'title' => 'تحميل بيانات الدفع',
    'width' => '600px',
));
$this->widget('application.components.Ajaxmodal', array(
    'name' => 'addDiscountModal',
    'title' => 'اضافة حسم',
    'width' => '600px',
));
?>

<?php if ($dataProvider->totalItemCount == 0): ?>

    <p>لايوجد دفعات دفعها الطالب للدورة</p>
<?php endif; ?>

<div class="row">
    <div class="col-md-6">
        <h4>معلومات الطالب</h4>
        <hr style="border-color: #777;"/>
        <div class="row">
            <div class="col-md-6">الأسم الطالب</div>
            <div class="col-md-6"><span class="label-success label"><?php echo $this->_student->getName(); ?></span>
            </div>
        </div>
        <br>

        <div class="row">
            <div class="col-md-6">رقم الدورة</div>
            <div class="col-md-6"><span class=" label label-success"><?php echo $this->_course->id; ?></span></div>
        </div>

        <br>

        <div class="row">
            <div class="col-md-6">اسم الدورة</div>
            <div class="col-md-6"><span
                    class=" label label-success"><?php echo $this->_course->getCourseNameText(); ?></span></div>
        </div>
        <br>

        <div class="row">
            <div class="col-md-6">استاذ الدورة</div>
            <div class="col-md-6"><span
                    class=" label label-success"><?php echo $this->_course->instructor->getName(); ?></span></div>
        </div>
        <br>

        <div class="row">
            <div class="col-md-6">تاريخ بداية الدورة</div>
            <div class="col-md-6"><span
                    class=" label label-success"><?php echo $this->_course->start_date; ?></span></div>
        </div>
        <br>

        <div class="row">
            <div class="col-md-6">تاريخ نهاية الدورة</div>
            <div class="col-md-6"><span class=" label label-success"><?php echo $this->_course->end_date; ?></span>
            </div>
        </div>
        <br>
    </div>
    <div class="col-md-6">
        <h4>معلومات الدفعات</h4>
        <hr style="border-color: #777;"/>
        <div class="row">
            <div class="col-md-6">قيمة قسط الدورة</div>
            <div class="col-md-6">
                <span class="label label-warning" id="course_cost"></span>
            </div>
        </div>
        <br>

        <div class="row">
            <div class="col-md-6">المدفوع</div>
            <div class="col-md-6">
                <span class="label label-success" id="course_cost_paid"></span>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">الخصم</div>
            <div class="col-md-6">
                <span class=" label label-danger" id="discount_no"></span>
            </div>
        </div>

        <hr style="border-color: #AAA;"/>
        <div class="row">
            <div class="col-md-6">المتبقي للدفع</div>
            <div class="col-md-6">
                <span class=" label label-danger" id="course_cost_remaining"></span>
            </div>
        </div>
        <br/>

    </div>
</div>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'app_grid',
    'afterAjaxUpdate' => 'js:function(id, data){
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
            'class' => 'CButtonColumn',
            'header' => 'خيارات الفواتير',
            'template' => '{options}',
            'buttons' => array(
                'options' => array(
                    'label' => 'خيارات',
                    'url' => 'Yii::app()->createUrl("payment/getPaymentOptions",array("id"=>$data->id))',
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
<br/>

<div class="row">
    <div class="col-md-4">
        <?php
        echo CHtml::link("إضافة فاتورة جديدة", '#', array(
            'class' => 'btn btn-danger btn-block',
            'data-toggle' => 'modal',
            'data-target' => "#addNewPaymentModal",
        ));
        ?>
    </div>
</div>

