<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Dell 3521
 * Date: 06/05/14
 * Time: 03:30 م
 * To change this template use File | Settings | File Templates.
 */
?>

<?php if (empty($courses)): ?>
    <div class="alert alert-info">لايوجد دورات حالية تحت هذا التصنيف <a href="#"> - إذهب الى صفحة ادارة الدورات</a>
    </div>
<?php endif; ?>
<?php if (!empty($courses)): ?>
    <div class="list-group">
        <?php foreach ($courses as $course): ?>

            <a href="#" class="list-group-item">
                <div class="row">
                    <div class="col-sm-1">
                        <input type="radio" class="course_id" name="course_id" value="<?php echo $course->id; ?>"/>
                    </div>
                    <div class="col-sm-11">
                        <h4 class="list-group-item-heading"><?php echo $course->courseType->name; ?></h4>

                        <p class="list-group-item-text">

                        <ul>
                            <li><span style="color:#333;">تكلفة الدورة: </span><?php echo $course->cost; ?></li>
                            <li><span
                                    style="font-weight:650;">حالة الدورة: </span><?php echo $course->getStatusText(); ?>
                            </li>
                            <li><span
                                    style="font-weight:650;">تاريخ بداية الدورة: </span><?php echo $course->start_date; ?>
                            </li>
                            <li><span
                                    style="font-weight:650;">تاريخ نهاية الدورة: </span><?php echo $course->end_date; ?>
                            </li>

                        </ul>
                        </p>
                    </div>
                </div>

            </a>
                <span><?php echo CHtml::link("الذهاب الى صفحة الدورة",Yii::app()->createUrl('course/view',array('id'=>$course->id)))?></span>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

