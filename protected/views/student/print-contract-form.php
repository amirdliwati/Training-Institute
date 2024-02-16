<?php
/**
 * Created by PhpStorm.
 * User: Burhan
 * Date: 1/16/2016
 * Time: 3:20 PM
 */
?>



<form role="form" class="form-horizontal" method="get" action="<?php echo Yii::app()->createUrl("course/showStudentContract");?>">
    <div class="row">
        <div class="col-md-12"><!-- right column container container -->
            <?php echo CHtml::hiddenField('student_id',$student->id)?>
            <?php echo CHtml::hiddenField('course_type_id',$course_type_id)?>
            <div class="form-group has-feedback">
                <?php echo CHtml::label("الدورة", "course", array('class' => 'col-md-4')); ?>
                <div class="col-md-8 input-container">
                    <span><?php echo CourseType::model()->findByPk($course_type_id)->name;?></span>
                </div>
            </div>
            <div class="form-group has-feedback">
                <?php echo CHtml::label("قسط الدورة", "cost", array('class' => 'col-md-4')); ?>
                <div class="col-md-8 input-container">
                    <input type="text" id="cost" name="cost" class="form-control">
                </div>
            </div>
            <div class="form-group has-feedback">
                <?php echo CHtml::label("المدفوع", "paid", array('class' => 'col-md-4')); ?>
                <div class="col-md-8 input-container">
                    <input type="text" id="paid" name="paid" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-offset-4 col-md-8">
                    <?php echo CHtml::submitButton('البيان') ?>
                </div>
            </div>
        </div>

    </div>
</form>