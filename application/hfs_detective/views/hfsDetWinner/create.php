<?php
$this->breadcrumbs=array(
	'Hfs Det Winners'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List HfsDetWinner', 'url'=>array('index')),
	array('label'=>'Manage HfsDetWinner', 'url'=>array('admin')),
);
?>

<h1>Create HfsDetWinner</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>