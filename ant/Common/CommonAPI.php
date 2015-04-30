<?php
// by chendq 2015/4/21

namespace Common;
/**
 * 处理接口公共业务
 */

class CommonAPI {
	public $params;
	public $app;
	public function check() {

		///////////////////////////////////////////////////////////
		/////////////// user login and register ///////////////////
		$this->params['username'] = $username = isset($_POST['username']) ? $_POST['username'] : '';
		$this->params['password'] = $password = isset($_POST['password']) ? $_POST['password'] : '';
		$this->params['action'] = $action = isset($_POST['action']) ? $_POST['action'] : '';

		///////////////////////////////////////////////////////////////////////
		////////////////////// for single file upload ////////////////////////
		$fileInfo = $_FILES;
		$id = 'myfile';
		$myfile = $fileInfo[$id];
		$this->params['filename'] = $filename = isset($myfile['name']) ? $myfile['name'] : '';
		$this->params['filetmpname'] = $filetmpname = isset($myfile['tmp_name']) ? $myfile['tmp_name'] : '';
		$this->params['filetype'] = $filetype = isset($myfile['type']) ? $myfile['type'] : '';
		$this->params['filesize'] = $filesize = isset($myfile['size']) ? $myfile['size'] : '';
		$this->params['fileerror'] = $fileerror = isset($myfile['error']) ? $myfile['error'] : '';

		//var_dump($this->params);



		//$info = file_get_contents('php://input');

		//////////////////// write log ////////////////
		$file = BASEDIR . '/log/CommonAPI_log.txt';
		// The new person to add to the file
		//$info = date('l dS \of F Y h:i:s A') . ":: action->" . $action . ", username->" . $username . ", password->" . $password . "POST->" . implode('',$_SERVER)."\n";
		$info = ":: action->" . $action . ", username->" . $username . ", password->" . $password . "\n";
		// Write the contents to the file, 
		// using the FILE_APPEND flag to append the content to the end of the file
		// and the LOCK_EX flag to prevent anyone else writing to the file at the same time
		file_put_contents($file, $info, FILE_APPEND | LOCK_EX);
	}
}

