<?php

defined('ROOTPATH') OR exit('Access Denied!');

/** Main Model class **/

Trait Model {

    use Database;

    protected $limit         = 10;
    protected $offset        = 0;

    protected $order_type    = "desc";
    protected $order_column  = "id";

    public $errors           = [];

    public function findAll(){
        $query = " select * from $this->table order by $this->order_column $this->order_type limit $this->limit offset $this->offset";
        return $this->query($query);
    }

    public function where($data, $data_not = []){
        $keys = array_keys($data);
        $keys_not = array_keys($data_not);
        $query = "select * from $this->table where ";
        foreach ($keys as $key) {
            $query .= $key . " = :" . $key . " && ";
        }

        foreach ($keys_not as $key) {
            $query .= $key . " != :" . $key . " && ";
        }
        $query = trim($query, " && ");
        $query .= " order by $this->order_column $this->order_type limit $this->limit offset $this->offset";
        $data = array_merge($data, $data_not);
        return $this->query($query, $data);
    }

    public function first($data, $data_not = []){
        $keys = array_keys($data);
        $keys_not = array_keys($data_not);
        $query = "select * from $this->table where ";
        foreach ($keys as $key) {
            $query .= $key . " = :" . $key . " && ";
        }

        foreach ($keys_not as $key) {
            $query .= $key . " != :" . $key . " && ";
        }
        $query = trim($query, " && ");
        $query .= " limit $this->limit offset $this->offset";
        $data = array_merge($data, $data_not);
        $result = $this->query($query, $data);
        if($result) 
            return $result[0];
        
        return false;
    }

    public function insert($data){

        /** remove unwanted data **/
        if(!empty($this->allowedColumns)){
            foreach ($data as $key => $value) {
                if(!in_array($key, $this->allowedColumns)){
                    unset($data[$key]);
                }
            }
        }
        
        $keys = array_keys($data);
        $query = "insert into $this->table (".implode(",", $keys).") values (:".implode(",:", $keys).")";
        $this->query($query, $data);

        return false;
    }

    public function update($id, $data, $id_column = 'id'){

        /** remove unwanted data **/
        if(!empty($this->allowedColumns)){
            foreach ($data as $key => $value) {
                if(!in_array($key, $this->allowedColumns)){
                    unset($data[$key]);
                }
            }
        }

        $keys = array_keys($data);
        $query = "update $this->table set ";
        foreach ($keys as $key) {
            $query .= $key . " = :" . $key . ", ";
        }

        $query = trim($query, ", ");

        $query .= " where $id_column = :$id_column ";

        $data[$id_column] = $id;

        $this->query($query, $data);

        return false;
    }

    public function delete($id, $id_column = 'id'){
        $data[$id_column] = $id;
        $query = "delete from $this->table where $id_column = :$id_column";
        
        $this->query($query, $data);

        return false;
    }

}