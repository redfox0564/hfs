<?php
$this->breadcrumbs=array(
    'HfsDetClue列表',
);
$this->widget('sa_ext.kui.CKuiWindow', array(
    'id'=>'mydialog',
    'content'=>'',
    'htmlOptions'=>array(
        'style'=>'display:none;',
    ),
    'options'=>array(
        'title'=>'',
        'width'=>800,
        'height'=>550,
        'autoOpen'=>false,
        'close' => 'onClose',//弹窗关闭时，调用函数
    ),
));

//搜索框属性
$this->widget('sa_ext.crud.JCrudSearch', array(
    'method'=>'get',
    'model'=>$model,
    'action'=>$this->createUrl('index'),
    'columns'=>array(
        array(array('name'=>'id')),
        array(array('name'=>'clue_id')),
        array(array('name'=>'season_id')),
        array(array('name'=>'clue_type')),
        array(array('name'=>'clue_addr')),
        array(array('name'=>'starttime')),
    )
));

$this->widget('sa_ext.kui.CKuiButton',
    array(
        'name' => 'add',
        'buttonType' => 'button',
        'caption' => '添加',
        'onclick' => 'toShowFromRelurl(e)',
        'htmlOptions'=>array(
            'relUrl'=>$this->createUrl('create')
        )
    )
);
$this->widget('sa_ext.kui.CKuiButton',
    array(
        'name' => 'getList',
        'buttonType' => 'link',
        'caption' => '导出列表',
        'url' => $this->createUrl('GetExcelFile',array(get_class($model)=>isset($_GET[get_class($model)])?$_GET[get_class($model)]:'')),
    )
);
$this->widget('sa_ext.kui.CKuiGridNew', array(
    'id'=>'grid',
    'dataProvider'=>$model,
    'readUrl' => $this->createUrl('kuiGridData'),//数据读取地址
    'columns'=>array(
        array('name' => 'id','sortable' => true,),
        array('name' => 'clue_id','sortable' => true,),
        array('name' => 'season_id','sortable' => true,),
        array('name' => 'clue_type','sortable' => true,),
        array('name' => 'clue_addr','sortable' => true,),
        array('name' => 'starttime','sortable' => true,),
        array('name' => 'uptime','sortable' => true,),
        array(
            'command' => array(//按钮
                array('text'=> '详情','click'=>'toShowFromRelurl','attr'=>array('evalurl'=>"'".$this->createUrl('view').'&id='."' + dataItem.id")),
                array('text'=> '修改','click'=>'toShowFromRelurl','attr'=>array('evalurl'=>"'".$this->createUrl('update').'&id='."' + dataItem.id")),
                array('text'=> '删除','click'=>'toDeleteFromRelurl','attr'=>array('evalurl'=>"'".$this->createUrl('ajaxDelete').'&id='."' + dataItem.id")),
            ),
        )
    ),
));

