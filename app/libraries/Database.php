<?php

class Database {
    private $dbHost = DB_HOST;
    private $dbUser = DB_USER;
    private $dbPass = DB_PASS;
    private $dbName = DB_NAME;

    private $statement;
    private $dbHandler;
    private $error;

    public function __construct() {
        $conn = 'mysql:host=' . $this->dbHost . ';dbname=' . $this->dbName;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        try {
            $this->dbHandler = new PDO($conn, $this->dbUser, $this->dbPass, $options);
            $this->createDB($this->dbHandler, $this->dbName);
        }
        catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    // Write queries
    public function query($sql) {
        $this->statement = $this->dbHandler->prepare($sql);
    }

    // Bind values
    public function bind($parameter, $value, $type=null) {
        switch (is_null($type)) {
            case is_int($value):
                $type = PDO::PARAM_INT;
                break;
            case is_bool($value):
                $type = PDO::PARAM_BOOL;
                break;
            case is_null($value):
                $type = PDO::PARAM_NULL;
                break;
            default:
                $type = PDO::PARAM_STR;
        }
        $this->statement->bindValue($parameter, $value, $type);
    }

    // Execute the prepared statement
    public function execute() {
        return $this->statement->execute();
    }

    // Return an array
    public function resultSet() {
        $this->execute();
        return $this->statement->fetchAll(PDO::FETCH_OBJ);
    }

    // Return a specific row as an object
    public function single() {
        $this->execute();
        return $this->statement->fetch(PDO::FETCH_OBJ);
    }

    // Gets the row count
    public function count() {
        return $this->statement->fetchColumn();
    }

    // Create the database with tables
    private function createDB ($dbh, $dbName) {

        // Create database
        $dbh->exec("CREATE DATABASE IF NOT EXISTS $dbName");

        // Create providers table
        $dbh->exec("CREATE TABLE IF NOT EXISTS `providers` 
        ( `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY , 
        `provider` VARCHAR(255) NOT NULL);");

        // Create emails table
        $dbh->exec("CREATE TABLE IF NOT EXISTS `emails` 
        ( `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY , 
        `provider_id` INT NOT NULL ,
        FOREIGN KEY (provider_id) REFERENCES providers(id) ON DELETE CASCADE ,
        `email` VARCHAR(255) NOT NULL , 
        `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP );");
    }
}