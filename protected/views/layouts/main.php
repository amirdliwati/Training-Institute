<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="language" content="en"/>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- Core Script Files -->
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.js"></script>

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-theme.min.css"/>
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-rtl.min.css"/>
    <?php if(!empty($this->cssFiles)):?>
        <?php foreach($this->cssFiles as $fileName):?>
            <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl?>/css/<?php echo $fileName?>" />
        <?php endforeach;?>
    <?php endif;?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/main.js"); ?>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<div class="navbar-icard">
    <div class="navbar-content">
        <img class="app_logo" src="<?php echo Yii::app()->baseUrl;?>/images/icard.png"/>

        <div id="menubar">
            <nav>
                <ul>
                    <li class="category">
                        <a href="#menubar">الطلاب</a>
                        <ul class="submenu">
                            <li><a href="<?php echo $this->createUrl('student/index'); ?>">إدراة الطلاب</a></li>
                            <li><a href="<?php echo $this->createUrl('student/create'); ?>">تسجيل طالب جديد</a></li>
                            <li><a href="<?php echo $this->createUrl('damascusList/admin'); ?>">ادارة لوائح دمشق</a>
                            </li>

                        </ul>
                    </li>
                    <li class="category">
                        <a href="#menubar">الدورات</a>
                        <ul class="submenu">
                            <li><a href="<?php echo $this->createUrl('student/waitinglist') ?>">لوائح الانتظار</a></li>
                            <li><a href="<?php echo $this->createUrl('courseType/admin'); ?>">ادارة أنواع الدورات</a> </li>
                            <li><a href="<?php echo $this->createUrl('course/admin'); ?>">إدارة الدورات</a></li>
                        </ul>
                    </li>
                    <li class="category">
                        <a href="#menubar">المالية</a>
                        <ul class="submenu">
                            <li><a href="<?php echo $this->createUrl('payment/bills') ?>">الفواتير</a></li>
                            <li><a href="<?php echo $this->createUrl('payment/create'); ?>">إدخال فاتورة</a> </li>
                        </ul>
                    </li>
                    <li class="category">
                        <a href="<?php echo Yii::app()->createUrl('instructor/admin') ?>">المدرسين</a>
                    </li>
                    <li class="category">
                        <a href="#menubar">امتحانات ال ICDL</a>
                        <ul class="submenu">
                            <li><a href="<?php echo $this->createUrl('icdl/index') ?>">ادارة البطاقات</a></li>
                            <li><a href="<?php echo $this->createUrl('icdl/exams'); ?>">الإمتحانات</a> </li>
                        </ul>
                    </li>
                    <li class="category">
                        <a href="#menubar">البرامج الجديدة</a>
                        <ul class="submenu">
                            <li><a href="http://admin.icardacademy.com/">نظام الادارة (جديد)</a></li>
                            <li><a href="#">موقع اكاديمية ايكارد</a> </li>
                        </ul>
                    </li>
                    <li class="category">
                        <a href="<?php echo Yii::app()->createUrl("site/logout")?>">تسجيل الخروج</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>

<div class="clearfix"></div>
<div id="blocker">
    <div>الرجاء الانتظار...
    </div>
</div>
<div class="container-fluid main-container-fluid content content_container">
    <?php echo $content; ?>
</div>
<!--
<div class="container-fluid">
    <div class="row">
        <footer>
            <span>مدعوم من قبل المطور <a href="https://www.linkedin.com/profile/view?id=149507357">برهان عطور</a><span>
        </footer>
    </div>
</div>
-->
<!-- script files -->
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.min.js"></script>
<?php if(!empty($this->jsFiles)):?>
    <?php foreach($this->jsFiles as $fileName):?>
        <script type="text/javascript" src="<?php echo Yii::app()->baseUrl?>/js/<?php echo $fileName;?>"></script>
    <?php endforeach;?>
<?php endif;?>
</body>
</html>
