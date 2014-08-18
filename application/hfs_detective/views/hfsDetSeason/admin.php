<?php
$this->breadcrumbs=array(
	'Hfs Det Seasons'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List HfsDetSeason', 'url'=>array('index')),
	array('label'=>'Create HfsDetSeason', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('hfs-det-season-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Hfs Det Seasons</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'hfs-det-season-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'season',
		'answer',
		'starttime',
		'endtime',
		'answer_pub_time',
		/*
		'uptime',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
