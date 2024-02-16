<?php
/* @var $this CourseController */
/* @var $course Course */
/* @var $student Student */

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="row">
                <h1 class="text-center">أكاديمية ايكارد للعلوم</h1>

            </div>
            <div class="row">
                <h2 class="text-center">طلب انتساب</h2>
                <br/>
            </div>
            <br/>
            <table class="table">
                <tr>
                    <td>اسم الطالب</td>
                    <td><?php echo $student->first_name." ".$student->last_name;?></td>
                </tr>
                <tr>
                    <td>اسم الأب</td>
                    <td><?php echo $student->father_name;?></td>
                </tr>
                <tr>
                    <td>اسم الأم</td>
                    <td><?php echo $student->mother_name;?></td>
                </tr>
                <tr>
                    <td>مكان وتاريخ الولادة</td>
                    <td><?php echo $student->DOB;?></td>
                </tr>
                <tr>
                    <td>الشهادة العلمية</td>
                    <td><?php echo $student->qualification;?></td>
                </tr>
                <tr>
                    <td>محل الإقامة الحالية</td>
                    <td><?php echo strlen($student->residency)==0?"--------------":$student->residency;?></td>
                </tr>
                <tr>
                    <td>رقم الهاتف الأرضي</td>
                    <td><?php echo $telephoneNo;?></td>
                </tr>

                <tr>
                    <td>رقم الهاتف الجوال</td>
                    <td><?php echo $mobileNo;?></td>
                </tr>

                <tr>
                    <td>الجنسية</td>
                    <td><?php echo $student->nationality;?></td>
                </tr>
                <tr>
                    <td>نوع الدورة</td>
                    <td><?php echo $courseName;?></td>
                </tr>
                <tr>
                    <td>قيمة الدورة</td>
                    <td><?php echo $cost;?></td>
                </tr>
                <tr>
                    <td>قيمة الدفعة</td>
                    <td><?php echo $first_payment;?></td>
                </tr>
            </table>

            <br/>
            <div class="row">
                <div class="col-md-12">
                    <p style="font-size: 17px;font-weight: 600;">
                        و أتقبل كافة الأنظمة المرعية و نظامه الداخلي و دفع مايترتب على ذمتي من رسوم و أقساط في مواعيدها
                        المحددة و لا اتسلم شهادة الأختصاص الخاصة بي إلا بعد أن أكون قد سددت كافة الأقساط المترتبة علي وبناء
                        على ذلك أوقع.
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <p style="font-size: 17px;font-weight: 600;">
                    يمنح الطالب الشهادة الخاصة به دون اي رسوم اضافية
                    </p>
                </div>
            </div>
            <br/>
            <div><span>حرر في             </span><?php echo date('Y-m-d');?></div>
            <br/>
            <br/>
            <br/>
            <table class="table">
                <tr>
                    <td>توقيع المدير</td>
                    <td>توقيع الطالب</td>
                </tr>
            </table>
        </div>


    </div>
</div>