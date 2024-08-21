<?php 

namespace Controller;

defined('ROOTPATH') OR exit('Access Denied!');

/**
 * login class
 */
class Login
{
	use MainController;

	public function index()
	{

		$data['user'] = new \Model\User;
		$req = new \Core\Request;
		if($req->posted())
		{
			$data['user']->login($_POST);
		}

		$this->view('login',$data);
	}

}
