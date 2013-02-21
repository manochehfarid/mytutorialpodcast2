<?php

/*
 * Connects to the database using PDO
 */
$dsn = 'mysql:host = localhost dbname = mytutori_yellowstone';
$user = 'mytutori_yellows';
$password = '(J{T&)N##=$W';

try {
    $con = new PDO($dsn,$user,$password);
}  catch (PDOException $exc){
    header('location: /errordocs/500.php');
}
?>
