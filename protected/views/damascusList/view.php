<?php
/* @var $this DamascusListController */
/* @var $model DamascusList */

$this->options = array(
    array('name' => 'طباعة اللائحة', 'url' => $this->createUrl('printDamascusList', array('damascus_list_id' => $model->id)), 'id' => 'addEntriesLink', 'glyphicon' => 'glyphicon-print'),
);

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/vendor/vex.js", CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . "/js/vendor/vex.dialog.js", CClientScript::POS_END);

Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl . "/css/vex/vex.css");
Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl . "/css/vex/vex-theme-plain.css");

Yii::app()->clientScript->registerScript('search', "
        	$('.Tabled table').addClass('table');
            $('.Tabled table').addClass('subtable');
");

$this->widget('application.components.Ajaxmodal', array(
    'name' => 'damascusListEntryUpdateModal',
    'title' => 'تخصيص تاريخ طالب ضمن اللائحة',
    'width' => '600px',
));
?>

<br/>
<div class="panel panel-info">
    <div class="panel-heading"> معلومات عن لائحة دمشق</div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-4">
                <b><?php echo CHtml::encode($model->getAttributeLabel('id')); ?>:</b>
            </div>
            <div>
                <?php echo CHtml::link(CHtml::encode($model->id), array('view', 'id' => $model->id)); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <b><?php echo CHtml::encode($model->getAttributeLabel('num')); ?>:</b>
            </div>
            <div>
                <?php echo CHtml::encode($model->num); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <b><?php echo CHtml::encode($model->getAttributeLabel('start_date')); ?>:</b>

            </div>
            <div>
                <?php echo CHtml::encode($model->start_date); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <b><?php echo CHtml::encode($model->getAttributeLabel('end_date')); ?>:</b>

            </div>
            <div>
                <?php echo CHtml::encode($model->end_date); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <b><?php echo "عدد الاسماء ضمن اللائحة"; ?>:</b>

            </div>
            <div>
                <?php echo CHtml::encode($model->noOfEntries); ?>
            </div>
        </div>
    </div>
</div>
<br/>

<h4>قائمة الاسماء ضمن اللائحة</h4>
<hr style="border-color:#777;">
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'damascus-list-entries-grid',
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
    'dataProvider' => $entriesDataProvider,
    'columns' => array(
        array(
            'header' => 'الاسم و الشهرة',
            'value' => '$data->getStudent()->getName()',
        ),
        /*array(
            'header' => 'الأب',
            'value' => '$data->getStudent()->father_name',
        ),
        array(
            'header' => 'الأم',
            'value' => '$data->getStudent()->mother_name',
        ),*/
        array(
            'header' => 'مكان و تاريخ الولادة',
            'value' => '$data->getStudent()->DOB',
        ),
        array(
            'header' => 'الجنسية',
            'value' => '$data->getStudent()->nationality',
        ),
        array(
            'header' => 'الشهادة العلمية',
            'value' => '$data->getStudent()->qualification',
        ),

        array(
            'header' => 'نوع الدورة',
            'value' => '$data->getCourse()->courseType->name',
        ),
        array(
            'header'=>'تاريخ البدء',
            'value'=>'$data->getStartDate()',
        ),
        array(
            'header'=>'تاريخ الانتهاء',
            'value'=>'$data->getEndDate()',
        ),

        array(
            'header'=>'التقييم',
            'value'=>'CommonFunctions::getLabel($data->getAssessmentValue(),CommonFunctions::STUDENT_ASSESSMENT_STATUS)',
            'type'=>'html',
        ),

        array(
            'header' => 'حذف',
            'class' => 'CButtonColumn',
            'template' => '{delete_btn}',
            'buttons' => array(
                'delete_btn' => array(
                    'label' => '<span class="glyphicon glyphicon-trash"></span>',
                    'url' => 'Yii::app()->createUrl("damascusListEntry/delete",array("id"=>$data->id))',
                    'options' => array(
                        'class' => 'btn btn-danger',
                        'confirm' => 'هل انت نتأكد من الحذف؟',
                        'ajax' => array(
                            'url' => 'js:$(this).attr("href")',
                            'type' => 'GET',
                            'dataType' => 'json',
                            'success' => 'js:function(data){
                                if(data.status){
                                    $("#damascus-list-entries-grid").yiiGridView("update");
                                };
                                alert(data.message);
                            }',
                        ),
                    )
                )
            ),
        ),
        array(
            'header' => 'تعديل',
            'class' => 'CButtonColumn',
            'template' => '{edit}',
            'buttons' => array(
                'edit' => array(
                    'label' => '<span class="glyphicon glyphicon-pencil"></span>',
                    'click' => 'js:function(event){
                        var ajaxUrl = $(this).attr("href");
                        $.ajax({
                          "url":ajaxUrl,
                          "type":"GET",
                          "success":function(data){
                            $("#damascusListEntryUpdateModal .modal-body").html(data);
                          },
                          "beforeSend":function(){
                            $("#damascusListEntryUpdateModal .modal-body").html("الرجاء الانتظار....");
                            $("#damascusListEntryUpdateModal").modal("show");
                          }
                        });
                        return false;
                    }',
                    'url' => 'Yii::app()->createUrl("damascusListEntry/getDamascusListEntryUpdateForm",array("id"=>$data->id))',
                    'options' => array(
                        'class' => 'btn btn-warning btn-sm',
                        'id'=>'link-'.uniqid(),
                    ),
                )
            )
        ),
    ))); ?>
