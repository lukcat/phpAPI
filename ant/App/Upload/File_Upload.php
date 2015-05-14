<?php 
// by chendq 2015/4/29

namespace App\Upload;

// 使用别名: use Common\Response 相当于 use Common\Response as Response
use Common\Response as Response;

/**
 * @params: CommonAPI接收数据
 * @savePath：指定存储路径
 * @connect: 数据库链接句柄
 * @checkFlag: true检查上传文件是否图片类型
 * @allowExt: 允许上传文件格式
 * @maxSize: 自定义最大文件大小，与php.ini中的设置同时起作用
 */

class File_Upload {
	//　处理文件错误信息
	//array(bmp,jpg,tiff,gif,pcx,tga,exif,fpx,svg,psd,cdr,pcd,dxf,ufo,eps,ai,raw)
	protected function processErr($params, $checkFlag=false, $allowExt=array('bmp','jpg','tiff','gif','pcx','tga','exif','fpx','svg','psd','cdr','pcd','dxf','ufo','eps','ai','raw'), $maxSize) {

		if (is_string($params['fileerror'])) {	// 数据接收模块Common\CommonAPI中默认值是空string
			Response::show(714, 'No file uploaded');
		}
		if($params['fileerror'] > 0 ) {
			 switch ($params['fileerror']) {
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
		} else {

			// 检测文件大小是否合法
			if ($params['filesize'] > $maxSize) {
				Response::show(708, 'file uploaded is too large');
			}

			// 检查文件扩展名是否合法
			$ext = strtolower(pathinfo($params['filename'],PATHINFO_EXTENSION));
			if (!in_array($ext, $allowExt)) {
				Response::show(709, 'illegal file type');
			}

			// 检查文件是否为图片
			if ($checkFlag) {
				if (!getimagesize($params['filetmpname'])) {
					Response::show(710, 'File is not image');
				}
			}
		}

	}

	public function uploadFile($params, $connect, $savePath='uploads', $checkFlag=true, $allowExt=array('jpg','jpeg','png','gif','bmp'), $maxSize=52428800) {

		//Response::show(1,"enter uploadFile");

		// 处理错误信息
		//var_dump($params);

		// 去除目录尾部的'/'
		//$trimElement = '/';
		//$savePath = rtrim($savePath,$trimElement);

		// 检查目录是否存在
		if (!file_exists($savePath)) {
			mkdir($savePath,0777,true);
			chmod($savePath,0777);
		}

		// 错误检测
		$this->processErr($params, $checkFlag, $allowExt, $maxSize);
		//Response::show(2,"enter uploadFile");

		/////// formate data of params for insert
		$username ='"'.$params['username'].'"';
		$originname = '"'.$params['filename'].'"';
		$filetmpname = '"'.$params['filetmpname'].'"';
		$filetype = '"'.$params['filetype'].'"';
		$filesize = '"'.$params['filesize'].'"';
		$description = '"'."this is description".'"';

		// ensure imageid and file local name is unique
		$imageid = '"'.$params['username']. date('Y/m/d-H:i:s') . 'R' . rand(). $params['filename'] . '"';
		$localname = '"'.$params['username']. date('YmdHis') . 'R' . rand(). $params['filename'] . '"';

		// get real path
		$realSavePath = realpath($savePath);

		// for database value
		$filepath = '"' . $realSavePath . '/' . trim($localname,'"') . '"';

		$fileerror = $params['fileerror'];

		$field = "imageid, originname, localname, type, path, size, description";
		$value = $imageid . ',' . $originname . ',' . $localname . ',' . $filetype . ',' . $filepath . ',' . $filesize . ',' .$description;

		//echo "value is: ".$value;

		// query sentance
		$insert_sql = 'insert into file ('.$field.') values ('.$value.')';

		// 
		$destination = $realSavePath . '/' . trim($localname,'"');
		//if ($fileerror == UPLOAD_ERR_OK) {		// file upload ok
		//Response::show(5,$params['filetmpname']);
		if(move_uploaded_file($params['filetmpname'], $destination)) {
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
			Response::show(711, 'File storage failure');
		}
	}
}

