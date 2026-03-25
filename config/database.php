<?php

class Database {
    private $host = "localhost";
    private $db_name = "attendance_db";
    private $username = "postgres";
    private $password = "09215101525";

    public function connect(){
        try{
            $conn = new PDO(
                "pgsql:host=$this->host;dbname=$this->db_name",
                $this->username,
                $this->password
            );

            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;

        }catch(PDOException $e){
            echo "Connection error: " . $e->getMessage();
            return null;
        }
    }
}