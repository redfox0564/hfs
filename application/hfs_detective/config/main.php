<?php
$config    = array (
    'basePath'    => dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'        => '海飞丝实力音乐侦探',
    'preload'     => array('log'),
    
    //  自动导入的类
    'import' => array (
        'application.models.*',
        'application.custom.models.*',
        'application.components.*',
        'application.custom.components.*',
        'sa_ext.fun.*',
    ),
    
    'modules' => array (
        //  uncomment the following to enable the Gii tool
        'gii' => array (
            'class'         => 'system.gii.GiiModule',
            'password'      => 'root',
            'ipFilters'     => array ('192.168.5.106', '*'),
            'generatorPaths'=> include(SA_SHIQUTECH.'/config/gii.php'),
        ),
    ),

	'controllerMap'=> array (
		'kindeditor' => array (
			'class' => 'sa_ext.kindeditor.KindeditorController'
		),
	),
		
    //应用程序组件
    'components' => array (
        // 默认错误页
        'errorHandler' => array (
            'errorAction' => 'site/error',
        ),
        'user' => array (
            'class'        => 'sa_ext.JCookieWebUser.JCookieWebUser',
            'secretKey'    => array (
                'default',
                'default'
            ),
        	'authTimeout'=> 24 * 3600,
        ),
        //  微博登陆
        'weibo' => array (
            'class'     => 'application.components.WeiboLogin',
            'mustLogin' => false
        ),
        //  客户端读取
        'mobile'=>array(
            'class'=>"MobileDetect"
        ),
        //  页面模版
        'widgetFactory' => array (
            'enableSkin' => true,
            'skinPath'   => SA_SHIQUTECH.'/views/adminSkins',
        ),
    	// 临时模版配置
    	'assetManager' => array(
    		'class'     => 'STAssetManager',
    		'basePath'  => SA_APPLICATION.'/../static/admin/assets',
    		'baseUrl'   => 'http://static.app.social-touch.com/admin/assets',
    	),
    	'clientScript'=>array(
    		'class'         => 'CClientScript',
    		'coreScriptUrl' => 'http://static.app.social-touch.com/admin/assets/web-js-source'
    	),
        //  助手
        'helper' => array (
    		'class' => 'application.components.Helper',            
        ),
    		
    	//  缓存配置
    	'cache'  => array (
    		'class' => 'system.caching.CFileCache',
    	),
    	'settings'=> array(
    		'class'            => 'application.components.CmsSettings',
    		'cacheComponentId' => 'cache',
    		'cacheId'          => 'global_website_settings',
    		'cacheTime'        => 84000,
    		'tableName'        => '{{settings}}',
    		'dbComponentId'    => 'db',
    		'createTable'      => true,
    		'dbEngine'         => 'InnoDB',
    	),
    ),
    'language'          => 'zh_cn',
    'charset'           => 'UTF-8',
    'defaultController' => 'home',
        
    // 扩展参数 调用方式:Yii::app()->params[key]
    'params' => array (
        // 后台样式模版名称
        'kendo_css'         => 'default',
        // 众趣APPkey
        'wb_zhongqu'        => '2085793793',
    	// 后台静态文件URL
    	'admin_static_url'  => 'http://static.app.social-touch.com/admin',
    	//  站点地址
    	'hostInfo'          => 'http://xxx.app.social-touch.com',
    	//  静态文件URL
    	'static_url'        => 'http://m1-super-rdtest007.vm.baidu.com:8010/hfs',
    	//  静态文件版本号
    	'version'           => '2.1',
        
        //////////////  配置区域 START    //////////////
        //  [微博配置]
        //  新浪微博APPkey
        'wb_akey'       => '3713829188',
        'wb_skey'       => 'bd518129d6505c4f667225cd3a97f7f8',
    	'sub_key'       => '2962600716',
        //  微博地址
        'weibo_url'     => 'http://e.weibo.com/1762766261/app_2368147542',
        'share_url'     => 'http://#',
    	//  企业微博ID
    	'weibo_uid'     => '2792360741',//'2643306394',
        'app_signed'    => '8s1LtsXP',//'5TtsXP',
    	//  微博弹层授权回调页面
    	'redirect_uri'  => 'http://xxx.app.social-touch.com/index.php?r=home',
    		
        //  [七牛配置]
    	//  调取图片方式，true七牛云，false mosh图片
        'qbox_image'        => TRUE,
        //  图片id前两位数字，根据项目定义数字
        'qbox_image_code'   => 10,
        //  七牛云图片bucket & url
        'qbox_image_bucket' => 'customapp',
        //  七牛云域名后台设置
        'qbox_image_url'    => 'http://customapp.qiniudn.com',

        //  [管理后台配置]
    	//  后台管理员微博ID
    	'admin_id' => array (
    		'1468638990',   //  田龙哲
            '3535437867',   //  杨宏伟
            '2528852481',   //  杨宏伟
            '3541622611',   //  房皓阳
            '2355672605',   //  
    	),
        //  后台登陆密码
        'admin_password'    => '123456',

        //  [微信配置]
        'we_chat'   => array (
            'app_id'        => 'wx991799230a3820e9',
            'app_secret'    => '0dce31cf47ca7afeffbe5bd725b39979',
            'redirect_uri'  => 'http://alcon.app.social-touch.com/index.php?r=home/index',
            'state'         => 'customApp_Alcon',
            'valid_token'   => ''
        ),
        
        //  [优酷配置]
        'youku'     => array (
            'youku_client_id'       => '2de5869ee42dd525',
            'youku_client_secret'   => '2258c2dbea9417344311c539cda174fc',
        )
        //////////////  配置区域 END    //////////////
    ),
);

@include_once(dirname(__FILE__).'/menuList.php');
if (!empty($menuList)) {
    $config['params']['menuList'] = $menuList;
} else {
    $config['params']['menuList'] = '';
}
if (strstr($_SERVER['SERVER_ADDR'], '211.151.70.') || strstr($_SERVER['SERVER_ADDR'], '127.0.0.')) {
    $database = @include_once(dirname(__FILE__).'/database-local.php');
} else {
    $database = @include_once(dirname(__FILE__).'/database.php');
}
if (!empty($database)) {
    $config['components'] = @array_merge($config['components'], $database);
}
return $config;
