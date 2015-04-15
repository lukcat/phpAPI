<?php

$file = dirname(__FILE__) . '/files/';
$filename = $file . 'test.txt';
//echo dirname($filename);

if (mkdir(dirname($filename),0777)) { 
	echo "success";
}
else {
	echo "error";
}
