<div class="row">
    <div class="col-md-offset-2 col-md-8">
        <?php echo CHtml::link("تسجيل الحضور",
            $this->createUrl('course/addAttendance', array('session_id' => $session_id))
            , array(
                'class' => 'btn btn-block btn-lg btn-danger',
            ))?>
    </div>
</div>
<br/>

<div class="row">
    <div class="col-md-offset-2 col-md-8">

        <?php echo CHtml::link("عرض الحضور",
            $this->createUrl('course/attendanceList', array('session_id' => $session_id))
            , array(
                'class' => 'btn btn-primary btn-lg btn-block',
            ))?>
    </div>
</div>
<br/>

<div class="row">
    <div class="col-md-offset-2 col-md-8">
        <?php echo CHtml::ajaxLink('تعديل بيانات الجلسة', Yii::app()->createUrl('course/callSessionUpdateForm', array('id' => $session_id)), array(
                'type' => 'GET',
                'success' => 'js:function(data){
                    $("#sessionOptionsModal").modal("hide");
                    $("#sessionUpdateFormModal .modal-body").html(data);
                    $("#sessionUpdateFormModal").modal("show");
                }'
            ),
            array(
                'class' => 'btn btn-info btn-lg btn-block',
            ))?>
    </div>
</div>
<br/>
<div class="row">
    <div class="col-md-offset-2 col-md-8">
        <?php echo CHtml::ajaxLink('حذف الجلسة', Yii::app()->createUrl('course/deleteSession', array('id' => $session_id)), array(
                'type' => 'GET',
                'dataType'=>'json',
                'success' => 'js:function(data){
                    $("#sessionOptionsModal").modal("hide");
                    alert(data.message+"");
                    $("#sessions-grid").yiiGridView("update");

                }'
            ),
            array(
                'class' => 'btn btn-warning btn-lg btn-block',
                'confirm'=>'هل أنت متأكد من رغبتك في حذف الجلسة؟ حذف الجلسة سيؤدي الى حذف جدول الدوام الخاص بالجلسة',
                'id'=>'link-'.uniqid(),
            ))?>
    </div>
</div>
<br/>
<?php CommonFunctions::fixAjax(); ?>
