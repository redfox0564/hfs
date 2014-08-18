<style>
.title {
	font-size:18px;
}
.fix_ul {
	padding-left:10px;
}
span.lb{
	width:100px;display:inline-block
}
.fix img{width:50px;}
.fix{margin:5px;}
.fix input{width:300px; padding-left:5px;}
</style>
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'baby-apply-form',
    'enableAjaxValidation'=>false,
    'htmlOptions'=>array(
        'enctype'=>'multipart/form-data'
    )
)); ?>
<div>
	<span class='title'>TITEL</span>
	<ul class='fix_ul'>
		<li class="fix">
			<span class="lb">INPUT:</span> 
			<?php echo CHtml::textField('Settings[input]', $settings['input']); ?>
		</li>
		<li class="fix">
			<span class="lb">FILE: </span>
			<?php echo CHtml::fileField('SettingsFile[pic]'); ?>
			<?php if($settings['pic']): ?>
			<?php echo CHtml::image(ImageManage::image_url($settings['pic']), '', array('width'=>50, 'height'=>50));?>
	    	<?php endif;?>
		</li>
		<li class="fix">
			<span class="lb">配对结果辅助数:</span> 
			<?php echo CHtml::textField('Settings[match_num]', $settings['match_num']); ?>
		</li>
	</ul>
</div>
<?php echo CHtml::submitButton('保存设置')?>
<?php $this->endWidget('CActiveForm');?>
