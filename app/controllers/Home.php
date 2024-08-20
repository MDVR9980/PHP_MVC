<?php


namespace Controller;

defined('ROOTPATH') OR exit('Access Denied!');

/** home class **/

class Home {
    use MainController;
    public function index() {
        $data['username'] = empty($_SESSION['USER']) ? 'USER':$_SESSION['USER']->email;
        $this->view('home', $data);
    }   

}