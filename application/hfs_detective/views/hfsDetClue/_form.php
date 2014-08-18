<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'hfs-det-clue-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'clue_id'); ?>
		<?php echo $form->textField($model,'clue_id',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'clue_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'season_id'); ?>
		<?php echo $form->textField($model,'season_id',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'season_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'clue_type'); ?>
		<?php echo $form->textField($model,'clue_type'); ?>
		<?php echo $form->error($model,'clue_type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'clue_addr'); ?>
		<?php echo $form->textField($model,'clue_addr',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'clue_addr'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'starttime'); ?>
		<?php echo $form->textField($model,'starttime',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'starttime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'uptime'); ?>
		<?php echo $form->textField($model,'uptime',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'uptime'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->