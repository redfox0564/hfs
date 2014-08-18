<?php
$this->breadcrumbs=array(
	'Hfs Det Pubwinners'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List HfsDetPubwinner', 'url'=>array('index')),
	array('label'=>'Manage HfsDetPubwinner', 'url'=>array('admin')),
);
?>

<h1>Create HfsDetPubwinner</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>