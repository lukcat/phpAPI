<?php
// By Chendq 2015/4/29

define('BASEDIR',__DIR__);

include BASEDIR . '/Common/Loader.php';

// 使用PSR-0编码规范
spl_autoload_register('\\Common\\Loader::autoload');


// 生成数据库句柄
//$connect = Common\Db::getInstance()->connect();
try {
	$connect = Common\Db::getInstance()->connect();
} catch (Exception $e) {
	throw new Exception("Database connection error: " . mysql_error());
	//echo "error ocurrs: " , $e;
}

createFileTable($connect);


//////////////////////////////////////////////////////////////
/////////////////////create table file //////////////////////
function createFileTable($conn) {
	$field = 'imageid char(50) not null primary key, localname varchar(512), originname varchar(512),type varchar(50), size int, path varchar(512), time timestamp not null default now(), description text, userid char(50)';
	$sql = 'create table file (' . $field . ')';
	if (!$result = mysql_query($sql, $conn)) {
		throw new Exception('Mysql query error: ' . mysql_error());
		// response message to client
		// 数据库查询失败，返回错误信息，同时退出程序
		//Response::show(501,'Mobile_Register: query database by name error');
		exit;
	}
}
