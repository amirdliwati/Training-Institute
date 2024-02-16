<?php
/**
 *
 * @var $model DamascusListEntry
 * @var $this DamascusListEntryController
 *
 */
CommonFunctions::fixAjax();
Yii::app()->clientScript->registerScript("form-script", '
    $(".ok-sign").hide();
    $(".error-sign").hide();
', CClientScript::POS_END);
?>

<div class="form">
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'edit_dates',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'clientOptions' => array(
            'successCssClass' => 'has-success',
            'errorCssClass' => 'has-error',
            'validatingErrorMessage' => '',
            'inputContainer' => '.form-group',
            'afterValidateAttribute' => 'js:function(form, attribute, data, hasError){
                $("#"+attribute.inputID).siblings(".error-sign").hide();
                $("#"+attribute.inputID).siblings(".ok-sign").hide();
                if(hasError){
                    $("#"+attribute.inputID).siblings(".error-sign").show();
                }else {
                    $("#"+attribute.inputID).siblings(".ok-sign").show();
                }
            }',
        ),
        'htmlOptions' => array(
            'role' => 'form',
            'class' => 'form-horizontal',
        ),
    )); ?>
    <?php echo $form->hiddenField($model, 'id') ?>

    <div class="form-group has-feedback">
        <?php echo $form->labelEx($model, 'start_date', array('class' => 'col-md-4 control-label')); ?>
        <div class="col-md-8 input-container">
            <?php echo CHtml::textField('DamascusListEntry[start_date]',$model->getStartDate(),array('size' => 60, 'maxlength' => 255, 'class' => 'form-control'))?>

            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($model, 'start_date'); ?>
        </div>
    </div>

    <div class="form-group has-feedback">
        <?php echo $form->labelEx($model, 'end_date', array('class' => 'col-md-4 control-label')); ?>
        <div class="col-md-8 input-container">
            <?php echo CHtml::textField('DamascusListEntry[end_date]',$model->getEndDate(),array('size' => 60, 'maxlength' => 255, 'class' => 'form-control'))?>
            <span class="glyphicon glyphicon-remove form-control-feedback error-sign"></span>
            <span class="glyphicon glyphicon-ok form-control-feedback ok-sign"></span>
            <?php echo $form->error($model, 'end_date'); ?>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-offset-4 col-md-8">
            <?php echo CHtml::ajaxSubmitButton('تعديل بيانات التاريخ', $this->createUrl('updateDates'),
                array(
                    'type' => 'POST',
                    'success' => 'js:function(data){
                        $("#damascusListEntryUpdateModal").modal("hide");
                        if(data.status){
                            vex.defaultOptions.className = "vex-theme-plain";
                            vex.dialog.alert(data.message);
                            $("#damascus-list-entries-grid").yiiGridView("update");
                        }else{
                            vex.defaultOptions.className = "vex-theme-plain";
                            vex.dialog.alert(data.message);
                        }
                    }',
                    'dataType' => 'json',
                    'beforeSend' => 'js:function(xhr,setting){
                        $("#damascusListEntryUpdateModal .modal-body").html("الرجاء الانتظار...");
                    }'
                )
                , array(
                    'class' => 'btn btn-danger',
                    'id' => 'link-' . uniqid(),
                )); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->
