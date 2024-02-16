<?php
/**
 * Created by PhpStorm.
 * User: Dell 3521
 * Date: 16/05/15
 * Time: 11:16 م
 */

echo CHtml::link('<span class="glyphicon glyphicon-pencil"></span>','#',array(
    'class'=>'edit-icdl-card-link',
    'data-id'=>$model->id,
    'style'=>'color: #444; font-size: 14px;',
    'data-toggle'=>"tooltip",
    'data-placement'=>"bottom",
    'title'=>"تعديل بيانات البطاقة",
));

echo CHtml::link('<span class="glyphicon glyphicon-trash"></span>','#',array(
    'class'=>'delete-icdl-card-link',
    'data-id'=>$model->id,
    'style'=>'color: #444; font-size: 14px;margin-right: 10px;',
    'data-toggle'=>"tooltip",
    'data-placement'=>"bottom",
    'title'=>"حذف البطاقة",
));

echo CHtml::link('<span class="glyphicon glyphicon-list-alt"></span>','#',array(
    'class'=>'show-icdl-card-link',
    'data-id'=>$model->id,
    'style'=>'color: #444; font-size: 14px;margin-right: 10px;',
    'data-toggle'=>"tooltip",
    'data-placement'=>"bottom",
    'title'=>"إدارة البطاقة",
));

?>
