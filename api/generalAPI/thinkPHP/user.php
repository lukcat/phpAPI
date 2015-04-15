<?php
/*
 * userLogin用户登陆     
 */
require_once('./config.php');
try{
	$connect = Db::getInstance()->dbConnect();
}catch (Exception $e){
	return Response::show('400','数据库链接失败');
}
/*
 * 分页代码 需要传递两个参数    $page 当前页数    $pagesize 每页显示的最大条数
 */
$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;  //当前页码
$pageSize = isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:10; //每页显示的数量
if(!is_numeric($page) || !is_numeric($pageSize)){
	return Response::show('401','数据不合法');
}
$offset = ($page - 1)*$pageSize;
$action = $_REQUEST['action'];
switch($action){
	// 用户登陆
	case 'userLogin':
		$username = trim($_REQUEST['username']);
		$password = trim($_REQUEST['password']);
		if (empty($username) || empty($password)) {
			return Response::show('400','用户名或密码不能为空');
		}
		$sql = "SELECT * FROM vv_adminuser WHERE username = '$username' AND password = '$password'";
		$query = @mysql_query($sql,$connect);
		$data = array();
		while($result = mysql_fetch_assoc($query)){
			$data[] = $result;
		}
		if(empty($data)){
			return Response::show('400','登陆失败');
		}
		return Response::show('200','登陆成功',$data);
		break;
	/*
	 * 左边公共部分  查询要编辑的个人信息
	 */		
	case 'eidtUser':
		$uid=$_REQUEST['uid'];
		if(isset($uid)){     //当 AEID存在的时，查询单个AE用户信息
			return Response::show('必须要传递用户id参数');
		}
		$sql = "SELECT * FROM vv_adminuser WHERE level=3 AND id=".$uid;
		$query = @mysql_query($sql,$connect);
		$data = array();
		while($result = mysql_fetch_assoc($query)){
			$data[] = $result;
		}
		if(empty($data)){
			return Response::show('400','没有查到数据');
		}
		return Response::show('200','查询数据成功',$data);
		break;
	/*
	 * 左边公共部分  更新要编辑的个人信息
	 */
	case 'updateUser':
		$id = $_POST['uid'];
		$sql = "UPDATE vv_adminuser SET name='$name',name='$name' WHERE id=$id";
		$query = @mysql_query($sql,$connect);
		$data = array();
		while($result = mysql_fetch_assoc($query)){
			$data[] = $result;
		}
		if(empty($data)){
			return Response::show('400','没有查到数据');
		}
		return Response::show('200','查询数据成功',$data);
		break;	
	/*
	 * 左边公共部分  修改密码
	 */
	case 'editPwd':
		$sql = "";
		$query = @mysql_query($sql,$connect);
		$data = array();
		while($result = mysql_fetch_assoc($query)){
			$data[] = $result;
		}
		if(empty($data)){
			return Response::show('400','没有查到数据');
		}
		return Response::show('200','查询数据成功',$data);
		break;	
	/*
	 * 更新密码
	 */	
	case 'updatePwd':
		$sql = "";
		$query = @mysql_query($sql,$connect);
		if($query){
			return Response::show('400','更新密码成功');
		}
		return Response::show('200','更新密码失败',$data);
		break;
	/*
	 * 没有查询到的方法默认提示
	 */	
	default:
		return Response::show('400','没有该请求方法');
}






