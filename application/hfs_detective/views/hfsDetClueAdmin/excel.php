<?php
Yii::import('sa_ext.crud.JExcelView', true);
$data = $model->search(false);
$xls = new JExcelView;
$xls->all = true;
$xls->phpexcelPath = 'sa_ext.phpexcel.PHPExcel';
$xls->title = 'HfsDetClue列表-'.date('Ymd',time());
$xls->dataProvider = $data;
$xls->columns = array(
    'id',
    'clue_id',
    'season_id',
    'clue_type',
    'clue_addr',
    'starttime',
    'uptime',
);
$xls->init();
$xls->run();
Yii::app()->end();
