<?php

defined('ROOTPATH') OR exit('Access Denied!');

class _404 {
    use Controller;
    public function index() {
        echo "404 page not found controller";
    }    
}