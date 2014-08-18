<?php
$this->breadcrumbs=array(
	'Hfs Det Seasons',
);

$this->menu=array(
	array('label'=>'Create HfsDetSeason', 'url'=>array('create')),
	array('label'=>'Manage HfsDetSeason', 'url'=>array('admin')),
);
?>

<h1>Hfs Det Seasons</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
