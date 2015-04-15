<?php
/*
 *    业务逻辑编辑区   一个账号的业务   可以列出一个 php文件  仿照我这种写法就OK
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
$page = isset($_REQUEST['page'])?$_REQUEST['page']:1;  // 当前页码
$pageSize = isset($_REQUEST['pagesize'])?$_REQUEST['pagesize']:10; //每页显示的数量
if(!is_numeric($page) || !is_numeric($pageSize)){
	return Response::show('401','数据不合法');
}
$offset = ($page - 1)*$pageSize;
$action = $_REQUEST['action'];
switch($action){
	/*
	 * 管控查询未审核订单列表
	 */ 
	case 'orderList':
		// 原生态sql语句
		$sql = "SELECT id,subject,pact_number,inputtime FROM vv_order WHERE status=2 ORDER BY id ASC LIMIT ".$offset." , ".$pageSize;    //此出差了一个要审核的订单的状态 where 未审核状态
		$query = @mysql_query($sql,$connect);
		$data = array();
		while($result = mysql_fetch_assoc($query)){
			$data[] = $result;
		}
		$weekarray=array("日","一","二","三","四","五","六");
		foreach ($data as $key => $val){
			$data[$key]['inputtime'] = date('Y年m月d H:i:s 星期'.$weekarray[date(w,$data[$key]['inputtime'])],$data[$key]['inputtime']);
		}
/* 
 * 
 * 这里可以实现  按照时间来排序     当天时间的聚合在一起
 * 因为美工设计的问题，现在已经作废
 * 已作废的代码，尼玛美工，擦擦擦！！！
 * 
 * 		$timeArr = array();
		$weekarray=array("日","一","二","三","四","五","六");
		foreach ($data as $key => $val){
			$data[$key]['inputtime'] = date('Y年m月d日 星期'.$weekarray[date('w',$data[$key]['inputtime'])],$data[$key]['inputtime']);			
			$timeArr[] = $data[$key]['inputtime'];
		}
		$timeArr = library::arrayUnique($timeArr);   //所有不一样的时间集合
		$Arr3 = array();	//最外层嵌套
		foreach ($timeArr as $key2 => $val2){
			$Arr2 = array();	//内层嵌套
			$timeOnly = $timeArr[$key2];			
			foreach ($data as $key3 => $val3){
				if($val3['inputtime'] == $timeOnly){
					$Arr2['inputtime'] = $val3['inputtime'];
					$Arr2['data'][] = $data[$key3];
				}
			}
			$Arr3[] = $Arr2;
		}
		$data = $Arr3; 
*
*/
		if(empty($data)){
			return Response::show('400','没有更多数据了');
		}
		return Response::show('200','查询订单成功',$data);
		break;
	/*
	 *  账号管理获取所有的用户
	 */
	case 'selectUserAll':
		$sql = "SELECT * FROM vv_adminuser WHERE id != 3 LIMIT ".$offset. " , " .$pageSize;
		$query = @mysql_query($sql,$connect);
		$data = array();
		while($result = mysql_fetch_assoc($query)){
			$data[] = $result;
		}
		if(empty($data)){
			return Response::show('400','没有更多数据了');
		}
		return Response::show('200','查询所有用户成功',$data);
		break;	
	/*
	 * 未填写 action 时，异常提示
	 */
	default:
		return Response::show('400','未知的请求方法');
}


















