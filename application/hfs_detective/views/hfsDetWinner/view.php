<?php
$this->breadcrumbs=array(
	'Hfs Det Winners'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List HfsDetWinner', 'url'=>array('index')),
	array('label'=>'Create HfsDetWinner', 'url'=>array('create')),
	array('label'=>'Update HfsDetWinner', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete HfsDetWinner', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage HfsDetWinner', 'url'=>array('admin')),
);
?>

<h1>View HfsDetWinner #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'phone',
		'win_seasonid',
		'win_time',
	),
)); ?>
