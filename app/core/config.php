<?php

defined('ROOTPATH') OR exit('Access Denied!');

if($_SERVER['SERVER_NAME'] == 'localhost'){
    /** database config**/
    define('DBNAME','my_db');
    define('DBHOST','localhost');
    define('DBUSER','root');
    define('DBPASS','');
    define('DBDRIVER','');

    define("ROOT","http://localhost/Web3/PHP_MVC/public");
}
else {
    /** database config**/
    define('DBNAME','my_db');
    define('DBHOST','localhost');
    define('DBUSER','root');
    define('DBPASS','');
    define('DBDRIVER','');

    define("ROOT","https://www.yourwebsite.com");
}

define("APP_NAME", "My Website");
define("APP_DESC", "Best website on the planet");

/** true means show errors **/
define("DEBUG", true);