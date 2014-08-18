<?php
$this->breadcrumbs=array(
	'Hfs Det Pubwinners'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List HfsDetPubwinner', 'url'=>array('index')),
	array('label'=>'Create HfsDetPubwinner', 'url'=>array('create')),
	array('label'=>'View HfsDetPubwinner', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage HfsDetPubwinner', 'url'=>array('admin')),
);
?>

<h1>Update HfsDetPubwinner <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>