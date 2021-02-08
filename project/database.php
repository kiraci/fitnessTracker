<?php

require_once("connector.php");

    class Database{

        private $connector;
        private $connection;
        
        function __construct(){
            $this->connector = new Connector(
                $GLOBALS["DB_hostname"], $GLOBALS["DB_name"], 
                $GLOBALS["DB_username"], $GLOBALS["DB_password"] 
            );
        
            $this->connector->openConnection();
            $this->connection = $this->connector->getConnection();
        }

        function checkUser( $username ){
            
            $query = $this->connection->query("SELECT * FROM users WHERE username=\"" . $username. "\"", PDO::FETCH_ASSOC);

            if ( $query->rowCount() ){
                return TRUE;
            }

            return FALSE;
        }  

        function createUser( $email, $username, $password ){

            //INSERT INTO `users` (`id`, `username`, `email`, `password`) VALUES (NULL, 'osman', 'osman@gmail.com', '1234');
            if( !$this->checkUser( $username ) ){
                
                $query = $this->connection->prepare("INSERT INTO users SET
                username = ?,
                email = ?,
                password = ?");
    
                $insert = $query->execute(array(
                    $username, $email, $password
                ));
    
                if ( $insert ){
                    $last_id = $this->connection->lastInsertId();
                    return TRUE;
                }

            }

            return FALSE;

        }

        function insertTraining( $type, $duration, $description, $date, $username ){

            //INSERT INTO `training` (`id`, `date`, `type`, `description`, `duration`) VALUES (NULL, '2021-02-08', 'cardio', 'jogging in campus', '40 minutes');

            if( $date == "" ){
                $date = date("Y-m-d");
            }

            $query = $this->connection->prepare("INSERT INTO training SET
            date = ?,
            type = ?,
            description = ?,
            duration = ?,
            username = ?");

            $insert = $query->execute(array(
                $date, $type, $description, $duration, $username
            ));
            
            if ( $insert ){
                $last_id = $this->connection->lastInsertId();
                
            }

        }

        function insertMeasurement( $username, $fateRate, $neck, $weight, $hip, $arm, $chest, $shoulder, $waist, $date, $description){
    
            if( $date == "" ){
                $date = date("Y-m-d");
            }

            $query = $this->connection->query("SELECT * FROM measures ORDER BY ID DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);

            $dateOfLastEntry = "";

            if ( $query ){
                $dateOfLastEntry = $query["date"];
            }

            
            $diff = abs(strtotime($date) - strtotime($dateOfLastEntry));
        
            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));

            if( $months >= 1 ){
                $query = $this->connection->prepare("INSERT INTO measures SET
                username = ?,
                fatRate = ?,
                neck = ?,
                weight = ?,
                hip = ?,
                arm = ?,
                chest = ?,
                shoulder = ?,
                waist = ?,
                date = ?,
                description = ?");
    
                $insert = $query->execute(array(
                    $username, $fateRate, $neck, $weight, $hip, $arm, $chest, $shoulder, $waist, $date, $description
                ));
                
                if ( $insert ){
                    $last_id = $this->connection->lastInsertId();
                    
                }
            }else{
                echo "bi ay bekle lan";
            }

        }

        function insertGoal(){
            
        }

        function retrieveTraining( $username ){

            $query = $this->connection->query("SELECT * FROM training WHERE username=\"" . $username ."\"", PDO::FETCH_ASSOC);
            if ( $query->rowCount() ){
                foreach( $query as $row ){
                    print_r($row);
                }
            }

        }

        function retrieveMeasurement( $username ){

            $query = $this->connection->query("SELECT * FROM measures WHERE username=\"" . $username ."\"", PDO::FETCH_ASSOC);
            if ( $query->rowCount() ){
                foreach( $query as $row ){
                    print_r($row);
                }
            }

        }

        function retrieveGoal( $username ){

        } 

        function loginUser( $username, $password ){

            //SELECT * FROM `users` WHERE username="denem" AND password="1234"


            $query = $this->connection->query("SELECT * FROM users WHERE username=\"" . $username . "\" AND password=\"" . $password . "\"", PDO::FETCH_ASSOC);

            if ( $query->rowCount() == 1 ){
                return TRUE;
            }

            return FALSE;

        } 
        
    }

    $d = new Database();
    $d->createUser( "osman1@gmail.com", "osman1", "1234" );
    //$d->insertTraining( "cardio", "35 minutes", "morning cycle", "", "osman");
    //$d->insertMeasurement( "osman", 3, 1, 1, 1, 1, 1, 1, 1, "", "good diet program" );
    //$d->retrieveMeasurement( "osman" );
    $d->loginUser("denem", "1234");



?>