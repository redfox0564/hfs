<?php
$columns = array(
	array(
        'name' => 'ck_id',
        'value' => '"<input type=\"checkbox\" name=\"ck_id\" value=\"".$data->id."\">"',
    ),
    'id',
    'user_id',
    array(
        'name' => 'link_id',
        'value' => '$data->getAttributeTypeValue("link_id")'
    ),
	'other_id',
    array(
        'name' => 'creation_date',
        'value' => 'date("Y-m-d H:i:s",$data->creation_date)'
    ),
);
$kuiData->getData($model,$columns);