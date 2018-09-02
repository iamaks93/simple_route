<?php

/**
 * Created by PhpStorm.
 * User: pc
 * Date: 22/8/18
 * Time: 3:00 PM
 */
require '../handler.php';
new RequestHandler(new Doctors());

class Doctors {


	public function index(){
		echo "i am default function";
	}
	public function edit($a){
		echo "<pre>";
		echo $a;
	}
	public function submit(){
		echo "<pre>";
		print_r($_POST);
		echo "</pre>";
		exit;
		echo "submit call";
	}
}