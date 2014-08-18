<h1>修改:<?php echo $model->id; ?></h1>
<?php
$this->widget('sa_ext.crud.JCrudForm', array(
        'model'=>$model,
        'htmlOptions'=>array(
            'style'=>'padding-top:4px'
        ),
        'columns'=>array(
            array(
                'name' => 'clue_id',
                'type' => 'dropdownlist',
            ),
            array(
                'name' => 'season_id',
                'type' => 'dropdownlist',
            ),
            array(
                'name' => 'clue_type',
                'type' => 'dropdownlist',
            ),
            array(
                'name' => 'clue_addr',
                'type' => 'imagefile',
            ),
            array(
                'name' => 'starttime',
                'type' => 'datetime',
            ),
        )
    )
);
?>
