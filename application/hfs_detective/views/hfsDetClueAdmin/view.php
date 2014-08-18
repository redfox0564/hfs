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
            'name' => 'clue_id',
            'type' => 'Text',
        ),
        array(
            'name' => 'season_id',
            'type' => 'Text',
        ),
        array(
            'name' => 'clue_type',
            'type' => 'Text',
        ),
        array(
            'name' => 'clue_addr',
            'type' => 'Image',
        ),
        array(
            'name' => 'starttime',
            'type' => 'Text',
        ),
        array(
            'name' => 'uptime',
            'type' => 'Text',
        ),
    ),
));
?>
