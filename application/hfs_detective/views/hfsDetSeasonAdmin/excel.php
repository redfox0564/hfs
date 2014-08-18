<?php
Yii::import('sa_ext.crud.JExcelView', true);
$data = $model->search(false);
$xls = new JExcelView;
$xls->all = true;
$xls->phpexcelPath = 'sa_ext.phpexcel.PHPExcel';
$xls->title = 'HfsDetSeason列表-'.date('Ymd',time());
$xls->dataProvider = $data;
$xls->columns = array(
    'id',
    'season',
    'answer',
    'starttime',
    'endtime',
    'answer_pub_time',
);
$xls->init();
$xls->run();
Yii::app()->end();
