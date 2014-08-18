<?php
$this->breadcrumbs=array(
    'LinkLog列表',
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
        	'user_id',
        	'link_id',		
        ),
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
    'toolbar'=>array(
		array('template'=>'<a class="k-button" href="javascript:;" onclick="selectAll();">全选</a>'),
		array('template'=>'<a class="k-button" href="javascript:;" onclick="unselect();">反选</a>'),
		array('template'=>'<a class="k-button" href="javascript:;" onclick="deleteSelectAll(\''.$this->createUrl('ajaxDelete').'&id='.'\');">批量删除</a>'),
    ),
    'columns'=>array(
		array(
    		'name'=>'ck_id',
    		'title'=>' '
    	),
        array('name' => 'id','sortable' => true,),
        array('name' => 'user_id','sortable' => true,),
        array('name' => 'link_id','sortable' => true,),
        array('name' => 'other_id','sortable' => true,),
        array('name' => 'creation_date','sortable' => true,),
        array(
            'command' => array(//按钮
                array('text'=> '删除','click'=>'toDeleteFromRelurl','attr'=>array('evalurl'=>"'".$this->createUrl('ajaxDelete').'&id='."' + dataItem.id")),
            ),
        )
    ),
));

