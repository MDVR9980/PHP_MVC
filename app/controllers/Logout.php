<?php

namespace Controller;

defined('ROOTPATH') OR exit('Access Denied!');

/** logout class **/

class Logout {
    use MainController;
    public function index() {
        
        if(!empty($_SESSION['USER']))
            unset($_SESSION['USER']);
        redirect('home');
    }   

}