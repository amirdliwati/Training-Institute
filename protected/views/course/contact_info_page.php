<?php
/**
 * @var $this CourseController
 * @var $model Course
 * @var $students Student[]
 *
 */

?>

<?php
/**
 * @var $registrations Registration[]
 */
?>

<?php if (empty($students)): ?>
    لايوجد طلاب للعرض
<?php endif; ?>
<?php if (!empty($students)): ?>
    <div class="row">
        <div class="col-md-6">
            <table class="table table-bordered">
                <tr>
                    <th>اسم الطالب</th>
                    <th>الهاتف الأرضي</th>
                    <th>الهاتف الخلوي</th>
                    <th>ملاحظات</th>
                </tr>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?php echo $student->getName(); ?></td>
                        <td><?php $numberTel = $student->telNo;
                            echo !empty($numberTel) ? $numberTel[0]->number : ""; ?></td>
                        <td><?php $numberMobile = $student->mobileNo;
                            echo !empty($numberMobile) ? $numberMobile[0]->number : ""; ?></td>
                        <td></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

<?php endif; ?>