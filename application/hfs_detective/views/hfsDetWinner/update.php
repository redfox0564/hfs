<?php
$this->breadcrumbs=array(
	'Hfs Det Winners'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List HfsDetWinner', 'url'=>array('index')),
	array('label'=>'Create HfsDetWinner', 'url'=>array('create')),
	array('label'=>'View HfsDetWinner', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage HfsDetWinner', 'url'=>array('admin')),
);
?>

<h1>Update HfsDetWinner <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>