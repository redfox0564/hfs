<?php
Yii::import('sa_ext.crud.JExcelView', true);
$data = $model->search(false);
$xls = new JExcelView;
$xls->all = true;
$xls->phpexcelPath = 'sa_ext.phpexcel.PHPExcel';
$xls->title = 'UserMap列表-'.date('Ymd',time());
$xls->dataProvider = $data;
$xls->columns = array(
    'sina_uid',
    'ot_uid',
    array(
        'name' => 'type',
        'data' => '$data->getAttributeTypeValue("type")'
    ),
    array(
        'name' => 'is_del',
        'data' => '$data->getAttributeTypeValue("is_del")'
    ),
    array(
        'name' => 'creation_date',
        'data' => '$data->getAttributeTypeValue("creatiion_date")'
    ),
);
$xls->init();
$xls->run();
Yii::app()->end();
