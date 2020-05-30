<?php


/**
 * Model base class
 */
class Model{
	
	public $post = [], $get = [];

	function __construct(){
		self::handlePost();
		self::handleGet();
	}

	private function handlePost(){
		foreach ($_POST as $key => $value) {
			$this->post[$key] = $value;
		}
	}

	private function handleGet(){
		foreach ($_GET as $key => $value) {
			$this->get[$key] = $value;
		}
	}


}