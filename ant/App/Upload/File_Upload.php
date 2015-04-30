<?php 
// by chendq 2015/4/29

namespace App\Upload;


// params: CommonAPI接收数据
// savePath：指定存储路径
// connect: 数据库链接句柄

// 使用别名: use Common\Response 相当于 use Common\Response as Response
use Common\Response as Response;

class File_Upload {

	public function saveFile($params, $savePath, $connect) {
		//echo 'enter saveFile';
		//Reponse::show(002, 'test saveFile function');
		var_dump($params);

		/////// formate data of params for insert
		$username ='"'.$params['username'].'"';
		$originname = '"'.$params['filename'].'"';
		$filetmpname = '"'.$params['filetmpname'].'"';
		$filetype = '"'.$params['filetype'].'"';
		$filesize = '"'.$params['filesize'].'"';
		$description = '"'."this is description".'"';
		// ensure imageid and file local name is unique
		//$loacalname = $imageid = '"'.$params['username']. date('H:i:s') . rand(). $params['filename'] . '"';
		$imageid = '"'.$params['username']. date('Y/m/d-H:i:s') . 'R' . rand(). $params['filename'] . '"';
		$localname = '"'.$params['username']. date('YmdHis') . 'R' . rand(). $params['filename'] . '"';
		$filepath = '"' . $savePath . $params['filename'] . '"';

		$fileerror = $params['fileerror'];

		// formate save path, check the varidation of filepath
		// TODO

		//echo "imageid is: " . $imageid;
		//echo "path is : " . $savePath.$filename;
		//echo "fileTmpName is: ".$fileTmpName;

		$field = "imageid, originname, localname, type, path, size, description";
		$value = $imageid . ',' . $originname . ',' . $localname . ',' . $filetype . ',' . $filepath . ',' . $filesize . ',' .$description;

		// query sentance
		//$insert_sql = 'insert into file (imageid, name, type, path, size) values (' . $imageid . ',' . $filename . ',' . $filetype . ',' . $filepath . ',' . $filesize . ')';
		$insert_sql = 'insert into file ('.$field.') values ('.$value.')';
		//echo "insertsql is: ".$insert_sql;
		$localSavePath = $savePath . trim($localname,'"');
		echo "local path is: " . $localSavePath;

		if ($fileerror == UPLOAD_ERR_OK) {		// file upload ok
			if(move_uploaded_file($params['filetmpname'], $localSavePath)) {
				if (!$result = mysql_query($insert_sql, $connect)) {
					//throw new Exception('Mysql query error: ' . mysql_error());
					// response message to client
					// query error occur
					Response::show(501,'File_Upload: query database by name error');
				}
				// upload OK
				Response::show(700,'File uploaded successful');
			} else {
				// move_uploaded_file error occur
				Response::show(708, 'File storage failure');
			}
		} else {	// upload error occur
			switch ($fileerror) {
				case 1:
					// 上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值
					Response::show(701, 'uploaded file exceeds upload_max_filesize whick defined in php.ini');
					break;
				case 2:
					// 上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值
					Response::show(702, 'uploaded file exceeds MAX_FILE_SIZE which defined in client');
					break;
				case 3:
					// 文件只有部分被上传
					Response::show(703, 'file was partially uploaded');
					break;
				case 4:
					//没有文件被上传
					Response::show(704, 'No file uploaded');
					break;
				case 6:
					// 找不到临时文件夹
					Response::show(706, 'temporary folder can not be find');
					break;
				case 7:
					// 文件写入失败'
					Response::show(707, 'file write failure');
					break;
			}
		}
	}
}

