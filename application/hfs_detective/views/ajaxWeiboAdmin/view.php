<h1>查看：<?php echo $model->id; ?></h1>
<?php
$this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        array(
            'name' => 'weibo_id',
            'type' => 'Text',
        ),
        array(
            'name' => 'user_id',
            'type' => 'Text',
        ),
        array(
            'name' => 'type',
            'type' => 'Text',
        ),
        array(
            'name' => 'status',
            'type' => 'Text',
        ),
        array(
            'name' => 'is_del',
            'type' => 'Text',
        ),
        array(
            'name' => 'creation_date',
            'type' => 'Text',
            'value' => date("Y-m-d H:i:s", $model->creation_date)
        ),
    ),
));
?>
