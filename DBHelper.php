<?php

class DBHelper
{
    private $db;
    const DB_HOST = "bookstore-db";
    const DB_NAME = "postgres";
    const DB_USER = "postgres";
    const DB_PASS = "postgres";

    function __construct()
    {
        $this->connect();
    }

    private function connect(){
        $this->db =  new PDO('pgsql:host='.self::DB_HOST.';dbname='.self::DB_NAME, self::DB_NAME, self::DB_NAME);

        if(!$this->db) {
            echo "Failed to connect to database";
        }
    }

    function getOne($query = null, $values = array()){

        $stmt = $this->db->prepare($query);
        $stmt->execute($values);

        $ret = $stmt->fetchColumn();
        return $ret;
    }

    function getAll($query = null, $values = array()){
        
        $stmt = $this->db->prepare($query);
        $stmt->execute($values);

        $ret = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $ret;
    }

    function getRow($query = null, $values = array()){
        
        $stmt = $this->db->prepare($query);
        $stmt->execute($values);

        $ret = $stmt->fetch(PDO::FETCH_ASSOC);
        return $ret;
    }

    function execute($query = null, $values = array()){

        $stmt = $this->db->prepare($query);
        $stmt->execute($values);

        $ret = $stmt->fetchColumn();
        return $ret;
    }

}