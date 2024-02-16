<?php
/**
 * @var $this Controller
 */
$this->jsFiles[]= "icdl/_icdl-exams.js";

$this->options = array(
    array(
        'id'=>'search-button',
        'url'=>'#',
        'name'=>'فلترة الامتحانات',
        'glyphicon'=>'glyphicon glyphicon-search',
    ),
);

$this->jsFiles[]= "bootstrap-timepicker.min.js";

$this->cssFiles[] = "bootstrap-timepicker.min.css";

Yii::app()->clientScript->registerScript('icdl-script','
$("#search-button").click(function(){
	$("#search-form-container").toggle();
	return false;
});
var printExamsURL = '.CJavaScript::encode(Yii::app()->createUrl('icdl/printExams')).';
function newDoc() {
    window.location.assign("http://www.w3schools.com")
}
$("#search-form-container form").submit(function(){
        $.fn.yiiGridView.update("icdl-exam-grid", {
            data: $(this).serialize()
        });
        return false;
});

$("#print-btn").click(function(){
    window.location.assign(printExamsURL+"?date="+$("#date-field").val()+"&time="+$("#time-field").val());
	return false;
});

$(".Tabled table").addClass("table");

$(".Tabled table").addClass("subtable");
$(function(){
    $("#time-field").timepicker({
                minuteStep: 1,
                showSeconds: true,
                showMeridian: false,
                defaultTime: false
            });
});
',CClientScript::POS_END);

?>
<br/>

<div id="search-form-container" style="display:none">
    <?php $this->renderPartial('_exams_search',array(
        'model'=>$ICDLTicketModel,
    )); ?>
</div><!-- search-form -->
<br/>
<?php if(isset($_GET['rel'])):?>
<div class="alert alert-warning">
<p>ادخل كلا التاريخ و الوقت لتتمكن من طباعة جدول الامتحانات</p>
</div>
<?php endif;?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'icdl-exam-grid',
    'summaryText' => '',
    'afterAjaxUpdate' => 'js:function(){
            $(".Tabled table").addClass("table");
            $(".Tabled table").addClass("subtable");

         }',
    'htmlOptions' => array(
        'class' => 'Tabled',
    ),
    'showTableOnEmpty'=>false,
    'emptyText'=>'لايوجد نتائج',
    'cssFile' => Yii::app()->baseUrl . '/css/main.css',
    'dataProvider' => $ICDLTicketModel->search(),
    'columns' => array(
        array(
            'header'=>'رمز ال UN',
            'value'=>'$data->icdlCard->un_code',
        ),
        array(
            'header'=>'الأسم الأول',
            'value'=>'$data->icdlCard->first_name_en',
        ),
        array(
            'header'=>'الاسم الأخير',
            'value'=>'$data->icdlCard->last_name_en',
        ),
        array(
            'header'=>'Module',
            'value'=>'$data->getExamTypeText()',
        ),
        array(
            'header'=>'اللغة',
            'value'=>'$data->icdlCard->getLanguageText()',
        ),
    )
)); ?>

