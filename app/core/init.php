<?php

defined('ROOTPATH') OR exit('Access Denied!');

spl_autoload_register(function ($class) {
    require $filename = "../app/models/" . ucfirst($class) . ".php";
});

require 'config.php';
require 'functions.php';
require 'Database.php';
require 'Model.php';
require 'Controller.php';
require 'App.php';