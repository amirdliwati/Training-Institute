<?php
/**
 * @var $courses Course[]
 *
 */

if(empty($courses)){
    echo "<option>لايوجد دورات فعالة تحت هذا التصنيف</option>";
}
if(!empty($courses)){
    echo "<option>اختر دورة من الدورات الحالية</option>";
    foreach($courses as $course){
        $studentCount = count($course->students);
        echo "<option value='$course->id'><span>$course->start_date</span> --> <span>$course->end_date </span><span> القسط | $course->cost</span><span> العدد | $studentCount </span><span> </span>
                </option>";
    }
}