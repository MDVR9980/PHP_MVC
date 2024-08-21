<?php

namespace Thunder;

defined('CPATH') OR exit('Access Denied!');

/**  Thunder class **/

class Thunder {

    private $version = '1.0.0';

    public function db($argv) {

        $mode   = $argv[1] ?? null;
        $param1 = $argv[2] ?? null;

        switch($mode) {
            case "db:create":

                /** check if param1 is empty **/
                if(empty($param1)) {
                    die("\n\rPlease provide a database name\n\r");
                }
                $db = new Database;
                $query = "create database if not exists " . $param1;
                $db->query($query);

                die("\n\rDatabase created successfully\n\r");

            case "db:table":

                /** check if param1 is empty **/
                if(empty($param1)) {
                    die("\n\rPlease provide a table name\n\r");
                }
                $db = new Database;
                $query = "describe " . $param1;
                $res = $db->query($query);
                
                if($res) {
                    print_r($res);
                } else {
                    echo "\n\rCould not find data for table";
                }
                
                die();
                
            case "db:drop":
                /** check if param1 is empty **/
                if(empty($param1)) {
                    die("\n\rPlease provide a database name\n\r");
                }
                $db = new Database;
                $query = "drop database " . $param1;
                $db->query($query);
                
                die("\n\rDatabase deleted successfully\n\r");
            case "db:seed":
                //code
                break;
            default:
                die("\n\rUnknown command $argv[1] \n\r");
        }
    }

    public function list($argv)
    {
        $mode       = $argv[1] ?? null;

        switch ($mode) {
            case 'list:migrations':

                $folder = 'app'.DS.'migrations'.DS;
                if(!file_exists($folder)) {
                   die("\n\rNo migration files were found\n\r");
                }

                $files = glob($folder . "*.php");
                echo "\n\rMigration files:\n\r";

                foreach ($files as $file) {
                    echo basename($file) ."\n\r";
                }
                break;
            
            default:
                // code...
                break;
        }
    }

    public function make($argv) {

        $mode      = $argv[1] ?? null;
        $classname = $argv[2] ?? null;

        /** check if class name is empty **/
        if(empty($classname)) {
            die("\n\rPlease provide a class name\n\r");
        }

        /** clean class name **/
        $classname = preg_replace("/[^a-zA-Z0-9_]+/","", $classname);

        /** check if class name starts with a number **/
        if(preg_match("/^[^a-zA-Z]+/", $classname)) {
            die("\n\rClass names cant start with a number\n\r");
        }

        switch($mode) {
            case "make:controller":

                $filename = 'app' . DS . 'controllers' . DS . ucfirst($classname) . ".php";
                if(file_exists($filename)) {
                    die("\n\rThat controller already exists\n\r");
                }

                $sample_file = file_get_contents('app' . DS . 'thunder' . DS . 'samples' . DS . 'controller-sample.php');
                $sample_file = preg_replace('/\{CLASSNAME\}/', ucfirst($classname), $sample_file);
                $sample_file = preg_replace('/\{classname\}/', strtolower($classname), $sample_file);
                file_put_contents($filename, $sample_file);
                if(file_put_contents($filename, $sample_file)) { 
                    die("\n\rController created successfully\n\r");
                } else {
                    die("\n\rFailed to create Controller due to an arror\n\r");
                }

            case "make:model":

                $filename = 'app' . DS . 'models' . DS . ucfirst($classname) . ".php";
                if(file_exists($filename)) {
                    die("\n\rThat models already exists\n\r");
                }

                $sample_file = file_get_contents('app' . DS . 'thunder' . DS . 'samples' . DS . 'model-sample.php');
                $sample_file = preg_replace('/\{CLASSNAME\}/', ucfirst($classname), $sample_file);
                
                /** only add as 's' at the end of table name if it dosent exist **/
                if(!preg_match("/s$/", $classname)) {
                    $sample_file = preg_replace('/\{table\}/', strtolower($classname) . 's', $sample_file);
                }
                
                if(file_put_contents($filename, $sample_file)) { 
                    die("\n\rModel created successfully\n\r");
                } else {
                    die("\n\rFailed to create Model due to an arror\n\r");
                }
                
            case "make:migration":
                
                $folder = 'app'.DS.'migrations'.DS;

                if(!file_exists($folder)) {
                    mkdir($folder,0777,true);
                }

                $filename = $folder . date("jS_M_Y_H_i_s_") . ucfirst($classname) . ".php";
                if(file_exists($filename)) {
                    die("\n\rThat migration file already exists\n\r");
                }
                    

                $sample_file = file_get_contents('app'.DS.'thunder'.DS.'samples'.DS.'migration-sample.php');
                $sample_file = preg_replace("/\{CLASSNAME\}/", ucfirst($classname), $sample_file);
                $sample_file = preg_replace("/\{classname\}/", strtolower($classname), $sample_file);
                
                if(file_put_contents($filename, $sample_file)) {
                    die("\n\rMigration file created: " . basename($filename) . " \n\r");
                }else {
                    die("\n\rFailed to create Migration file due to an error\n\r");
                }
            case "make:seeder":
                //code
                break;
            default:
                die("\n\rUnknown command $argv[1] \n\r");
        }
    }

    public function migrate($argv) {

        $mode       = $argv[1] ?? null;
        $filename   = $argv[2] ?? null;

        $filename = "app".DS."migrations".DS.$filename;
        if(file_exists($filename)) {
            require $filename;

            preg_match("/[a-zA-Z]+\.php$/",$filename, $match);
            $classname = str_replace(".php","",$match[0]);

            $myclass = new ("\Thunder\\$classname")();

            switch ($mode) {
                case 'migrate':
                    $myclass->up();
                    echo ("\n\rTables created successfully\n\r");
                    break;
                case 'migrate:rollback':
                    $myclass->down();
                    echo ("\n\rTables removed successfully\n\r");
                    break;
                case 'migrate:refresh':
                    $myclass->down();
                    $myclass->up();
                    echo ("\n\rTables refreshed successfully\n\r");
                    break;
                
                default:
                    $myclass->up();
                    
                    break;
            }
            
        }else {
            die("\n\rMigration file could not be found\n\r");
        }

        echo "\n\rMigration file run successfully: " . basename($filename) . " \n\r";
    }

    public function help() {
    
        echo "

        Thunder v$this->version Command Line Tool

        Database
        db:create          Create a new database schema.
        db:seed            Runs the specified seeder to populate known data into the database.
        db:table           Retrieves information on the selected table.
        db:drop            Drop/Delete a database.
        migrate            Locates and runs a migration from the specified plugin folder.
        migrate:refresh    Does a rollback followed by a latest to refresh the current state of the database.
        migrate:rollback   Runs the 'down' method for a migration in the specifiled plugin folder.

        Generators
        make:controller    Generates a new controller file.
        make:model         Generates a new model file.
        make:migration     Generates a new migration file.
        make:seeder        Generates a new seeder file.
                
            ";
    }
}