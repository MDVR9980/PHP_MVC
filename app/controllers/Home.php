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
        $file = 'davood.jpg';
		$data['file'] = $file;
		$iamge = new \Model\Image();
        $data['thumbnail'] = $iamge->getThumbnail($file, 80, 80);
		$this->view('home', $data);
	}

}
