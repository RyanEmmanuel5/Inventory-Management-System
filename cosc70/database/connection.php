<?php
    $servername = 'localhost';
    $email = 'root';
    $password = '';

    //connecting to database
    try{
        $conn = new PDO("mysql:host=$servername;dbname=inventory", $email, $password);
        //set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (\Exception $e){
        $error_message = $e->getMessage();
    }

?>