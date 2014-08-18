<h1>查看：<?php echo $model->id; ?></h1>
<?php
$this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        array(
            'name' => 'id',
            'type' => 'Text',
        ),
        array(
            'name' => 'name',
            'type' => 'Text',
        ),
        array(
            'name' => 'phone',
            'type' => 'Text',
        ),
        array(
            'name' => 'type',
            'type' => 'Text',
        ),
        array(
            'name' => 'win_seasonid',
            'type' => 'Text',
        ),
        array(
            'name' => 'win_time',
            'type' => 'Text',
        ),
    ),
));
?>
