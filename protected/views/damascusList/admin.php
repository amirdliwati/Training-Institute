<?php
/* @var $this DamascusListController */
/* @var $model DamascusList */

$this->options = array(
    array('name' => 'إنشاء لائحة جديدة', 'url' => "#", 'id' => 'createDamascusListLink', 'active' => true, 'glyphicon' => 'glyphicon-pencil'),
    array('name' => 'البحث ضمن اللوائح الموجودة', 'url' => "#", 'id' => 'searchDamasucListLink', 'glyphicon' => 'glyphicon-search'),
);

Yii::app()->clientScript->registerScript('search', "
$('.ok-sign').hide();
$('.error-sign').hide();
$('.Tabled table').addClass('table');
$('.Tabled table').addClass('subtable');
var slide = 0;
$('#createDamascusListLink').click(function(){
    $('#addNewDamascusListModal').modal('show');
});
$('#searchDamasucListLink').click(function(){
    if(slide == 0){
        $('.search-form').slideDown();
        slide =1;
    }else {
        $('.search-form').slideUp();
        slide =0;
    }
	return false;
});
$('.search-form form').submit(function(){
    $('#filterPleaseWaitModal .modal-body').html('يتم الآن اجراء الفلترة ....');
	$('#filterPleaseWaitModal').modal('show');
	$('#damascus-list-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/vendor/vex.js", CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/vendor/vex.dialog.js", CClientScript::POS_END);

Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl . "/css/vex/vex.css");
Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl . "/css/vex/vex-theme-plain.css");
// Create the Add a new Payment Modal ....
$createModel = new DamascusList;
$params = array(
    'form' => 'damascusList.add_form',
    'model' => $createModel,
    'title' => 'إنشاء لائحة دمشق جديدة',
    'modalName' => 'addNewDamascusListModal',
);
$this->widget('application.components.Modal', $params);
?>
<?php
$this->widget('application.components.Ajaxmodal', array(
    'name' => 'filterPleaseWaitModal',
    'title' => 'الرجاء الانتظار',
    'width' => '800px',
));?>

<?php
$this->widget('application.components.Ajaxmodal', array(
'name' => 'damascusListOptionsModal',
'title' => 'خيارات لائحة دمشق',
'width' => '800px',
));?>

<?php
$this->widget('application.components.Ajaxmodal', array(
    'name' => 'damascusListUpdateModal',
    'title' => 'تعديل بيانات لائحة دمشق',
    'width' => '800px',
));?>
<?php
$this->widget('application.components.Ajaxmodal', array(
    'name' => 'damascusListCreationSuccessModal',
    'title' => 'انتهت عملية الإنشاء',
    'width' => '800px',
));?>
<br/>
<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array(
        'model' => $model,
    )); ?>
</div><!-- search-form -->
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'damascus-list-grid',
    'summaryText' => '',
    'afterAjaxUpdate' => 'js:function(){
            $("#filterPleaseWaitModal").modal("hide");
        	$(".Tabled table").addClass("table");
            $(".Tabled table").addClass("subtable");
         }',
    'htmlOptions' => array(
        'class' => 'Tabled',
    ),
    'cssFile' => Yii::app()->baseUrl . '/css/main.css',
    'dataProvider' => $model->search(),
    'columns' => array(
        'num',
        'date',
        'start_date',
        'end_date',
        array(
            'header'=>'عدد الطلاب في اللائحة',
            'value'=>'$data->noOfEntries',
        ),
        array(
            'header' => 'خيارات',
            'class' => 'CButtonColumn',
            'template' => '{options}',
            'buttons' => array(
                'options' => array(
                    'label' => 'خيارات',
                    'click' => 'js:function(event){
                        $.ajax({
                          "url":$(this).attr("href"),
                          "type":"GET",
                          "success":function(data){
                            $("#damascusListOptionsModal .modal-body").html(data);
                            $("#damascusListOptionsModal").modal("show");
                          }
                        });
                        return false;
                    }',
                    'url' => 'Yii::app()->createUrl("damascusList/getDamascusListOptions",array("id"=>$data->id))',
                    'options' => array(
                        'class' => 'btn btn-danger',
                    ),
                )
            )
        ),
    ),
)); ?>
