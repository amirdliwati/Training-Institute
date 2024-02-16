<?php
/**
 * Created by PhpStorm.
 * User: Dell 3521
 * Date: 04/07/14
 * Time: 07:54 م
 */
CommonFunctions::fixAjax();
echo CHtml::beginForm($this->createUrl("postDiscount"), 'post', array(
    'role' => 'form',
    'class' => 'form-horizontal',
));?>
    <div class="form-group">
        <?php echo CHtml::label("قيمة الخصم", 'discount', array('class' => 'col-md-3 control-label')); ?>
        <div class="col-md-9 input-container">
            <?php echo CHtml::textField("discount", $discount, array('size' => 60, 'maxlength' => 255, 'class' => 'form-control')); ?>
        </div>
    </div>
<?php echo CHtml::hiddenField('student_id', $student_id) ?>
<?php echo CHtml::hiddenField('course_id', $course_id) ?>
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            <?php echo CHtml::ajaxSubmitButton('إضافة خصم', $this->createUrl('postDiscount'), array(
                'type' => 'POST',
                'dataType' => 'json',
                'success' => 'js:function(data){
                    if(data.status){
                        refreshPaymentInfo();
                    }else{
                        vex.defaultOptions.className = "vex-theme-plain";
                        vex.dialog.alert(data.message);
                    }
                }',
                'beforeSend' => 'js:function(){
        $("#addDiscountModal").modal("hide");
    }',
            ), array(
                'class' => 'btn btn-danger',
                'id' => 'link-' . uniqid(),
            ))?>
        </div>
    </div>
<?php echo CHtml::endForm(); ?>