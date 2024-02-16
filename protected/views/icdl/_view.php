<?php
/* @var $this IcdlController */
/* @var $data ICDLCard */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('first_name_en')); ?>:</b>
	<?php echo CHtml::encode($data->first_name_en); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_name_en')); ?>:</b>
	<?php echo CHtml::encode($data->last_name_en); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('un_code')); ?>:</b>
	<?php echo CHtml::encode($data->un_code); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('payment')); ?>:</b>
	<?php echo CHtml::encode($data->payment); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('lang')); ?>:</b>
	<?php echo CHtml::encode($data->lang); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('student_id')); ?>:</b>
	<?php echo CHtml::encode($data->student_id); ?>
	<br />

	*/ ?>

</div>