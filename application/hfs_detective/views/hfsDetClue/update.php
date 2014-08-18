<?php
$this->breadcrumbs=array(
	'Hfs Det Clues'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List HfsDetClue', 'url'=>array('index')),
	array('label'=>'Create HfsDetClue', 'url'=>array('create')),
	array('label'=>'View HfsDetClue', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage HfsDetClue', 'url'=>array('admin')),
);
?>

<h1>Update HfsDetClue <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>