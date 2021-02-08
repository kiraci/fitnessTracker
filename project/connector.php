<?php
require_once("config.php");

    class Connector{

        private $db_host;
        private $db_name;
        private $db_username;
        private $db_password;
        private $connection;
        
        function __construct( $host, $name, $username, $password){
            $this->db_host = $host;
            $this->db_name = $name;
            $this->db_username = $username;
            $this->db_password = $password;
            $this->connection = NULL;
            
        }

        function openConnection(){
            try {
                $db_entrance = 'mysql:host=' . $this->db_host . ';port=8888;dbname=' . $this->db_name . ';charset=utf8';
                $this->connection = new PDO( $db_entrance, $this->db_username, $this->db_password);
                //echo "aasfasas";
            } catch (PDOException $e) {
                print "Hata!: " . $e->getMessage() . "<br/>";
                die();
            }
        }

        function closeConnection(){
            $this->connection = NULL;
        }

        function getConnection(){
            return $this->connection;
        }

    }

    $connection = new Connector(
        $GLOBALS["DB_hostname"], $GLOBALS["DB_name"], 
        $GLOBALS["DB_username"], $GLOBALS["DB_password"] 
    );

    $connection->openConnection();

?>