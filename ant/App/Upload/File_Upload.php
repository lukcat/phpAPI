<?php 

namespace App\Upload;

// 使用别名: use Common\Response 相当于 use Common\Response as Response
use Common\Response;
//header('content-type:text/html;charset=utf-8');

class File_Upload {

	function saveFile($params, $savePath, $connect) {
		/////// get file information from parameters 
		$username = $params['username'];
		$filename = $params['filename'];
		$filetmpname = $params['filetmpname'];
		$filetype = $params['filetype'];
		$filesize = $params['filesize'];
		$fileerror = $params['fileerror'];

		// formate save path 
		// TODO

		// generate imageid
		$imageid = $username . $filename . date('H:i:s') . rand();

		$insert_sql = 'insert into file (imageid, name, type, path, size) values (' . $imageid . ',' . $filename . ',' . $filetype . ',' . $savePath . ',' . $filesize . ')';
		if ($fileerror == UPLOAD_ERR_OK) {		// file upload ok
			if(move_uploaded_file($fileTmpName,$savePath.$filename)) {
				if (!$result = mysql_query($insert_sql, $connect)) {
					throw new Exception('Mysql query error: ' . mysql_error());
					// response message to client
					// query error occur
					Response::show(501,'Mobile_Register: query database by name error');
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

// 1. move file 
//move_uploaded_file($fileTmpName,'./uploads/'.$filename);

//2. copy file
//copy($fileTmpName, './uploads/'.$filename);


