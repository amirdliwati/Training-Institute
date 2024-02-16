<?php
/* @var $this IcdlController */
/* @var $dataProvider CActiveDataProvider */

$this->jsFiles[]= "icdl/_icdl.js";

$this->options = array(
    array(
        'id'=>'create-icdl-card-btn',
        'url'=>'#',
        'name'=>'إنشاء بطاقة جديدة',
        'glyphicon'=>'glyphicon glyphicon-floppy-saved',
    ),
    array(
        'id'=>'search-button',
        'url'=>'#',
        'name'=>'البحث في البطاقات',
        'glyphicon'=>'glyphicon glyphicon-search',
    ),
);
$this->widget('application.components.Ajaxmodal', array(
    'name' => 'createICDLCardModal',
    'title' => 'إنشاء بطاقة ICDL',
    'width' => '60',
));
$this->widget('application.components.Ajaxmodal', array(
    'name' => 'createICDLTicketModal',
    'title' => 'إنشاء تذكرة ICDL',
    'width' => '600px',
));
$this->widget('application.components.Ajaxmodal', array(
    'name' => 'updateICDLTicketModal',
    'title' => 'تعديل بيانات تذكرة ICDL',
    'width' => '600px',
));
$this->widget('application.components.Ajaxmodal', array(
    'name' => 'updateICDLCardModal',
    'title' => 'تعديل بيانات بطاقة ICDL',
    'width' => '60',
));
$this->widget('application.components.Ajaxmodal', array(
    'name' => 'pleaseWaitModal',
    'title' => 'معالجة',
    'width' => '600px',
));

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/vendor/vex.js", CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/vendor/vex.dialog.js", CClientScript::POS_END);

Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl . "/css/vex/vex.css");
Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl . "/css/vex/vex-theme-plain.css");

Yii::app()->clientScript->registerScript('icdl-script','
$("#search-button").click(function(){
	$("#search-form-container").toggle();
	return false;
});
$("#search-form-container form").submit(function(){
        $.fn.yiiGridView.update("icdl-card-grid", {
            data: $(this).serialize()
        });
        return false;
    });
$(".Tabled table").addClass("table");
$(".Tabled table").addClass("subtable");
var getICDLCardCreateFormURL = '.CJavaScript::encode(Yii::app()->createUrl('icdl/getICDLCardCreateForm')).';
var ICDLCardDeleteURL = '.CJavaScript::encode(Yii::app()->createUrl('icdl/delete')).';
var getICDLCardUpdateFormURL = '.CJavaScript::encode(Yii::app()->createUrl('icdl/getICDLCardUpdateForm')).';
var getICDLCardDetailsURL = '.CJavaScript::encode(Yii::app()->createUrl('icdl/getICDLCardDetails')).';
var getICDLTicketCreateFormURL = '.CJavaScript::encode(Yii::app()->createUrl('icdl/getICDLTicketCreateForm')).';
var getICDLTicketUpdateFormURL = '.CJavaScript::encode(Yii::app()->createUrl('icdl/getICDLTicketUpdateForm')).';
var getTicketListURL = '.CJavaScript::encode(Yii::app()->createUrl('icdl/getTicketList')).';
var iCDLTicketDelete = '.CJavaScript::encode(Yii::app()->createUrl('icdl/iCDLTicketDelete')).';
',CClientScript::POS_END);

?>
<br/>
<div id="search-form-container" style="display:none">
    <?php $this->renderPartial('_search',array(
        'model'=>$ICDLCardModel,
    )); ?>
</div><!-- search-form -->
<div id="icdl-card-detail-container">

</div>
<br/>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'icdl-card-grid',
    'summaryText' => '',
    'afterAjaxUpdate' => 'js:function(){
            $("#filterPleaseWaitModal").modal("hide");
        	$(".Tabled table").addClass("table");
            $(".Tabled table").addClass("subtable");
            updateICDLCardList();
         }',
    'htmlOptions' => array(
        'class' => 'Tabled',
    ),
    'showTableOnEmpty'=>false,
    'emptyText'=>'لايوجد نتائج',
    'cssFile' => Yii::app()->baseUrl . '/css/main.css',
    'dataProvider' => $ICDLCardModel->search(),
    'columns' => array(
        array(
            'header'=>'الاسم بالانكليزي',
            'value'=>'$data->first_name_en." ".$data->last_name_en',
        ),
        array(
            'header'=>'الاسم بالعربي',
            'value'=>'$data->first_name." ".$data->last_name',
        ),
        'un_code',
        'payment',
        array(
            'name'=>'اللغة',
            'value'=>'$data->getLanguageText()',
        ),
        array(
            'header'=>'خيارات',
            'value'=>array($this,'renderICDLCardOptions'),
        ),
    )
)); ?>

