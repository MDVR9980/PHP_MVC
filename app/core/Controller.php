<?php

namespace Controller;

defined('ROOTPATH') OR exit('Access Denied!');

trait MainController {
    public function view($name, $data = []) {
        if(!empty($data)) {
            extract($data);
        }
        $filename = "../app/views/".$name.".view.php";
        if (file_exists($filename)) {
            require $filename;
        }
        else {
            $filename = "../app/views/404.view.php";
            require $filename;
        } 
    }
}