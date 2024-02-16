<?php
/*
  *
  * var $student_id int
  * var $course_id int
  *
  */
CommonFunctions::fixAjax();
?>

<div class="row">
    <div class="col-md-offset-2 col-md-8">
        <?php echo CHtml::ajaxLink("دفع فاتورة للطالب",
            $this->createUrl('student/getPaymentForm', array('sId' => $student->id, 'cId' => $course->id,'ref'=>$ref)),
            array(
                'type' => 'GET',
                'success' => 'js:function(data){
                    $("#addPaymentModal .modal-body").html(data);
                    $("#addPaymentModal").modal("show");
                }',
                'beforeSend' => 'js:function(xhr,setting){
                    $("#studentOptionsModal").modal("hide");
                }',
            ),
            array(
                'class' => 'btn btn-danger btn-lg btn-block',
                'id'=>'link-'.uniqid(),
                'live'=>false,
            ))?>
    </div>
</div>
<br/>

<div class="row">
    <div class="col-md-offset-2 col-md-8">
        <?php echo CHtml::ajaxLink("ادراج تقييم للطالب",
            $this->createUrl('course/editStudentAssessment', array('sId' => $student->id, 'cId' => $course->id,'ref'=>$ref)),
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
            $this->createUrl('course/showStudentContract', array('student_id' => $student->id, 'course_id' => $course->id))
            , array(
                'class' => 'btn btn-warning btn-lg btn-block',
            ))?>
    </div>
</div>
<br/>
<h5>خيارات اخرى</h5>
<hr/>
<div class="row">
    <div class="col-md-offset-2 col-md-8">
        <?php echo CHtml::link("عرض مالية الطالب في الدورة",
            Yii::app()->createUrl('payment/payments', array('cId' => $course->id, 'sId' => $student->id))
            , array(
                'class' => 'btn btn-info btn-lg btn-block',
            ))?>
    </div>
</div>
<br/>

<div class="row">
    <div class="col-md-offset-2 col-md-8">
        <?php echo CHtml::link("الذهاب الى صفحة ادارة الدورة",
            $this->createUrl('course/view', array('id' =>$course->id))
            , array(
                'class' => 'btn btn-danger btn-lg btn-block',
            ))?>
    </div>
</div>
<br/>
