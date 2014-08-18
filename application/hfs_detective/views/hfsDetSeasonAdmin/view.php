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
            'name' => 'season',
            'type' => 'Text',
        ),
        array(
            'name' => 'answer',
            'type' => 'Text',
        ),
        array(
            'name' => 'starttime',
            'type' => 'Text',
        ),
        array(
            'name' => 'endtime',
            'type' => 'Text',
        ),
        array(
            'name' => 'answer_pub_time',
            'type' => 'Text',
        ),
    ),
));
?>
