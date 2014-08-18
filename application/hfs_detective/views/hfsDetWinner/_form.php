<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'hfs-det-winner-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'win_seasonid'); ?>
		<?php echo $form->textField($model,'win_seasonid',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'win_seasonid'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'win_time'); ?>
		<?php echo $form->textField($model,'win_time',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'win_time'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->