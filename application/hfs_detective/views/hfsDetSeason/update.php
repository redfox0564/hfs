<?php
$this->breadcrumbs=array(
	'Hfs Det Seasons'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List HfsDetSeason', 'url'=>array('index')),
	array('label'=>'Create HfsDetSeason', 'url'=>array('create')),
	array('label'=>'View HfsDetSeason', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage HfsDetSeason', 'url'=>array('admin')),
);
?>

<h1>Update HfsDetSeason <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>