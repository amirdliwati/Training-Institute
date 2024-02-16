
<div class="row">
    <div class="col-md-6">

        <div class="row">
            <div class="col-md-5">
                <span>الأسم الأول</span>
            </div>
            <div class="col-md-7">
                <span class="label label-info" id="courseName"><?php echo $model->first_name;?></span>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-md-5">
                <span>الأسم الأخير</span>
            </div>
            <div class="col-md-7">
                <span class="label label-info" id="courseName"><?php echo $model->last_name;?></span>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-md-5">
                <span>أسم الأب</span>
            </div>
            <div class="col-md-7">
                <span class="label label-info" id="courseName"><?php echo $model->father_name;?></span>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-md-5">
                <span>اسم الأم</span>
            </div>
            <div class="col-md-7">
                <span class="label label-info" id="courseName"><?php echo $model->mother_name;?></span>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-md-5">
                <span>الجنسية</span>
            </div>
            <div class="col-md-7">
                <span class="label label-info" id="courseName"><?php echo $model->nationality;?></span>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-md-5">
                <span>الإقامة</span>
            </div>
            <div class="col-md-7">
                <span class="label label-info" id="courseName"><?php echo $model->residency;?></span>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-md-5">
                <span>الرقم الوطني</span>
            </div>
            <div class="col-md-7">
                <span class="label label-info" id="courseName"><?php echo $model->national_no;?></span>
            </div>
        </div>
        <br/>


    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-5">
                <span>تاريخ الولادة</span>
            </div>
            <div class="col-md-7">
                <span class="label label-info" id="courseName"><?php echo $model->DOB;?></span>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-md-5">
                <span>المهنة</span>
            </div>
            <div class="col-md-7">
                <span class="label label-info" id="courseName"><?php echo $model->occupation;?></span>
            </div>
        </div>
        <br/>

        <div class="row">
            <div class="col-md-5">
                <span>رقم الأرضي</span>
            </div>
            <div class="col-md-7">
                <span class="label label-info" id="courseName"><?php echo count($model->telNo(array("limit"=>1)))!=0?$model->telNo(array("limit"=>1))[0]->number:"----------";?></span>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="col-md-5">
                <span>رقم الخليوي</span>
            </div>
            <div class="col-md-7">
                <span class="label label-info" id="courseName"><?php echo count($model->mobileNo(array("limit"=>1)))!=0?$model->mobileNo(array("limit"=>1))[0]->number:"----------";?></span>
            </div>
        </div>
        <br/>
    </div>
</div>