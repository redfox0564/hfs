<?php
$this->breadcrumbs=array(
	'Hfs Det Pubwinners',
);

$this->menu=array(
	array('label'=>'Create HfsDetPubwinner', 'url'=>array('create')),
	array('label'=>'Manage HfsDetPubwinner', 'url'=>array('admin')),
);
?>

<h1>Hfs Det Pubwinners</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
