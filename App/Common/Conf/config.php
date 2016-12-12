<?php
return array(
    'DEFAULT_MODULE'     => 'Home',

	//'配置项'=>'配置值'
    /* 数据库配置 */
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => '127.0.0.1', // 服务器地址
    'DB_NAME'   => 'marry', // 数据库名
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => '12345678',  // 密码
    'DB_PORT'   => '3306', // 端口
    'DB_PREFIX' => 'love_', // 数据库表前缀

    'tongxue_type' => array(
      1 => '小学',
      2 => '初中',
      3 => '高中',
      4 => '大学',
      5 => '同事',
      6 => '亲戚',
      7 => '其他'
    ),

    /* 模板相关配置 */
    'TMPL_PARSE_STRING' => array(
        '__STATIC__' => __ROOT__ . '/Public/static',
        '__IMG__'    => __ROOT__ . '/Public/Home/images',
        '__CSS__'    => __ROOT__ . '/Public/Home/css',
        '__JS__'     => __ROOT__ . '/Public/Home/js'
    ),
);