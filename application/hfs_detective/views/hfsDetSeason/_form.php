<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'hfs-det-season-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'season'); ?>
		<?php echo $form->textField($model,'season',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'season'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'answer'); ?>
		<?php echo $form->textField($model,'answer',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'answer'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'starttime'); ?>
		<?php echo $form->textField($model,'starttime',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'starttime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'endtime'); ?>
		<?php echo $form->textField($model,'endtime',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'endtime'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'answer_pub_time'); ?>
		<?php echo $form->textField($model,'answer_pub_time',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'answer_pub_time'); ?>
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