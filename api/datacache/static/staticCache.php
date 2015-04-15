<?php
// By chendq 2015-4-15
// Description: This PHP file provide cache save, read and delete funtions for app 
// Usage: 
// You can use the code below to test this api
//	<?php
//	
//	require_once('./staticCache.php'); // Assume this file name is datacache.php
//	
//	$data = array(
//		'id' => 1,
//		'name' => 'chendq',
//		'age' => 26,
//		'workPlace' => 'beijing',
//		'time' => array(1,2,3,4,5),
//		'test' => array(6,7,8 => array(124,'dq')),
//	);
//	$file = new staticCache(); //new object
// 	1. save	
//	if ($file->cacheData('index_mk_cache', $data)) {
//		echo "success";
//	} else {
//		echo "error";
//	}

//	2.read 
//	if ($returndata = $file->cacheData('index_mk_cache')) {
//		//var_dump($returndata);
//		echo $returndata['test'][8][0];
//	} else {
//		echo "Do not exist";
//	}

//	3.delete
//	if ($file->cacheData('index_mk_cache',null)) {
//		echo 'delete successfully';
//	} else {
//		echo 'error ocur';
//	}

class staticCache {
	private $_dir;

	const EXT = '.txt';

	public function __construct() {
		$this->_dir = dirname(__FILE__) . '/files/';
	}

	public function cacheData($key, $value = '', $path = '') {
		$filename = $this->_dir . $paht . $key . self::EXT;

		if ($value !== '') { // value is not empty
			if (is_null($value)) { // value is null

				//////////delete cache///////////
				return unlink($filename); //delete success return true, else return false

			} else { //////// save cache/////////

				$dir = dirname($filename); // get file path 
				if (!is_dir($dir)) {
					mkdir($dir, 0777); // father dir should be 777 or error ocurs
				}
				return file_put_contents($filename,json_encode($value));	// if write successfully, return bytes of file, or return false
			}
		} else { // value is empty
			if (!is_file($filename)) { //read cache
				return FALSE;	// file do not exists
			} else {
				return json_decode(file_get_contents($filename),true); // param true represent decode value is a string not an object
			}
		}
	}
}

