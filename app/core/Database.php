<?php

namespace Model;

defined('ROOTPATH') OR exit('Access Denied!');

Trait Database {
    private function connect() {
        $string = "mysql:hostname=". DBHOST .";dbname=". DBNAME;
        $conn = new \PDO($string, DBUSER, DBPASS);
        return $conn;
    }

    public function query($query, $data = []){
        $conn = $this->connect();
        $stmt = $conn->prepare($query);

        $check = $stmt->execute($data);
        if ($check) {
           $result = $stmt->fetchAll(\PDO::FETCH_OBJ); 
        if(is_array($result) && count($result)){
            return $result;
        }
        }

        return false;
    }

    public function get_row($query, $data = []){
        $conn = $this->connect();
        $stmt = $conn->prepare($query);

        $check = $stmt->execute($data);
        if ($check) {
           $result = $stmt->fetchAll(\PDO::FETCH_OBJ); 
        if(is_array($result) && count($result)){
            return $result[0];
        }
        }

        return false;
    }
}
