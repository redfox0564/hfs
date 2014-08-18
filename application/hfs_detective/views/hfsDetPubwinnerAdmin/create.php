<?php
$this->widget('sa_ext.crud.JCrudForm', array(
    'model'=>$model,
    'htmlOptions'=>array('style'=>'padding:4px'),
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
));
