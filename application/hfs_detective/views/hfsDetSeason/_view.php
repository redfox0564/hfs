<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('season')); ?>:</b>
	<?php echo CHtml::encode($data->season); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('answer')); ?>:</b>
	<?php echo CHtml::encode($data->answer); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('starttime')); ?>:</b>
	<?php echo CHtml::encode($data->starttime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('endtime')); ?>:</b>
	<?php echo CHtml::encode($data->endtime); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('answer_pub_time')); ?>:</b>
	<?php echo CHtml::encode($data->answer_pub_time); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('uptime')); ?>:</b>
	<?php echo CHtml::encode($data->uptime); ?>
	<br />


</div>