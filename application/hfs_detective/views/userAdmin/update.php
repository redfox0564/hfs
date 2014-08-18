<h1>修改用户:<?php echo $model->screen_name; ?></h1>
<img id="preview" src="<?php echo $model->profile_image_url;?>"/>
<?php
$this->breadcrumbs=array(
    '用户列表'=>array('index'),
    $model->sina_uid=>array('view','id'=>$model->sina_uid),
    '修改用户信息',
);
$this->widget('sa_ext.crud.JCrudForm', array(
        'model'=>$model,
        'htmlOptions'=>array(
            'style'=>'padding-top:4px'
        ),
        'columns'=>array(
            array(
                'name'=>'sina_uid',
                'htmlOptions'=>array(
                    'disabled'=>true,
                ),
            ),
            'screen_name',
        	'profile_image_url',
        	'gender',
            'statuses_count',
            'followers_count',
            'friends_count',
        	'bi_followers_count',
            'verified',
            'verified_reason',
            'verified_my',
        	'province',
            'is_del',
            array(
                'name'=>'creation_date',
                'value'=>date('Y-m-d H:i:s',$model->creation_date),
                'htmlOptions'=>array(
                'disabled'=>true,
            ),
        ),
    ),
    
));