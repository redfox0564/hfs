<?php
$this->breadcrumbs=array(
	'Hfs Det Seasons'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List HfsDetSeason', 'url'=>array('index')),
	array('label'=>'Create HfsDetSeason', 'url'=>array('create')),
	array('label'=>'Update HfsDetSeason', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete HfsDetSeason', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage HfsDetSeason', 'url'=>array('admin')),
);
?>

<h1>View HfsDetSeason #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'season',
		'answer',
		'starttime',
		'endtime',
		'answer_pub_time',
		'uptime',
	),
)); ?>
