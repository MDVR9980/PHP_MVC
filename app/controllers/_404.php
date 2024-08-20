<?php

namespace Controller;

defined('ROOTPATH') OR exit('Access Denied!');

class _404 {
    use MainController;
    public function index() {
        echo "404 page not found controller";
    }    
}