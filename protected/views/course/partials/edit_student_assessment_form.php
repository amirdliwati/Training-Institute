<?php

CommonFunctions::fixAjax();
echo CHtml::beginForm($this->createUrl("postStudentAssessment"), 'post', array(
    'role' => 'form',
    'class' => 'form-horizontal',
));?>
    <?php echo CHtml::hiddenField('ref',$ref)?>
    <div class="form-group">
        <?php echo CHtml::label("التقييم", 'assessment', array('class' => 'col-md-3 control-label')); ?>
        <div class="col-md-9 input-container">
            <?php echo CHtml::dropDownList("assessment",$student->getAssessmentValue() , Course::model()->getAvailableCourseGrades(), array('prompt' => 'اختر درجة التقييم', 'class' => 'form-control')); ?>
        </div>
    </div>
    <div class="form-group">
        <?php echo CHtml::label("الدرجة", 'mark', array('class' => 'col-md-3 control-label')); ?>
        <div class="col-md-9 input-container">
            <?php echo CHtml::textField("mark", $student->getMarkValue(), array('class' => 'form-control')); ?>
        </div>
    </div>

<?php echo CHtml::hiddenField('student_id', $student->id) ?>
<?php echo CHtml::hiddenField('course_id', $course->id) ?>
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            <?php echo CHtml::ajaxSubmitButton('ادراج تقييم', $this->createUrl('postStudentAssessment'), array(
                'type' => 'POST',
                'dataType' => 'json',
                'success' => 'js:function(data){
                    if(data.status){
                        if(data.ref == "student_profile"){
                            $("#course-grid").yiiGridView("update");
                        }else if(data.ref == "course_page"){
                            $("#student-course-grid").yiiGridView("update");
                        }

                        vex.defaultOptions.className = "vex-theme-plain";
                        vex.dialog.alert(data.message);
                    }else{
                        vex.defaultOptions.className = "vex-theme-plain";
                        vex.dialog.alert(data.message);
                    }
    }',
                'beforeSend' => 'js:function(){
        $("#editStudentAssessmentModal").modal("hide");
    }',
            ), array(
                'class' => 'btn btn-danger',
                'id' => 'link-' . uniqid(),
            ))?>
        </div>
    </div>
<?php echo CHtml::endForm(); ?>