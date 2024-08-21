<?php 

namespace Controller;

defined('ROOTPATH') OR exit('Access Denied!');

/**
 * home class
 */
class Home {
	use MainController;

	public function index()
	{
		$this->view('home');
	}

}
