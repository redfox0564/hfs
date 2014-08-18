<?php
Yii::import('sa_ext.crud.JExcelView', true);
$data = $model->search(false);
$xls = new JExcelView;
$xls->all = true;
$xls->phpexcelPath = 'sa_ext.phpexcel.PHPExcel';
$xls->title = 'HfsDetPubwinner列表-'.date('Ymd',time());
$xls->dataProvider = $data;
$xls->columns = array(
);
$xls->init();
$xls->run();
Yii::app()->end();
