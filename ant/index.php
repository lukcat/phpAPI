<?php
// By Chendq 2015/4/20

// use aliases
use Common\Db as Db;
use Common\CommonAPI as CommonAPI;
use App\Login\Mobile_Login as Mobile_Login;
use App\Register\Mobile_Register as Mobile_Register;
use App\Upload\File_Upload as File_Upload;
use Common\Response as Response;

// 定义全局变量BASEDIR
define('BASEDIR',__DIR__);
include BASEDIR . '/Common/Loader.php';

// 使用PSR-0编码规范
spl_autoload_register('\\Common\\Loader::autoload');

// 检查客户端上传参数,数据接口为params数组
//$check = new Common\CommonAPI();
$check = new CommonAPI();
$check->check();

$username = $check->params['username'];
$password = $check->params['password'];

$action = $check->params['action'];

try {
	// 生成数据库句柄
	//$connect = Common\Db::getInstance()->connect();
	$connect = Db::getInstance()->connect();
} catch (Exception $e) {
	throw new Exception("Database connection error: " . mysql_error());
	//echo "error ocurrs: " , $e;
}

// 
switch($action) {
	case 'Login':
		// use App\Login\Mobile_Login class
		$ml = new Mobile_Login();

		// varify username and password
		$ml->varify($username, $password, $connect);
		break;
	case 'Register':
		// use App\Register\Mobile_Register class
		$rg = new Mobile_Register();
		$rg->register($username, $password, $connect);
		break;
	case 'Upload':
		//Response::show(001,"file upload test");
		// use App\Upload\File_Upload class
		$ul = new File_Upload();
		// spacify file storage path
		$savePath = BASEDIR . "/uploads/";
		//echo "BASEDIR: ".BASEDIR;

		// save file and insert file information into database
		//$ul->saveFile($check->params, $savePath, $connect);
		//$ul->uploadFile($check->params, $connect, $savePath);
		$ul->uploadFile($check->params, $connect);
		//echo "after saveFile";

		break;
	default:
		// no action matches
		//Common\Response::show(601,"no action");
		Response::show(601,"no action");
		break;
}

//if ($action == 'Login') {	// for user login
//	// use Mobile_Login class
//	$ml = new App\Login\Mobile_Login();
//	$ml->varify($username, $password, $connect);
//} elseif ($action == 'Register') {	// for user register
//	// use Mobile_Register class
//	$rg = new App\Register\Mobile_Register();
//	$rg->register($username, $password, $connect);
//} else {
//	Common\Response::show(601,"no action");
//}


//$rg->register('chendeqing11', '123', $connect);

//use Graphics class
//$gs = new App\Graphics\Mobile_Graphics();
//$gs->test();

//App\Login\Mobile_Login::test();

// 用户登录
/*
$find_sql = 'select name, password from login where name = ' . '"' . $check->params["username"] . '"';
if (!$result = mysql_query($sql, $connect)) {
	throw new Exception('Mysql query error: ' . mysql_error());
	// response message to client
	// TODO
}
if ($rows = mysql_fetch_array($result, MYSQL_ASSOC)) {
	if ($rows['password'] == $check->params['password']) {
		echo "You have permission to access";
		// response message to client
		// TODO
	}
}
else {
	// response message to client, include token
	// TODO
}
*/

/*
// 用户注册
// 检查用户名是否存在
//$check->params['username'] = 'chendq';
//$check->params['password'] = '123';
function nameExist($username, $connect) {
	$check_sql = 'select * from login where name = ' . '"' . $username . '"';
	//echo $check_sql;
	if (!$result = mysql_query($check_sql, $connect)) {
		// response message to client
		// TODO
		throw new Exception('Mysql query error: ' . mysql_error());
	}
	if ($rows = mysql_fetch_array($result, MYSQL_ASSOC)) {
		// response message to client
		// TODO
		//echo "already exist";
		return true;
	}
	return false;
}

if (!nameExist($check->params['username'], $connect)) {	// 名字不存在,允许注册
	$insert_sql = 'insert into login (name, password) values ('. '"' . $check->params['username'] . '"' . ',' . '"' . $check->params['password'] . '"' . ')';
	echo $insert_sql;
	if (!$result = mysql_query($insert_sql, $connect)) {
		// response message to client
		// TODO
		throw new Exception('Mysql insert error: ' . mysql_error());
	}
}
*/
