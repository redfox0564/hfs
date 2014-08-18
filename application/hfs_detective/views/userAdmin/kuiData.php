<?php
$columns = array(
	array(
		'name' => 'ck_id',
		'value' => '"<input type=\"checkbox\" name=\"ck_id\" value=\"".$data->sina_uid."\">"',
	),
    'sina_uid',
    'screen_name',
    array(
        'name'=>'profile_image_url',
        'value'=>'"<a href=\"http://weibo.com/u/".$data->sina_uid."\" target=\"_blank\" title=\"\"><img src=\"".$data->profile_image_url."\" width=\"50\" height=\"50\"></a>"',
    ),
	array(
		'name'=>'gender',
		'value'=>'$data->getAttributeTypeValue("gender")',
	),
    'statuses_count',
    'followers_count',
    'friends_count',
	'bi_followers_count',
    array(
        'name'=>'verified',
        'value'=>'$data->getAttributeTypeValue("verified")',
    ),
    'verified_reason',
	array(
		'name'=>'verified_my',
		'value'=>'$data->getAttributeTypeValue("verified_my")',	
	),
	array(
		'name'=>'province',
		'value'=>'$data->getAttributeTypeValue("province")',
	),
    array(
        'name'=>'creation_date',
        'value'=>'date("Y-m-d H:i:s", $data->creation_date)',
    ),
);
$kuiData->getData($model, $columns);