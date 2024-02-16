<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
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
    <link rel="stylesheet" type="text/css"
          href="<?php echo Yii::app()->request->baseUrl; ?>/css/login_form.css"/>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/main.js"); ?>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>
<body class="body">
<!--[if lt IE 7]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->
<div class="container-fluid container_login">


    <div class="row">
        <div class="col-md-8 col-md-offset-2 intro-content">
            <img class="intro-img" src="<?php echo Yii::app()->request->baseUrl; ?>/images/icard.png" alt="icard-logo"/>
            <br/>
            <br/>
            <?php if($this->action->id=="login"):?>
            <p class="intro">أهلا بكم في تطبيق التحكم الالكتروني الخاص بأكاديمية ايكارد للعلوم المهنية و التقنية - اللاذقية, سوريا</p>
            <?php endif;?>
            <small style="font-size:18px;"><?php echo $this->welcome_message;?></small>
        </div>
    </div>

    <br/>
    <?php echo $content;?>


</div>
<br/>
<footer class="footer_login">
            <span style="font-size: 14px">ICARD ACADEMY, SYRIA. &copy All rights reserved <?php echo date('Y')?> <span>
</footer>

<!-- script files -->
<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.min.js"></script>

<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
<script>
    (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
        function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
        e=o.createElement(i);r=o.getElementsByTagName(i)[0];
        e.src='//www.google-analytics.com/analytics.js';
        r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
    ga('create','UA-XXXXX-X');ga('send','pageview');
</script>
</body>
</html>
