<?php
$this->breadcrumbs=array(
	'Hfs Det Clues',
);

$this->menu=array(
	array('label'=>'Create HfsDetClue', 'url'=>array('create')),
	array('label'=>'Manage HfsDetClue', 'url'=>array('admin')),
);
?>

<h1>Hfs Det Clues</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
