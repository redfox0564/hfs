<h1>修改:<?php echo $model->sina_uid; ?></h1>
<?php
$this->widget('sa_ext.crud.JCrudForm', array(
        'model'=>$model,
        'htmlOptions'=>array(
            'style'=>'padding-top:4px'
        ),
        'columns'=>array(
            'sina_uid',
            'ot_uid',
            array(
                'name' => 'type',
                'type' => 'dropdownlist',
            ),
            array(
                'name' => 'is_del',
                'type' => 'dropdownlist',
            ),
        )
    )
);
?>
