<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('clue_id')); ?>:</b>
	<?php echo CHtml::encode($data->clue_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('season_id')); ?>:</b>
	<?php echo CHtml::encode($data->season_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('clue_type')); ?>:</b>
	<?php echo CHtml::encode($data->clue_type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('clue_addr')); ?>:</b>
	<?php echo CHtml::encode($data->clue_addr); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('starttime')); ?>:</b>
	<?php echo CHtml::encode($data->starttime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('uptime')); ?>:</b>
	<?php echo CHtml::encode($data->uptime); ?>
	<br />


</div>