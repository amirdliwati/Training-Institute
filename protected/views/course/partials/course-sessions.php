<?php
/* @var $this CourseController */
/* @var $courseModel Course */
Yii::app()->clientScript->registerScript("course_script_sessions", '
$(function(){
    $(".ok-sign").hide();
    $(".error-sign").hide();
    $(".Tabled table").addClass("table");
    $(".Tabled table").addClass("subtable");
});
', CClientScript::POS_END);

$courseSessionModel = new Session;
$courseSessionModel->course_id = $courseModel->id;
$this->widget('zii.widgets.grid.CGridView', array(

    'id' => 'sessions-grid',
    'summaryText' => '',
    'afterAjaxUpdate' => 'js:function(){
        	$(".Tabled table").addClass("table");
            $(".Tabled table").addClass("subtable");
         }',
    'htmlOptions' => array(
        'class' => 'Tabled',
    ),
    'cssFile' => Yii::app()->baseUrl . '/css/main.css',
    'dataProvider' => $courseSessionModel->search(),
    'columns' => array(
        'date',
        'DOW',
        'num',
        array(
            'name' => 'course_id',
            'value' => 'Course::model()->findByPk($data->course_id)->courseType->name',
        ),
        array(
            'header'=>'خيارات',
            'class' => 'CButtonColumn',
            'template' => '{options}',
            'buttons' => array(
                'options' => array(
                    'label' => 'خيارات',
                    'click' => 'js:function(event){
                        var ajaxUrl = $(this).attr("href");
                        var queryString = ajaxUrl.slice(ajaxUrl.lastIndexOf("&")+1);
                        jParam = $.deparam(queryString);
                        params = JSON.stringify(jParam);
                        var paramObject = jQuery.parseJSON( params );
                        $(this).attr("id","sessionOptions"+paramObject.id);
                        $link = $(this);
                        $.ajax({
                          "url":ajaxUrl,
                          "type":"GET",
                          "success":function(data){
                            $("#sessionOptionsModal .modal-body").html(data);
                            $("#sessionOptionsModal").modal("show");
                          }
                        });
                        return false;
                    }',
                    'url' => 'Yii::app()->createUrl("course/getCourseSessionOptions",array("id"=>$data->id));',
                    'options' => array(
                        'class' => 'btn btn-danger',
                        'data-toggle' => 'dropdown',
                    ),
                )
            )
        ),
    ),
)); ?>

    <br/>
<?php echo CHtml::button('إضافة يوم دوام', array(
    'class' => 'btn btn-success',
    'data-toggle' => 'modal',
    'data-target' => '#courseSessionSetupModal',
));

?>