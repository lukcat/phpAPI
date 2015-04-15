<?php
mysql_connect("localhost","root","j88j,ui7i97");
mysql_select_db("test");
//显示最新插入的那张图片
$sql = "select img from pic where idpic=(select max(idpic) from pic)";
//$sql = "select img from pic where idpic=4";
//$result=mysql_query("select img from pic where idpic=(select max(idpic) from pic)");
if ($result=mysql_query($sql)) {
	//$num = mysql_num_rows($result);
	//echo $num;
	//$data = mysql_result($result,0,"img");
	//header("Content-Type:image/jpg");
	//echo $data;
	
	$row=mysql_fetch_object($result);
	header("Content-Type:image/pjpeg");
	//header("Content-Type:image/jpg");
	echo $row->img;
	//echo $row->caption;
	//echo $row;
	mysql_close();
	echo "success";
}
else {
	echo "error";
}
?>
