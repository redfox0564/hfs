<?php
$this->breadcrumbs=array(
	'Hfs Det Clues'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List HfsDetClue', 'url'=>array('index')),
	array('label'=>'Create HfsDetClue', 'url'=>array('create')),
	array('label'=>'Update HfsDetClue', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete HfsDetClue', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage HfsDetClue', 'url'=>array('admin')),
);
?>

<h1>View HfsDetClue #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'clue_id',
		'season_id',
		'clue_type',
		'clue_addr',
		'starttime',
		'uptime',
	),
)); ?>
