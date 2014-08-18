<?php
$columns = array(
    'sina_uid',
    'ot_uid',
    array(
        'name' => 'type',
        'value' => '$data->getAttributeTypeValue("type")'
    ),
    array(
        'name' => 'is_del',
        'value' => '$data->getAttributeTypeValue("is_del")'
    ),
    array(
        'name' => 'creation_date',
        'value'=>'date("Y-m-d H:i:s", $data->creation_date)',
    ),
);
$kuiData->getData($model,$columns);
