<h1>查看：<?php echo $model->sina_uid; ?></h1>
<?php
$this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        array(
            'name' => 'sina_uid',
            'type' => 'Text',
        ),
        array(
            'name' => 'ot_uid',
            'type' => 'Text',
        ),
        array(
            'name' => 'type',
            'type' => 'Text',
            'value' => $model->getAttributeTypeValue("type")
        ),
        array(
            'name' => 'is_del',
            'type' => 'Text',
            'value' => $model->getAttributeTypeValue("is_del")
        ),
        array(
            'name' => 'creation_date',
            'type' => 'Text',
            'value'=>date('Y-m-d H:i:s',$model->creation_date)
        ),
    ),
));
?>
