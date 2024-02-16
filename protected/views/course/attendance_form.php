<?php
/**
 * Created by PhpStorm.
 * User: Dell 3521
 * Date: 07/06/14
 * Time: 02:50 م
 * @var $session Session
 */

Yii::app()->clientScript->registerScript("attendance_script",'
var checked = false;
$(function(){
    $("#select_all").click(function(event){
        if(checked==false){
            $(".form-control").each(function(){
                $(this).attr("checked",true);
            });
            $(this).val("إلغاء تحديد الكل");
            checked = true;
        }else{
            checked=false;
            $(this).val("تحديد الكل");
            $(".form-control").each(function(){
                $(this).attr("checked",false);
            });
        }

    });
});
');
?>

<?php
echo CHtml::link("العودة الى لوحة ادارة الدورة", $this->createUrl('course/view', array('id' => $session->course_id)));
?>

    <div class="row">
        <div class="col-md-4">رقم الجلسة</div>
        <div class="col-md-4"><?php echo $session->num; ?></div>
    </div>

    <div class="row">
        <div class="col-md-4">تاريخ الجلسة</div>
        <div class="col-md-4"><?php echo $session->date; ?></div>
    </div>
    <div class="row">
        <div class="col-md-4">اسم الدورة</div>
        <div class="col-md-4"><?php echo Course::model()->findByPk($session->course_id)->getCourseNameText(); ?></div>
    </div>
    <hr style="border-color: #777;"/>
<div class="row">
    <div class="col-md-2">
        <?php echo CHtml::button('تحديد الكل',array(
            'id'=>'select_all',
            'class'=>'btn btn-primary btn-block',
        ))?>
    </div>
</div>
<br/>
<?php $form = $this->beginWidget('CActiveForm', array(
    'id' => 'session-attendace-form',
    // Please note: When you enable ajax validation, make sure the corresponding
    // controller action is handling ajax validation correctly.
    // There is a call to performAjaxValidation() commented in generated controller code.
    // See class documentation of CActiveForm for details on this.
    'enableAjaxValidation' => false,
    'htmlOptions' => array(
        'role' => 'form',
        'class' => 'form-horizontal',
    ),
)); ?>
<?php echo CHtml::hiddenField('course_id',$session->course_id);?>
<?php foreach ($attendanceArray as $student_id => $attendace): ?>
    <div class="form-group">
        <?php echo CHtml::label(Student::model()->findByPk($attendace->student_id)->getName(), "student_id" . $attendace->student_id, array('class' => 'col-md-2 control-label')); ?>
        <div class="col-md-10 input-container">
            <?php echo CHtml::checkBox('student_id[]', $attendace->attending == Attendance::STATUS_PRESENT ? true : false, array(
                'class' => 'form-control',
                'value' => $attendace->student_id,
                'id' => 'student_id' . $attendace->student_id,
            ))?>
        </div>
    </div>
<?php endforeach; ?>
    <div class="form-group">
        <div class="col-md-offset-2 col-md-10">
            <?php echo CHtml::submitButton("تسجيل الحضور", array(
                'class' => 'btn btn-danger',
            ))?>
        </div>
    </div>
<?php $this->endWidget(); ?>