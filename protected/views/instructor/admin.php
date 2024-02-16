<?php
/* @var $this InstructorController */
/* @var $model Instructor */

Yii::app()->clientScript->registerScript('search', "
$(function(){
        $('.search-form form').submit(function(){
            $('#app_grid').yiiGridView('update', {
                data: $(this).serialize()
            });
            return false;
        });
        $('.Tabled table').addClass('table');
        $('.Tabled table').addClass('subtable');
});
var slide = 0;
$('#search-button').click(function(){
    if(slide == 0){
        $('.search-form').slideDown();
        slide =1;
    }else {
        $('.search-form').slideUp();
        slide =0;
    }
	return false;
});", CClientScript::POS_END);


$this->options = array(
    array('name' => 'إضافة مدرس جديد', 'url' => $this->createUrl('create'), 'active' => true, 'glyphicon' => 'glyphicon-pencil'),
    array('name' => 'البحث في الاساتذة', 'url' => "#", 'id' => 'search-button', 'glyphicon' => 'glyphicon-search'),
);
?>

<div class="search-form" style="display:none">
    <?php $this->renderPartial('_search', array(
        'model' => $model,
    )); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'app_grid',
    'summaryText' => '',
    'afterAjaxUpdate' => 'js:function(){
        	$(".Tabled table").addClass("table");
            $(".Tabled table").addClass("subtable");
         }',
    'htmlOptions' => array(
        'class' => 'Tabled',
    ),
    'cssFile' => Yii::app()->baseUrl . '/css/main.css',
    'dataProvider' => $model->search(),
    'columns' => array(
        'id',
        'first_name',
        'last_name',
        'tel',
        'mobile',
        'added_date',
        /*
        'note',
        */
        array(
            'type' => 'raw',
            'header' => 'عرض',
            'value' => array($this, 'renderViewLink'),
        ),
        array(
            'type' => 'raw',
            'header' => 'تعديل',
            'value' => array($this, 'renderUpdateLink'),
        ),

    ),
)); ?>
