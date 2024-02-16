<?php
/* @var $this DamascusListController */
/* @var $damascusList DamascusList */
/* @var $entries DamascusListEntry[] */
$counter = 0;
?>

    <div class="row">
        <div class="col-md-12">
            <img style="float:left;width: 70px;height: 70px;" class="app_logo img-responsive" src="<?php echo Yii::app()->baseUrl;?>/images/icard.png"/>
            <h4>الجمعية الحرفية لمراكز تدريب الكومبيوتر و الحرف باللاذقية</h4>
            <h5>أكاديمية ايكارد للعلوم و التدريب المهني</h5>
            <br/>
            <table style="width: 100%;">
                <tr>
                    <td><span>الرقم: </span style="font-size:18px;"><span style="font-size: 15px;" class="label-info label"><?php echo $damascusList->num;?></span></td><td>
                        <span>التاريخ: </span style="font-size:18px;"><span style="font-size: 15px;" class="label-info label"><?php echo $damascusList->date;?></span>
                    </td>
                    <td></td>
                </tr>
            </table>
            <br/>
        </div>
    </div>
    <div class="clearfix"></div>
    <table  class="table damascus_table">
        <thead>
        <tr class="d_entry d_entry_h">
            <th>الرقم</th>
            <th>الاسم و الشهرة</th>
            <th>الأب</th>
            <th>الأم</th>
            <th>مكان و تاريخ الولادة</th>
            <th>الجنسية</th>
            <th>الشهادة العلمية</th>
            <th>نوع الدورة</th>
            <th>تاريخ الابتداء</th>
            <th>تاريخ الانتهاء</th>
            <th>رقم الشهادة</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($entries as $entry):?>
            <?php
                $counter+=1;
                $entry->loadCourse();
                $entry->loadStudent();
            ?>
            <tr>
                <td class="d_entry"><?php echo $counter;?></td>
                <td class="d_entry"><?php echo $entry->student->first_name." ".$entry->student->last_name;?></td>
                <td class="d_entry"><?php echo $entry->student->father_name;?></td>
                <td class="d_entry"><?php echo $entry->student->mother_name;?></td>
                <td class="d_entry"><?php echo $entry->student->DOB;?></td>
                <td class="d_entry"><?php echo $entry->student->nationality;?></td>
                <td class="d_entry"><?php echo $entry->student->qualification;?></td>
                <td class="d_entry"><?php echo $entry->course->getCourseNameText();?></td>
                <td class="d_entry"><?php echo $entry->getStartDate();?></td>
                <td class="d_entry"><?php echo $entry->getEndDate();?></td>
                <td class="d_entry"></td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
    <br/>
    <table style="width: 100%;">
        <tr>

            <td><span>مدير المركز</span></td>
            <td><span>تصديق الجمعية الحرفية للمراكز</span></td>
            <td><span>تصديق اتحاد المحافظات</span></td>
        </tr>
    </table>
