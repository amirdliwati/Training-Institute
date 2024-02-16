<?php
/* @var $this SiteController */

Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl."/css/home.css");

$this->pageTitle= "اهلا بكم في اكاديمية ايكارد للعلوم";
?>

<div class="row home-content">
    <div class="col-md-offset-4 col-md-4">
        <ul>
            <li><a href="<?php echo Yii::app()->createUrl("student/index")?>" class="round green">الطلاب<span class="round">إدارة الطلاب في المعهد</span></a></li>
            <li><a href="<?php echo Yii::app()->createUrl("instructor/admin")?>" class="round red">المدرسون<span class="round">إدارة ذاتيات المدرسين في المعهد</span></a></li>
            <li><a href="<?php echo Yii::app()->createUrl("course/admin")?>" class="round yellow">الدورات<span class="round">إدارة الدورات الحالية و لوائح الانتظار</span></a></li>
            <li><a href="#" class="round green">المالية<span class="round">إدارة الشؤون المالية للدورات و الطلاب</span></a></li>
        </ul>
    </div>
</div>

