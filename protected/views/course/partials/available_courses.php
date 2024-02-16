<?php
/**
 *
 * @var $courses Course[]
 */

Yii::app()->clientScript->registerScript('available_course','
$(".show-attendances").click(function(){
    $(".attendances-names").hide();
    $(this).next().toggle();
});
',CClientScript::POS_END);
?>

<?php if (empty($courses)): ?>
    <div>لايوجد دورات حالية تحت هذا التصنيف <a href="<?php echo Yii::app()->createUrl('course/admin'); ?>"> - إذهب الى
            صفحة ادارة الدورات</a>
    </div>
<?php endif; ?>
<?php if (!empty($courses)): ?>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th style="width: 15px;"></th>
            <th>الدورة</th>
        </tr>
        </thead>
        <tbody>
        <?php $count = 0;?>
        <?php foreach ($courses as $course): ?>
            <?php $count+=1;$style=' style="background-color: #ADADAD;color: #FAFAFA;"'?>
            <tr<?php echo $count==1?$style:""?>>
                <td style="width: 15px;"><input type="radio" class="course_id" name="course_id"
                                                value="<?php echo $course->id; ?>"/></td>
                <td>
                    <a target="_blank" href="<?php echo Yii::app()->createUrl("course/view",array('id'=>$course->id));?>">
                        <span><?php echo $course->start_date; ?></span> >
                    <span><?php echo $course->end_date; ?> </span><span> | القسط <?php echo $course->cost; ?></span><span> | العدد </span><span><?php echo count($course->students); ?></span></a>
                    <?php if (!empty($course->students)): ?>
                        <a href="#a" class="show-attendances"><span class="glyphicon glyphicon-user"></span></a>
                        <ol style="display: none;" class="attendances-names">
                            <?php foreach ($course->students as $student): ?>
                                <li><?php echo $student->getName(); ?></li>
                            <?php endforeach; ?>
                        </ol>

                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>

    </table>
<?php endif; ?>

