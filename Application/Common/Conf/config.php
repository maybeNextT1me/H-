<?php
define('PAGE', 10);                                                         // 管理台 一页显示数据
define('REDIS_EX_TIME', 604800);                                            // redis 缓存时间
// define('CHAT_ROOM_TOTAL', 1);			                                //聊天室接口 一次请求条数
return array(
	//'配置项'=>'配置值'
    'DB_TYPE'               =>  '',                  // 数据库类型
    'DB_USER'               =>  '',     			  // 用户名
    'DB_PORT'               =>  '',        		      // 端口
    'DB_NAME'               =>  '',             // 数据库名
    'DB_HOST'               =>  '',         // 服务器地址
    'DB_PWD'                =>  '',               // 密码

    'DB_CONFIG1' => array(
        'DB_TYPE'  => '',
        'DB_USER'  => '',
        'DB_PWD'   => '',
        'DB_HOST'  => '',
        'DB_PORT'  => '',
        'DB_NAME'  => ''
    ),

    'DB_CONFIG2' => array(
        'DB_TYPE'  => '',
        'DB_USER'  => '',
        'DB_PWD'   => '',
        'DB_HOST'  => '',
        'DB_PORT'  => '',
        'DB_NAME'  => ''
    ),

    'SHOW_PAGE_TRACE' 		=>   true ,

	// 'URL_ROUTER_ON'=>ture ,  //开启路由
 //    //路由规则
 //    'URL_ROUTE_RULES'=>array(
 //    	'consult_id/:id' => 'Home/Detail/news',
 //    ),

    'URL_CASE_INSENSITIVE' =>true,              // URL 不区分大小写

    // 'TMPL_ACTION_ERROR'     =>  './Public/page/error.html', // 默认错误跳转对应的模板文件
    // 'TMPL_ACTION_SUCCESS'   =>  './Public/page/success.php', // 默认成功跳转对应的模板文件
    // 'TMPL_EXCEPTION_FILE'   =>  './Public/page/exception.html',// 异常页面的模板文件

    //'LOG_RECORD' => true,      // 日志

    // 'AUTH_CONFIG' => array(
    //     // 用户组数据表名
    //     'AUTH_GROUP' => 'auth_group',
    //     // 用户-用户组关系表
    //     'AUTH_GROUP_ACCESS' => 'auth_group_access',
    //     // 权限规则表
    //     'AUTH_RULE' => 'auth_rule',
    //     // 用户信息表
    //     'AUTH_USER' => 'employee_info'
    // ),

);
