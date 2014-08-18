<?php
return array(
    /** 默认数据库为db */
    /** mysql配置 */
    'db'=>array(
        'class' => 'CDbConnection',        // 数据库连接类
        'connectionString' => 'mysql:host=127.0.0.1;dbname=hfs_detective;port=5566',
        'emulatePrepare' => true,
        'username' => 'root',            // 数据库用户
        'password' => 'root',        // 数据库密码
        'charset' => 'utf8',            // 默认字符集
        'tablePrefix' => '',            // 表名前缀
        'schemaCachingDuration'=>3600,    // 缓存时间
    ),
    'default'=>array(
        'class' => 'CDbConnection',        // 数据库连接类
        'connectionString' => 'mysql:host=127.0.0.1;dbname=hfs_detective;port=5566',
        'emulatePrepare' => true,
        'username' => 'root',            // 数据库用户
        'password' => 'root',        // 数据库密码
        'charset' => 'utf8',            // 默认字符集
        'tablePrefix' => '',            // 表名前缀
        'schemaCachingDuration'=>3600,    // 缓存时间
    ),
    /** mssql数据库 */
    'mssqlDb'=>array(
        'class' => 'CDbConnection',
        'connectionString' => 'dblib:host=host;dbname=dbName',
        //'emulatePrepare' => false,
        'username' => 'userName',
        'password' => 'passWord',
        'charset' => 'utf8',
        'schemaCachingDuration'=>3600,
    ),
);
