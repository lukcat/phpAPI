<?php
//echo "hello world";
$imgfile=$_FILES['imgfile'];
$submitbtn=$_POST['submitbtn'];
//if($submitbtn==’OK’ and is_array($imgfile)){
if($submitbtn=='OK' or is_array($imgfile)){
	//echo "hello world";
	$name=$imgfile['name'];  //取得图片名称
	//echo $name;
	$type=$imgfile['type']; //取得图片类型
	$size=$imgfile['size'];  //取得图片长度
	$tmpfile=$imgfile['tmp_name'];  //图片上传上来到临时文件的路径
	if($tmpfile and is_uploaded_file($tmpfile)){  //判断上传文件是否为空，文件是不是上传的文件
		//读取图片流
		$file=fopen($tmpfile,"rb");
		//$imgdata=bin2hex(fread($file,$size));  //bin2hex()将二进制数据转换成十六进制表示
		$imgdata=addslashes(fread($file,$size)); 
		fclose($file);

		$mysqli=mysql_connect("localhost","root","j88j,ui7i97");  //连接数据库函数
		mysql_select_db("test");  //选择数据库
		//插入出数据库语句，图片数据前要加上0x，用于表示16进制数
		//echo $name;
		//echo "$imgdata";
		$sql = "INSERT INTO pic(caption,img) VALUES('$name','$imgdata')";
		//$sql = "insert into pic(caption,img) values('test22','25433')";
		if(mysql_query($sql)) {
			//echo “<center>插入成功！<br><br><a href=’disimage.php’>显示图片</a></center>”;
			echo "success";
		}
		else {
			//echo “<center>插入失败！</center>”;
			echo "can not insert";
		}
		mysql_close();
	}else {
		//echo “<center>请先选择图片！<br><br><a href=’image.html’>点此返回</a></center>”;
		echo "mutu error";
	}
} 
else {
	//echo “<center>请先选择图片！<br><br><a href=’image.html’>点此返回</a></center>”;
	echo "error";
}

?>
