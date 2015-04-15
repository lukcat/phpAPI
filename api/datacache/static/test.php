<?php

require_once('./staticCache.php');

$data = array(
	'id' => 1,
	'name' => 'chendq',
	'age' => 26,
	'workPlace' => 'beijing',
	'time' => array(1,2,3,4,5),
	'test' => array(6,7,8 => array(124,'dq')),
);

//test datacache
$file = new staticCache(); //new object

//save cache
//if ($file->cacheData('index_mk_cache', $data)) {
//	echo "success";
//} else {
//	echo "error";
//}

//read cache
if ($returndata = $file->cacheData('index_mk_cache')) {
	var_dump($returndata);
	//echo $returndata['test'][8][0];
} else {
	echo "Do not exist";
}

// delete cache 
//if ($file->cacheData('index_mk_cache',null)) {
//	echo 'delete successfully';
//} else {
//	echo 'error ocur';
//}

