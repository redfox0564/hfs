<?php
Yii::import('sa_ext.crud.JExcelView', true);
$data = $model->search(false);
$xls = new JExcelView;
$xls->all = true;
$xls->phpexcelPath = 'sa_ext.phpexcel.PHPExcel';
$xls->title = '用户列表-'.date('Ymd',time());
$xls->dataProvider = $data;
$xls->columns = array(
    'id',
    'weibo_id',
    'user_id',
     array(
        'name' => 'type',
        'value' => '$data->getAttributeTypeValue("type")'
    ),
    'status',
    'is_del',
    array(
        'name' => 'creation_date',
        'value' => 'date("Y-m-d H:i:s", $data->creation_date)'
    ),
);
$xls->init();
$xls->run();
Yii::app()->end();