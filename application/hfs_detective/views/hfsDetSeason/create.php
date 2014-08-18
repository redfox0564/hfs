<?php
$this->breadcrumbs=array(
	'Hfs Det Seasons'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List HfsDetSeason', 'url'=>array('index')),
	array('label'=>'Manage HfsDetSeason', 'url'=>array('admin')),
);
?>

<h1>Create HfsDetSeason</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>