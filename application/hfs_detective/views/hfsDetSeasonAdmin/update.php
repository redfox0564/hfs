<h1>修改:<?php echo $model->id; ?></h1>
<?php
$this->widget('sa_ext.crud.JCrudForm', array(
        'model'=>$model,
        'htmlOptions'=>array(
            'style'=>'padding-top:4px'
        ),
        'columns'=>array(
            array(
                'name' => 'season',
                'type' => 'dropdownlist',
            ),
            'answer',
            array(
                'name' => 'starttime',
                'type' => 'datetime',
            ),
            array(
                'name' => 'endtime',
                'type' => 'datetime',
            ),
            array(
                'name' => 'answer_pub_time',
                'type' => 'datetime',
            ),
        )
    )
);
?>
