<h1>修改:<?php echo $model->id; ?></h1>
<?php
$this->widget('sa_ext.crud.JCrudForm', array(
        'model'=>$model,
        'htmlOptions'=>array(
            'style'=>'padding-top:4px'
        ),
        'columns'=>array(
            'name',
            'phone',
            array(
                'name' => 'type',
                'type' => 'dropdownlist',
            ),
            array(
                'name' => 'win_seasonid',
                'type' => 'dropdownlist',
            ),
        )
    )
);
?>
