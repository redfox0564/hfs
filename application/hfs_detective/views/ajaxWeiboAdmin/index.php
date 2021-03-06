<?php
$this->breadcrumbs=array(
    '分享日志列表',
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
    	array(
    		array(
    			'name'=>'creation_date',
    			'type'=>'date',
    			'htmlOptions'=>array(
    				'separator'=>'&nbsp;',
    			),
    			'data'=>array(
    				'start'=>'开始',
    				'end'=>'结束'
    			)
    		),
    	),
        array (
            'user_id',
            'type',
        ),
        array (
            'status',
        ),
        /* array(array('name'=>'weibo_id')),
        array(array('name'=>'user_id')),
        array(array('name'=>'type')),
        array(array('name'=>'creation_date')), */
    )
));

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
        array('name' => 'weibo_id','sortable' => true,),
        array('name' => 'user_id','sortable' => true,),
        array('name' => 'type','sortable' => true,),
        'status',
        'is_del',
        array('name' => 'creation_date','sortable' => true,),
        array(
            'command' => array(//按钮
                array('text'=> '详情','click'=>'toShowFromRelurl','attr'=>array('evalurl'=>"'".$this->createUrl('view').'&id='."' + dataItem.id")),
                array('text'=> '删除','click'=>'toDeleteFromRelurl','attr'=>array('evalurl'=>"'".$this->createUrl('ajaxDelete').'&id='."' + dataItem.id")),
            ),
        )
    ),
));

