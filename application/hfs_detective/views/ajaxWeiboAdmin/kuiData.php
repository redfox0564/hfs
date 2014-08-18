<?php
$columns = array(
    'id',
    'weibo_id',
    'user_id',
    'type',
    'status',
    'is_del',
    array(
        'name' => 'creation_date',
        'value' => 'date("Y-m-d H:i:s", $data->creation_date)'
    ),
);
$kuiData->getData($model,$columns);