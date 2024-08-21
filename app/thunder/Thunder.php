<?php

namespace Thunder;

defined('CPATH') OR exit('Access Denied!');

/**  Thunder class **/

class Thunder {

    private $version = '1.0.0';

    public function db() {
        echo "\n\rThis is the db function\n\r";
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
                //code
                break;
            case "make:seeder":
                //code
                break;
            default:
                die("\n\rUnknown 'make' command!\n\r");
        }
    }

    public function migrate() {
        echo "\n\rThis is the migrate function\n\r";
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