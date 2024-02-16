<?php
/*
  *
  * var $student_id int
  * var $course_id int
  * var $model Course
  *
  */
?>

<?php CommonFunctions::fixAjax(); ?>
<div class="row">
    <div class="col-md-offset-2 col-md-8">
        <?php echo CHtml::link("عرض مالية الطالب في الدورة",
            Yii::app()->createUrl('payment/payments', array('cId' => $course_id, 'sId' => $student_id))
            , array(
                'class' => 'btn btn-info btn-lg btn-block',
            ))?>
    </div>
</div>
<br/>
<?php if($model->isTransfered()):?>
<div class="row">
    <div class="col-md-offset-2 col-md-8">

        <?php echo CHtml::link("عرض لائحة دمشق للطالب",
            $this->createUrl('damascusList/view', array(
                'id' => DamascusListEntry::model()->find('student_id=:student_id AND course_id=:course_id',array(
                        ':student_id'=>$student_id,
                        ':course_id'=>$course_id,
                    ))->damascusList->id,
        ))
            , array(
                'class' => 'btn btn-primary btn-lg btn-block',
            )
        )?>
    </div>
</div>
<br/>
<?php endif;?>
<?php if(!$model->isTransfered()):?>
    <div class="row">
        <div class="col-md-offset-2 col-md-8">
            <?php echo CHtml::ajaxLink("ترحيل الطالب",
                $this->createUrl('course/getStudentTransferForm', array('sId' => $student_id, 'cId' => $course_id)),
                array(
                    'type' => 'GET',
                    'success' => 'js:function(data){
                        $("#studentTransferModal .modal-body").html(data);
                        $("#studentTransferModal").modal("show");
                }',
                    'beforeSend' => 'js:function(xhr,setting){
                    $("#studentOptionsModal").modal("hide");
                }',
                ),
                array(
                    'class' => 'btn btn-primary btn-lg btn-block',
                    'id' => 'link-' . uniqid(),
                ))?>
        </div>
    </div>
    <br/>

<?php endif;?>
<div class="row">
    <div class="col-md-offset-2 col-md-8">
        <?php echo CHtml::ajaxLink("ادراج تقييم للطالب",
            $this->createUrl('course/editStudentAssessment', array('sId' => $student_id, 'cId' => $course_id,'ref'=>$ref)),
            array(
                'type' => 'GET',
                'success' => 'js:function(data){
                    $("#editStudentAssessmentModal .modal-body").html(data);
                    $("#editStudentAssessmentModal").modal("show");
                }',
                'beforeSend' => 'js:function(xhr,setting){
                    $("#studentOptionsModal").modal("hide");
                }',
            ),
            array(
                'class' => 'btn btn-primary btn-lg btn-block',
                'id' => 'link-' . uniqid(),
            ))?>
    </div>
</div>
<br/>

<div class="row">
    <div class="col-md-offset-2 col-md-8">
        <?php echo CHtml::link("طباعة بيان الاشتراك",
            $this->createUrl('course/showStudentContract', array('student_id' => $student_id, 'course_id' => $course_id))
            , array(
                'class' => 'btn btn-warning btn-lg btn-block',
            ))?>
    </div>
</div>
<br/>
<hr/>
<div class="row">
    <div class="col-md-offset-2 col-md-8">
        <?php echo CHtml::ajaxLink("حذف الطالب من الدورة",
            $this->createUrl('course/deleteStudent'),
            array(
                'dataType' => 'json',
                'type' => 'POST',
                'data'=>array(
                    'sId'=>$student_id,
                    'cId'=>$course_id,
                ),
                'success' => 'js:function(data){
                    vex.defaultOptions.className = "vex-theme-plain";
                    $("#studentOptionsModal").modal("hide");
                    if(data.status){
                        $("#student-course-grid").yiiGridView("update");
                    }
                    vex.dialog.alert(data.message);
                }',
                'beforeSend' => 'js:function(xhr,setting){
                        $("#studentOptionsModal .modal-body").html("الرجاء الانتظار...");
                    }'
            ),
            array(
                'class' => 'btn btn-danger btn-lg btn-block',
                'id' => 'link-'.uniqid(),
                'confirm' => 'هل انت متاكد من انك تريد حذف الطالب ؟ حذف الطالب سيؤدي الى حذف بياناته المالية وكذلك سجلات حضوره',
            ))?>
    </div>
</div>
<br/>
<h4>خيارات اخرى</h4>
<hr/>
<div class="row">
    <div class="col-md-offset-2 col-md-8">
        <?php echo CHtml::link("عرض السجل الشخصي",
            Yii::app()->createUrl('student/view', array('id' => $student_id))
            , array(
                'class' => 'btn btn-block btn-lg btn-success',

            ))?>
    </div>
</div>
<br/>