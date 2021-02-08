<?php
require_once("database.php");


    class Authenticator{

        private $username;
        private $email;
        private $password;
        private $database;

        function __construct(){
            $this->database = new Database();
        }

        function registerUser( $email, $username, $password ){

            $result = $this->database->createUser( $this->checkInput( $email ), $this->checkInput( $username ), $this->checkInput( $password ) );

            if( $result ){
                echo "session falan başlat";
            }
        }

        function loginUser( $username, $password ){
            $result = $this->database->loginUser( $this->checkInput( $username ), $this->checkInput( $password ) );
        
            if( $result ){
                echo "session falan başlat";
            }
        }

        function checkInput( $input ){
            return $input;
        }

    }   

    $a = new Authenticator();

    //$a->registerUser( "osmaan1@gmail.com", "osmaan1", "1234" );
    $a->loginUser( "osmaan1", "1234" );

?>