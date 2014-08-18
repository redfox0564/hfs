<h1>查看用户：<?php echo $model->screen_name; ?></h1>
<?php 
$this->breadcrumbs=array(
    '用户列表'=>array('index'),
    $model->sina_uid,
);
$this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        'sina_uid',
        'screen_name',
        array(
            'name' => 'profile_image_url',
            'type' => 'Image',
        ),
    	array(
    		'name'=>'gender',
    		'value'=>$model->getAttributeTypeValue("gender"),
    	),
        'statuses_count',
        'followers_count',
        'friends_count',
    	'bi_followers_count',
    	array(
    		'name'=>'verified',
    		'value'=>$model->getAttributeTypeValue("verified"),
    	),
        'verified_reason',
        'verified_my',
    	array(
    		'name'=>'province',
    		'value'=>$model->getAttributeTypeValue("province"),
    	),
    	array(
    		'label'=>'token',
    		'value'=>$model->tokenInfo->oauth_token,
    	),
        array(
            'name'=>'is_del',
            'value'=>$model->getAttributeTypeValue("is_del"),
        ),
        array(
            'name'=>'creation_date',
            'value'=>date('Y-m-d H:i:s',$model->creation_date)
        ),
    ),
));
