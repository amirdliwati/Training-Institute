<?php
/**
 * @var $registrations Registration[]
 */
?>

<?php if (empty($registrations)): ?>
    لايوجد طلاب للعرض
<?php endif; ?>
<?php if (!empty($registrations)): ?>
    <div class="row">
        <div class="col-md-6">
            <table class="table table-bordered">
                <tr>
                    <th>اسم الطالب</th>
                    <th>الهاتف الأرضي</th>
                    <th>الهاتف الخلوي</th>
                    <th>ملاحظات</th>
                </tr>
                <?php foreach ($registrations as $registration): ?>
                    <tr>
                        <?php $student = Student::model()->find('id=:id',array(':id'=>$registration->student_id));?>
                        <td><?php echo $student->getName(); ?></td>
                        <td><?php $numberTel = $student->telNo;
                            echo !empty($numberTel) ? $numberTel[0]->number : ""; ?></td>
                        <td><?php $numberMobile = $student->mobileNo;
                            echo !empty($numberMobile) ? $numberMobile[0]->number : ""; ?></td>
                        <td><?php echo $registration->note;?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>

<?php endif; ?>