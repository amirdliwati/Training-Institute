<?php
/**
 * Created by PhpStorm.
 * User: Dell 3521
 * Date: 17/05/15
 * Time: 11:26 ص
 */


?>
<div class="panel panel-default">

    <div class="panel-body">
        <?php echo CHtml::hiddenField('icdl-card-id',$model->id,array(
            'id'=>'icdl-card-id',
        ))?>
        <div class="row">
            <div class="col-md-5">
                <h5>إدارة البطاقة: <?php echo $model->un_code;?></h5>

            </div>
            <div class="col-md-7">
                <div class="row">
                    <div class="col-md-6">
                        <?php echo $model->getAttributeLabel('first_name')?>
                    </div>
                    <div class="col-md-6">
                        <?php echo $model->first_name;?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <?php echo $model->getAttributeLabel('last_name')?>
                    </div>
                    <div class="col-md-6">
                        <?php echo $model->last_name;?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <?php echo $model->getAttributeLabel('father_name')?>
                    </div>
                    <div class="col-md-6">
                        <?php echo $model->father_name;?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <?php echo $model->getAttributeLabel('first_name_en')?>
                    </div>
                    <div class="col-md-6">
                        <?php echo $model->first_name_en;?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <?php echo $model->getAttributeLabel('last_name_en')?>
                    </div>
                    <div class="col-md-6">
                        <?php echo $model->last_name_en;?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <?php echo $model->getAttributeLabel('payment')?>
                    </div>
                    <div class="col-md-6">
                        <?php echo $model->payment;?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <?php echo $model->getAttributeLabel('lang')?>
                    </div>
                    <div class="col-md-6">
                        <?php echo $model->getLanguageText();?>
                    </div>
                </div>
            </div>
        </div>
        <hr/>
        <a href="#" class="back btn btn-sm btn-default">رجوع</a>
        <a href="#" class="create-icdl-ticket btn-sm btn btn-success">إدخال تذكرة امتحان جديدة</a>
        <hr/>
        <div class="row">
            <div class="col-md-12 ticket-list-container">
                <?php echo $this->renderPartial('partial/ticket-list',array(
                    'model'=>$model,
                ),false,true);?>
            </div>
        </div>
    </div>
</div>