<?php
/**
 * Created by PhpStorm.
 * User: Dell 3521
 * Date: 07/06/14
 * Time: 02:23 م
 * @var $session Session
 * @var $this CourseController
 */
?>

<?php
$this->options = array(
    array('name' => 'العودة الى لوحة التحكم بالدورة', 'url' => $this->createUrl('course/view',array('id'=>$session->course_id)), 'glyphicon' => 'glyphicon-list-alt'),
);
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
    <div class="col-md-6">
        <table class="table subtable">
            <?php if (!empty($session->attendances)): ?>
                <thead>
                <td>اسم الطالب</td>
                <td>حالة الحضور</td>
                </thead>
            <?php endif; ?>
            <?php foreach ($session->attendances as $attendance): ?>
                <tr>
                    <td><?php echo CHtml::encode(Student::model()->findByPk($attendance->student_id)->getName()) ?></td>
                    <?php if ($attendance->attending == Attendance::STATUS_PRESENT): ?>
                        <td><span class="label-success label">حاضر</span></td>
                    <?php endif; ?>
                    <?php if ($attendance->attending == Attendance::STATUS_ABSENT): ?>
                        <td><span class="label-danger label">غائب</span></td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-6">
                <span>عدد الطلاب الكلي</span>
            </div>
            <div class="col-md-6">
                <?php echo "<span class='label label-info'>" . count($session->attendances) . "</span>" ?>
            </div>
        </div>
        <br/>

        <div class="row">
            <div class="col-md-6">
                <span>عدد الحضور</span>
            </div>
            <div class="col-md-6">
                <?php echo "<span class='label label-info'>" . count($session->attendances(array(
                        'condition' => 'attending=:attending',
                        'params' => array(
                            ':attending' => Attendance::STATUS_PRESENT,
                        )))) . "</span>"?>
            </div>
        </div>
        <br/>

        <div class="row">
            <div class="col-md-6">
                <span>عدد الغياب</span>
            </div>
            <div class="col-md-6">
                <?php echo "<span class='label label-info'>" . count($session->attendances(array(
                        'condition' => 'attending=:attending',
                        'params' => array(
                            ':attending' => Attendance::STATUS_ABSENT,
                        )))) . "</span>"?>
            </div>
        </div>
        <br/>
    </div>
</div>
