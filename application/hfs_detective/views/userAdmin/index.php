<?php
$this->breadcrumbs=array(
    '用户列表',
);

$this->widget('sa_ext.kui.CKuiWindow', array(
	'id'=>'mydialog',
	'content'=>'',
	'htmlOptions'=>array(
		'style'=>'display:none;',
	),
	'options'=>array(
		'title'=>'详情',
		'width'=>500,
		'height'=>450,
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
            'screen_name',
       	),
    	array(
    		'gender',
    		'verified',
    		'verified_my',
    		'province',
    	),
    )
));

// 按钮
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
        array(
            'name'=>'sina_uid',
            'sortable'=>true,
        ),
        'screen_name',
        'profile_image_url',
    	array(
    		'name'=>'gender',
    		'sortable'=>true,
    	),
        array(
            'name'=>'statuses_count',
            'sortable'=>true,
        ),
        array(
            'name'=>'followers_count',
            'sortable'=>true,
        ),
        array(
            'name'=>'friends_count',
            'sortable'=>true,
        ),
    	array(
    		'name'=>'bi_followers_count',
    		'sortable'=>true,	
    	),
      	array(
      		'name'=>'verified',
      		'sortable'=>true,
      	),
        'verified_reason',
    	array(
    		'name'=>'verified_my',
    		'sortable'=>true,
    	),
    	'province',
        array(
            'name'=>'creation_date',
            'sortable'=>true,
        ),
        array(
            'command' => array(//按钮
                array('text'=>'详情','click'=>'toShowFromRelurl','attr'=>array('evalurl'=>"'".$this->createUrl('view').'&id='."' + dataItem.sina_uid")),
                array('text'=>'修改','click'=>'toShowFromRelurl','attr'=>array('evalurl'=>"'".$this->createUrl('update').'&id='."' + dataItem.sina_uid")),
                array('text'=>'删除','click'=>'toDeleteFromRelurl','attr'=>array('evalurl'=>"'".$this->createUrl('ajaxDelete').'&id='."' + dataItem.sina_uid")),
            ),
        )
    ),
));