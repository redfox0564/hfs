<?php
$this->breadcrumbs=array(
	'Hfs Det Clues'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List HfsDetClue', 'url'=>array('index')),
	array('label'=>'Manage HfsDetClue', 'url'=>array('admin')),
);
?>

<h1>Create HfsDetClue</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>