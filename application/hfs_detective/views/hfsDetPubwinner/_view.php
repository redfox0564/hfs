<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('phone')); ?>:</b>
	<?php echo CHtml::encode($data->phone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('win_seasonid')); ?>:</b>
	<?php echo CHtml::encode($data->win_seasonid); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('win_time')); ?>:</b>
	<?php echo CHtml::encode($data->win_time); ?>
	<br />


</div>