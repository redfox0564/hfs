<?php
$this->breadcrumbs=array(
	'Hfs Det Winners',
);

$this->menu=array(
	array('label'=>'Create HfsDetWinner', 'url'=>array('create')),
	array('label'=>'Manage HfsDetWinner', 'url'=>array('admin')),
);
?>

<h1>Hfs Det Winners</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
