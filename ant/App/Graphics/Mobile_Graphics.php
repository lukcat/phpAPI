<?php
// By chendq 2015/4/21

namespace App\Graphics;

use Common\Response;

class Mobile_Graphics {
	function test() {
		Response::show(000,'this is test message');
	}

	function save() {
		// read photo from client and save it to local system 
		// TODO
	}

	function generate_thumbnail() {
		// use third part toolkit to process photos
		// TODO
	}
}

