<?php
$this->breadcrumbs=array(
	'Hfs Det Pubwinners'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List HfsDetPubwinner', 'url'=>array('index')),
	array('label'=>'Create HfsDetPubwinner', 'url'=>array('create')),
	array('label'=>'Update HfsDetPubwinner', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete HfsDetPubwinner', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage HfsDetPubwinner', 'url'=>array('admin')),
);
?>

<h1>View HfsDetPubwinner #<?php echo $model->id; ?></h1>

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
