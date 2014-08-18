<?php
Yii::import('sa_ext.crud.JExcelView', true);
$data = $model->search(false);
$xls = new JExcelView;
$xls->all = true;
$xls->phpexcelPath = 'sa_ext.phpexcel.PHPExcel';
$xls->title = '用户列表-'.date('Ymd',time());
$xls->dataProvider = $data;
$xls->columns = array(
    'sina_uid',
    'screen_name',
	'profile_image_url',
	array(
		'name'=>'gender',
		'data'=>'$data->getAttributeTypeValue("gender")',
	),
    'statuses_count',
    'followers_count',
    'friends_count',
	'bi_followers_count',
    array(
        'name'=>'verified',
        'data'=>'$data->getAttributeTypeValue("verified")',
    ),
    'verified_reason',
	'verified_my',
	array(
        'name'=>'province',
        'data'=>'$data->getAttributeTypeValue("province")',
    ),
    array(
        'name'=>'creation_date',
        'data'=>'date("Y-m-d H:i:s", $data->creation_date)',
    ),
);
$xls->init();
$xls->run();
Yii::app()->end();
