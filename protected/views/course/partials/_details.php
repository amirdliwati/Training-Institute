<?php
/* @var $this CourseController */
/* @var $model Course */
?>
<h3>المعلومات العامة</h3>

<div class="row">
    <div class="col-md-6">

        <div class="row">
            <div class="col-md-5">
                <span>اسم الدورة: </span>
            </div>
            <div class="col-md-7">
                <span class="label label-info" id="courseName"></span>
            </div>
        </div>
        <br/>

        <div class="row">
            <div class="col-md-5">
                <span>توصيف الدورة: </span>
            </div>

        </div>
        <br/>

        <div class="row">
            <div class="col-md-12">
                <div style="font-size:12px;color:#fff;padding:4px;border-radius: 4px;font-weight: 600;" class="labe label-info" id="courseDescription"></div>
            </div>
        </div>

    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-5">
                <span>حالةالدورة: </span>
            </div>
            <div class="col-md-7">
                <span class="label label-info" id="courseStatus"></span>
            </div>
        </div>
        <br/>


        <div class="row">
            <div class="col-md-5">
                <span>تاريخ بدايةالدورة: </span>
            </div>
            <div class="col-md-7">
                <span class="label label-info" id="startDate"></span>
            </div>
        </div>
        <br/>

        <div class="row">
            <div class="col-md-5">
                <span>تاريخ نهاية الدورة: </span>
            </div>
            <div class="col-md-7">
                <span class="label label-info" id="endDate"></span>
            </div>
        </div>
        <br/>

        <div class="row">
            <div class="col-md-5">
                <span>ملاحظات حول الدورة: </span>
            </div>
            <div class="col-md-7">
                <div style="font-size:12px;color:#fff;padding:4px;border-radius: 4px;font-weight: 600;" class="labe label-info" id="note"></div>
            </div>
        </div>
        <br/>
    </div>
</div>
<div class="clearfix"></div>

<hr/>
<h3>مالية الدورة: </h3>
<div class="row">
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-5">
                <span>تلكفة الدورة (ل.س): </span>
            </div>
            <div class="col-md-7">
                <span class="label label-info" id="courseCost"></span>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-md-5">
                <span>الربح المتوقع للدورة :</span>
            </div>
            <div class="col-md-7">
                <span class="label label-info" id="estimatedProfits"></span>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-md-5">
                <span>ماتم تحصيله من أقساط الطلاب: </span>
            </div>
            <div class="col-md-7">
                <span class="label label-info" id="currentProfits"></span>
            </div>
        </div>
        <br/>
    </div>
</div>