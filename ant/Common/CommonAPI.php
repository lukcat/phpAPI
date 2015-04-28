<?php

namespace Common;
/**
 * 处理接口公共业务
 */

class CommonAPI {
	public $params;
	public $app;
	public function check() {

		//////////////// get client data by .GET method ///////////////////
		//$this->params['username'] = $username = isset($_GET['username']) ? $_GET['username'] : '';
		//$this->params['password'] = $password = isset($_GET['password']) ? $_GET['password'] : '';

		//$this->params['action'] = $password = isset($_GET['action']) ? $_GET['action'] : '';

		/////////////// get client data by .POST method ///////////////////
		$this->params['username'] = $username = isset($_POST['username']) ? $_POST['username'] : '';
		$this->params['password'] = $password = isset($_POST['password']) ? $_POST['password'] : '';

		$this->params['action'] = $action = isset($_POST['action']) ? $_POST['action'] : '';

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

