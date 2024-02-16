<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="language" content="en" />
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <!-- Core Script Files -->
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.js"></script>
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" />
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-theme.min.css" />
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-rtl.min.css" />

    <link rel="stylesheet" type="text/css" media="print" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css"/>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl."/js/main.js");?>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <style type="text/css">
        /* hr{
            border: 1px solid #333;
        }
        table{
            border: 1px solid #333 !important;
        }*/
        body{
            padding : 4px;
        }
    </style>
</head>
<body>
    <?php echo $content;?>
</body>
</html>