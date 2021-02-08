<?php

    $user= "osman";
    $password= "1q2w3e4r.";

    try {
        $connection = new PDO('mysql:host=localhost;port=8888;dbname=fitnessTracker', $user, $password);

        
        $dbh = null;
    } catch (PDOException $e) {
        print "Hata!: " . $e->getMessage() . "<br/>";
        die();
    }
?>