<?php
/* @var $this CourseTypeController */
/* @var $model CourseType */

$this->options = array(
    array('name' => 'البحث في الدورات', 'url' => "#", 'id' => 'search-button', 'glyphicon' => 'glyphicon-search'),
    array('name' => 'إنشاء دورة جديدة', 'url' => $this->createUrl('courseType/create'), 'glyphicon' => 'glyphicon-pencil'),
);

$this->pageTitle = "إدارة أنواع الدورات";

Yii::app()->clientScript->registerScript('search', "
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
});




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
");

?>


<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'app_grid',
    'summaryText'=>'',

    'afterAjaxUpdate'=>'js:function(){
        	$(".Tabled table").addClass("table");
            $(".Tabled table").addClass("subtable");
         }',
    'htmlOptions'=>array(
        'class'=>'Tabled',
    ),
    'cssFile'=>Yii::app()->baseUrl.'/css/main.css',
	'dataProvider'=>$model->search(),
	'columns'=>array(
		'id',
		'name',
		'description',
        array(
            'type'=>'raw',
            'header'=>'تعديل',
            'value'=>array($this,'renderUpdateLink'),
        ),
	),
)); ?>
