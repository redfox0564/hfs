<?php
$this->breadcrumbs=array(
    'UserMap列表',
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
        array(
            'sina_uid',
            'ot_uid',
            'type',
        ),
        /*array(array('name'=>'sina_uid')),
        array(array('name'=>'ot_uid')),
        array(array('name'=>'type')),
        array(array('name'=>'is_del')),
        array(array('name'=>'creation_date')),*/
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
        array(
            'name'=>'sina_uid',
            'sortable'=>true,
        ),
        array(
            'name'=>'ot_uid',
            'sortable'=>true,
        ),
        array('name' => 'type','sortable' => true,),
        array('name' => 'is_del','sortable' => true,),
        array('name' => 'creation_date','sortable' => true,),
        array(
            'command' => array(//按钮
                array('text'=> '详情','click'=>'toShowFromRelurl','attr'=>array('evalurl'=>"'".$this->createUrl('view').'&id='."' + dataItem.sina_uid")),
                array('text'=> '修改','click'=>'toShowFromRelurl','attr'=>array('evalurl'=>"'".$this->createUrl('update').'&id='."' + dataItem.sina_uid")),
                array('text'=> '删除','click'=>'toDeleteFromRelurl','attr'=>array('evalurl'=>"'".$this->createUrl('ajaxDelete').'&id='."' + dataItem.sina_uid")),
            ),
        )
    ),
));

