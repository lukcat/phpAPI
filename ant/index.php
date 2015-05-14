<?php
// By Chendq 2015/4/20

// use aliases
use Common\Db as Db;
use Common\CommonAPI as CommonAPI;
use App\Login\Mobile_Login as Mobile_Login;
use App\Register\Mobile_Register as Mobile_Register;
use App\Upload\File_Upload as File_Upload;
use App\Inquiry\Vehicle_Inquiry as Vehicle_Inquiry;
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
//Response::show(000,$username);
//exit;

try {
	// 生成数据库句柄
	//$connect = Common\Db::getInstance()->connect();
	$connect = Db::getInstance()->connect();
} catch (Exception $e) {
	throw new Exception("Database connection error: " . mysql_error());
	//echo "error ocurrs: " , $e;
}
//$action = 'InquiryVehicle';
//$params
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
		$fu = new File_Upload();
		// spacify file storage path
		$savePath = BASEDIR . "/uploads/";
		//echo "BASEDIR: ".BASEDIR;

		// save file and insert file information into database
		//$ul->saveFile($check->params, $savePath, $connect);
		//$ul->uploadFile($check->params, $connect, $savePath);
		$fu->uploadFile($check->params, $connect);
		//echo "after saveFile";

		break;
	case 'InquiryVehicle':
		//Response::show(0,"this is InquiryVehicle");
		//$iv = new Vehicle_Inquiry();
		$iv = new Vehicle_Inquiry();
		$iv->getVehicleInfo($check->params['vehicleid'], $connect);
		Response::show(1,"this is InquiryVehicle");
		
	default:
		// no action matches
		//Common\Response::show(601,"no action");
		Response::show(601,"no action");
		break;
}

