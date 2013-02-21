<?php

/*
 * Connects to the database using PDO
 */
$dsn = 'mysql:host = host goes here dbname = db name goes here';
$user = 'proxy user goes here';
$password = 'password goes here';

try {
    $con = new PDO($dsn,$user,$password);
}  catch (PDOException $exc){
    header('location: /errordocs/500.php');
}
?>
