<?php
/* @var $this CourseController */
/* @var $model Course */
Yii::app()->clientScript->registerScript('search', "
 $('.ok-sign').hide();
 $('.error-sign').hide();
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
$('.search-form form').submit(function(){
    $('#filterPleaseWaitModal .modal-body').html('يتم الآن اجراء الفلترة ....');
	$('#filterPleaseWaitModal').modal('show');
	$('#course-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
$('.Tabled table').addClass('table');
$('.Tabled table').addClass('subtable');
");
$this->options = array(
    array('name' => 'البحث في الدورات', 'url' => "#", 'id' => 'search-button', 'glyphicon' => 'glyphicon-search'),
    array('name' => 'إنشاء دورة جديدة', 'url' => $this->createUrl('course/create'), 'glyphicon' => 'glyphicon-pencil'),
    array('name' => 'لوائح الانتظار', 'url' => $this->createUrl('student/waitingList'), 'glyphicon' => 'glyphicon-list-alt'),
);

$this->widget('application.components.Ajaxmodal', array(
    'name' => 'filterPleaseWaitModal',
    'title' => 'الرجاء الانتظار',
    'width' => '800px',
));
$this->widget('application.components.Ajaxmodal', array(
    'name' => 'pleaseWaitModal',
    'title' => 'الرجاء الانتظار',
    'width' => '800px',
));
$this->widget('application.components.Ajaxmodal', array(
    'name' => 'updateCourseFormModal',
    'title' => 'تعديل بيانات الدورة',
    'width' => '800px',
));
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/vendor/vex.js", CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/vendor/vex.dialog.js", CClientScript::POS_END);

Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl . "/css/vex/vex.css");
Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl . "/css/vex/vex-theme-plain.css");

?>
<br/>
<div class="search-form" style="display:none;">
    <?php $this->renderPartial('_search', array(
        'model' => $model,
    )); ?>
</div><!-- search-form -->
<br/>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'course-grid',
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
        array(
            'header' => 'نوع الدورة',
            'value' => '$data->courseType->name',
        ),
        'cost',
        array(
            'name' => 'status',
            'type' => 'html',
            'value' => 'CommonFunctions::getLabel($data->status,CommonFunctions::COURSE_STATUS)',
        ),
        'start_date',
        'end_date',
        array(
            'type' => 'raw',
            'header' => 'عرض لوحة تحكم الدورة',
            'value' => array($this, 'renderViewLink'),
        ),
        /*array(
            'header' => 'اظهار لوحة التحكم في الدورة',
            'class' => 'CButtonColumn',
            'template' => '{view}     {update}',
            'buttons' => array(
                'update' => array(
                    'url' => 'Yii::app()->createUrl("course/callUpdate",array("id"=>$data->id))',
                    'label' => '<span class="glyphicon glyphicon-edit"></span>',
                    'image' => false,
                    'options' => array(
                        'ajax' => array(
                            'url' => 'js:$(this).attr("href")',
                            'type' => 'GET',
                            'success' => 'js:function(data){
                                    $("#updateCourseFormModal .modal-body").fadeOut(200,function(){
                                         $("#updateCourseFormModal .modal-body").html(data);
                                         $(this).fadeIn(500);
                                    });
                                }',
                            'beforeSend' => 'js:function(){
                                $("#updateCourseFormModal .modal-body").html("الرجاء الانتظار...");
                                $("#updateCourseFormModal").modal("show");
                            }',
                        )
                    ),
                ),
            ),
        ),*/
    ),
)); ?>
