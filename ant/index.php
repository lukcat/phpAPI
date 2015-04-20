<?php
// By Chendq 2015/4/20

define('BASEDIR',__DIR__);

require_once(BASEDIR . '/App/Login/Mobile_Login.php');
require_once(BASEDIR . '/Common/Response.php');
require_once(BASEDIR . '/Common/Db.php');
require_once(BASEDIR . '/Common/CommonAPI.php');

// 检查客户端上传参数,数据接口为params数组
$check = new Common\CommonAPI();
$check->check();

// 生成数据库句柄
//$connect = Common\Db::getInstance()->connect();
try {
	$connect = Db::getInstance()->connect();
} catch (Exception $e) {
	echo "error ocurrs: " , $e;
}

// 用户登录
$sql = 'select name, password from login where name = ' . '"' . $check->params["username"] . '"';
$result = mysql_query($sql, $connect);

if ($rows = mysql_fetch_array($result, MYSQL_ASSOC)) {
	if ($rows['password'] == $check->params['password']) {
		echo "You have permission to access";
	}
}
