<?php
/* @var $model Student */
/* @var $this StudentController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    array(
        'name'=>'الرئيسية',
        'url'=>$this->createUrl("site/index"),
    ),
    'الطلاب',
);

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/vendor/vex.js", CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/vendor/vex.dialog.js", CClientScript::POS_END);

Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl . "/css/vex/vex.css");
Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl . "/css/vex/vex-theme-plain.css");

$this->options=array(
    array('name'=>'البحث عن الطلاب', 'url'=>"#",'id'=>'search-button','glyphicon'=>'glyphicon-search'),
    array('name'=>'إنشاء طالب جديد', 'url'=>$this->createUrl('student/create'),'glyphicon'=>'glyphicon-pencil'),
    array('name'=>'لوائح الانتظار', 'url'=>$this->createUrl('student/waitingList'),'glyphicon'=>'glyphicon-list-alt'),
);
Yii::app()->clientScript->registerScript('search', "
$(function(){
       //var pagerContainer = $('.pager');
       //$('.pager ul').removeClass('yiiPager').addClass('pagination');
       //pagerContainer.removeClass('pager');
       /* $('.pagination a').click(function(e){
            e.preventDefault();
        });*/
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
});");
$this->widget('application.components.Ajaxmodal', array(
    'name' => 'payModal',
    'title' => 'دفع فاتورة',
    'width' => '70',
));
?>
<br/>
<div class="search-form">
    <?php $this->renderPartial('_search',array(
        'model'=>$model,
    )); ?>
</div><!-- search-form -->



<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'app_grid',
    'summaryText'=>'',
    'showTableOnEmpty'=>false,
    'emptyText'=>'ابحث ضمن الطلاب',
    'afterAjaxUpdate'=>'js:function(){
        	$(".Tabled table").addClass("table");
            $(".Tabled table").addClass("subtable");
           /* var pagerContainer = $(".pager");
        $(".pager ul").removeClass("yiiPager").addClass("pagination");
        $(".pagination a").click(function(e){
            e.preventDefault();
        });
        pagerContainer.removeClass("pager");*/


         }',
    'htmlOptions'=>array(
        'class'=>'Tabled',
    ),
    /*'pager'=>array(
        'class'=>'CLinkPager',
        'internalPageCssClass'=>null,
        'hiddenPageCssClass'=>'hidden',
        'prevPageLabel'=>'السابق',
        'previousPageCssClass'=>'next',
        'firstPageLabel'=>'الأول',
        'firstPageCssClass'=>'first',
        'lastPageCssClass'=>'last',
        'lastPageLabel'=>'الأخير',
        'maxButtonCount'=>6,
        'header'=>'',
        'nextPageLabel'=>'التالي',
        'nextPageCssClass'=>'previous',
    ),*/
    'cssFile'=>Yii::app()->baseUrl.'/css/main.css',
	'dataProvider'=>$model->search(),
	'columns'=>array(
        array(
            'header'=>'معرف',
            'name'=>'id',
            'filter'=>false,
            // 'filter'=>CHtml::dropDownList('id','0',CHtml::listData($model->findAll(),'id','first_name')),
            // Note That It's HTML ....
        ),
        array(
            'header'=>'الأسم الأول',
            'name'=>'first_name',
        ),
        array(
            'header'=>'الأسم الأخير',
            'name'=>'last_name',
        ),
        array(
            'header'=>'حالة البيانات',
            'value'=>array($this,'renderInfoCompletenessStatusForStudentListing'),
        ),
        'national_no',
        'father_name',
        'mother_name',
        /*array(
            'header'=>'رقم الخليوي',
            'value'=>'!empty($data->mobileNo(array("limit"=>1)))?$data->mobileNo(array("limit"=>1))[0]->number:"----------"',
        ),
        array(
            'header'=>'رقم الأرضي',
            'value'=>'!empty($data->telNo(array("limit"=>1)))?$data->telNo(array("limit"=>1))[0]->number:"----------"',
        ),*/
        array(
            'header' => 'دفع فاتورة',
            'class' => 'CButtonColumn',
            'template' => '{options}',
            'buttons' => array(
                'options' => array(
                    'label' => '<span class="glyphicon glyphicon-usd"></span>',
                    'click' => 'js:function(event){
                        var ajaxUrl = $(this).attr("href");
                        $.ajax({
                          "url":ajaxUrl,
                          "type":"GET",
                          "success":function(data){
                                $("#payModal .modal-body").html(data);
                          },
                          "beforeSend":function(){
                                $("#payModal .modal-body").html("الرجاء الانتظار");
                                $("#payModal").modal("show");
                          }
                        });
                        return false;
                    }',
                    'url' => 'Yii::app()->createUrl("payment/getPaymentForm",array("sId"=>$data->id,"ref"=>"student_page"))',
                    'options' => array(
                        'style'=>'color:#222;font-size:21px;',
                        'id'=>'link-'.uniqid(),
                    ),
                )
            )
        ),

        array(
            'type'=>'raw',
            'header'=>'عرض',
            'value'=>array($this,'renderViewLink'),
        ),
        array(
            'type'=>'raw',
            'header'=>'تعديل',
            'value'=>array($this,'renderUpdateLink'),
        ),
    ),
)); ?>
