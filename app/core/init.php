<?php 

defined('ROOTPATH') OR exit('Access Denied!');

spl_autoload_register(function($classname) {

	$classname = explode("\\", $classname);
	$classname = end($classname);
	require $filename = "../app/models/".ucfirst($classname).".php";
});

require 'config.php';
require 'functions.php';
require 'Database.php';
require 'Model.php';
require 'Controller.php';
require 'App.php';