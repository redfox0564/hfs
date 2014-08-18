<?php
Yii::import('sa_ext.crud.JExcelView', true);
$data = $model->search(false);
$xls = new JExcelView;
$xls->all = true;
$xls->phpexcelPath = 'sa_ext.phpexcel.PHPExcel';
$xls->title = 'LinkLog列表-'.date('Ymd',time());
$xls->dataProvider = $data;
$xls->columns = array(
    'id',
    'user_id',
    array(
        'name' => 'link_id',
        'data' => '$data->getAttributeTypeValue("gender")'
    ),
	'other_id',
    array(
        'name' => 'creation_date',
        'data' => 'date("Y-m-d H:i:s",$data->creation_date)'
    ),
);
$xls->init();
$xls->run();
Yii::app()->end();
