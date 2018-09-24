<?php

class config{
    private $host = 'localhost';
    private $dbname = 'goomer';
    private $user = 'root';
    private $password = '';
    private $port = '3306';

    public function conectar(){
        $con = "mysql:host=$this->host;port=$this->port;dbname=$this->dbname";
        $dbConection = new PDO($con, $this->user, $this->password);
        $dbConection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $dbConection;
    }
}





?>