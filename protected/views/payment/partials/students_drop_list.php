<?php
/**
 * @var $courses Course[]
 *
 */

if(empty($courses)){
    echo "<option>لايوجد طلاب</option>";
}
if(!empty($courses)){
    
    echo "<option value=''>اختر طالب</option>";

    foreach($courses as $course){
        $courseId = $course->id;
        foreach($course->students as $student){
            $studentName = $student->getName();
            $studentId = $student->id;
            echo "<option value='$courseId,$studentId'>$studentName</option>";
        }
    }

}