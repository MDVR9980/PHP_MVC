<?php 

namespace Controller;

defined('ROOTPATH') OR exit('Access Denied!');

class _404
{
	use MainController;
	
	public function index()
	{
		$this->view('404');
	}
}
