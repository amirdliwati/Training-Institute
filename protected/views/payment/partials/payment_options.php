<?php CommonFunctions::fixAjax(); ?>
<div class="row">
    <div class="col-md-offset-2 col-md-8">
        <?php echo CHtml::ajaxLink('حذف الفاتورة', Yii::app()->createUrl('payment/deletePayment'), array(
                'type' => 'POST',
                'dataType' => 'json',
                'data' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken, 'id' => $payment->id,'extra_payment_options_token'=>isset($_GET['extra_payment_options_token'])?$_GET['extra_payment_options_token']:"payments"),
                'success' => 'js:function(data){
                    $("#paymentOptionsModal").modal("hide");
                    if(data.status){
                        if(data.ref=="bills"){
                            $("#bills-grid").yiiGridView("update");
                        }else{
                            refreshPaymentInfo();
                            $("#app_grid").yiiGridView("update");
                        }
                    }else{
                        vex.defaultOptions.className = "vex-theme-plain";
                        vex.dialog.alert(data.message);
                    }
                }'
            ),
            array(
                'class' => 'btn btn-danger btn-lg btn-block',
                'id' => 'link-' . uniqid(),
                'confirm' => 'هل تريد بالتأكيد حذف الفاتورة؟',
            ))?>
    </div>
</div>
<br/>
<div class="row">
    <div class="col-md-offset-2 col-md-8">
        <?php echo CHtml::ajaxLink('تعديل بيانات فاتورة', Yii::app()->createUrl('payment/getUpdateForm', array('id' => $payment->id)), array(
                'type' => 'GET',
                'dataType' => 'html',
                'success' => 'js:function(data){
                    $("#paymentUpdateModal .modal-body").fadeOut(300,function(){
                        $("#paymentUpdateModal .modal-body").html(data);
                    });
                    $("#paymentUpdateModal .modal-body").fadeIn(500);
                }',
                'beforeSend' => 'js:function(xhr,setting){
                    $("#paymentOptionsModal").modal("hide");
                    $("#paymentUpdateModal .modal-body").hide();
                    $("#paymentUpdateModal").modal("show");
                    $("#paymentUpdateModal .modal-body").html("الرجاء الانتظار ...");
                    $("#paymentUpdateModal .modal-body").fadeIn(500);

                }'
            ),
            array(
                'class' => 'btn btn-success btn-lg btn-block',
                'id' => 'link-' . uniqid(),

            ))?>
    </div>
</div>
<br/>
<?php if (isset($_GET['extra_payment_options_token'])): ?>

    <hr style="border-bottom-color: #777777">
    <h5>خيارات اخرى</h5>
    <hr style="border-bottom-color: #777777">
    <div class="row">
        <div class="col-md-offset-2 col-md-8">
            <?php echo CHtml::link("الذهاب الى صفحة الطالب الدافع للفاتورة",array('student/view','id'=>$payment->student_id),array(
                'class'=>'btn btn-success btn-block',
            ))?>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-md-offset-2 col-md-8">
            <?php echo CHtml::link("الذهاب الى صفحة الدورة التي دفعت فيها الفاتورة",array('course/view','id'=>$payment->course_id),array(
                'class'=>'btn btn-warning btn-block',
            ))?>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-md-offset-2 col-md-8">
            <?php echo CHtml::link("الذهاب الى مالية الطالب في الدورة",array('payment/payments','sId'=>$payment->student_id,'cId'=>$payment->course_id),array(
                'class'=>'btn btn-danger btn-block',
            ))?>
        </div>
    </div>
    <br/>
<?php endif; ?>
