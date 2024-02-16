<?php CommonFunctions::fixAjax(); ?>
<?php if($ref=="waiting_list"):?>
<div class="row">
    <div class="col-md-offset-2 col-md-8">
        <?php echo CHtml::link("العودة الى ملف الطالب الشخصي",
            $this->createUrl('student/view', array('id' => $student_id))
            , array(
                'class' => 'btn btn-success btn-lg btn-block',
            ))?>
    </div>
</div>
<br/>

<?php endif;?>

<div class="row">
    <div class="col-md-offset-2 col-md-8">
        <?php echo CHtml::ajaxLink("حذف الطالب من الانتظار",
            Yii::app()->createUrl('student/deleteFromRegistration', array('sId' => $student_id, 'cTId' => $course_type_id,'ref'=>$ref)),
            array(
                'dataType' => 'json',
                'success' => 'js:function(data){
                 $("#registrationOptionsModal").modal("hide");

                vex.defaultOptions.className = "vex-theme-plain";
                    if(data.status){
                        vex.dialog.alert(data.message);
                        if(data.ref=="student_profile"){
                            $("#waiting-course-grid").yiiGridView("update");
                        }else{
                            $("#app_grid").yiiGridView("update", {
                                data: $(".search-form form").serialize()
                            });
                        }
                    }else{
                        vex.dialog.alert(data.message);
                    }
                }',
                'beforeSend' => 'js:function(){
                    $("#registrationOptionsModal .modal-body").html("الرجاء الانتظار");
                }'
            )
            , array(
                'class' => 'btn btn-danger btn-lg btn-block',
                'confirm' => 'هل انت متاكد من انك تريد حذف الطالب من الانتظار؟',
                'id' => 'link-' . uniqid(),
            ))?>
    </div>
</div>
<br/>

