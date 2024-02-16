<?php
/*
  *
  * var $model DamascusList
  * var $this DamascusListController
  *
  */
CommonFunctions::fixAjax();
?>
<?php if ($model->isNewRecord): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-info">
                <p class="note">تمت عملية إنشاء لائحة دمشق بنجاح</p>
            </div>
        </div>
    </div>
    <br/>
<?php endif; ?>
<div class="row">
    <div class="col-md-offset-2 col-md-8">
        <?php echo CHtml::link("معاينة و طباعة اللائحة رقم: " . $model->num,
            Yii::app()->createUrl('damascusList/view', array('id' => $model->id))
            , array(
                'class' => 'btn btn-success btn-lg btn-block',
            ))?>
    </div>
</div>
<br/>
<div class="row">
    <div class="col-md-offset-2 col-md-8">
        <?php echo CHtml::ajaxLink('تعديل بيانات لائحة دمشق رقم: ' . $model->num, Yii::app()->createUrl('damascusList/getUpdateForm', array('id' => $model->id)), array(
                'type' => 'GET',
                'dataType' => 'html',
                'success' => 'js:function(data){
                    $("#damascusListUpdateModal .modal-body").fadeOut(300,function(){
                        $("#damascusListUpdateModal .modal-body").html(data);
                    });
                    $("#damascusListUpdateModal .modal-body").fadeIn(500);
                }',
                'beforeSend' => 'js:function(xhr,setting){
                    $("#damascusListOptionsModal").modal("hide");
                    $("#damascusListUpdateModal .modal-body").hide();
                    $("#damascusListUpdateModal").modal("show");
                    $("#damascusListUpdateModal .modal-body").html("الرجاء الانتظار ...");
                    $("#damascusListUpdateModal .modal-body").fadeIn(500);

                }'
            ),
            array(
                'class' => 'btn btn-warning btn-lg btn-block',
                'id' => 'link-' . uniqid(),

            ))?>
    </div>
</div>
<br/>
<div class="row">
    <div class="col-md-offset-2 col-md-8">
        <?php echo CHtml::ajaxLink('حذف لائحة دمشق رقم: ' . $model->num, Yii::app()->createUrl('damascusList/delete', array('id' => $model->id)), array(
                'type' => 'POST',
                'dataType' => 'json',
                'success' => 'js:function(data){
                    if(data.status){
                        $("#damascusListUpdateModal .modal-body").html(data.message);
                        $("#damascusListUpdateModal").fadeOut(500,function(){
                            $("#damascusListUpdateModal").modal("hide");
                            $("#damascus-list-grid").yiiGridView("update");
                        });
                    }
                }',
                'beforeSend' => 'js:function(xhr,setting){
                    $("#damascusListOptionsModal").modal("hide");
                    $("#damascusListUpdateModal .modal-body").hide();
                    $("#damascusListUpdateModal").modal("show");
                    $("#damascusListUpdateModal .modal-body").html("الرجاء الانتظار ...");
                    $("#damascusListUpdateModal .modal-body").fadeIn(500);

                }'
            ),
            array(
                'class' => 'btn btn-danger btn-lg btn-block',
                'id' => 'link-' . uniqid(),
                'confirm' => 'هل انت متاكد من انك تريد حذف اللائحة وكل محتوياتها؟',

            ))?>
    </div>
</div>
