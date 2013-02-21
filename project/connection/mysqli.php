<?php

$db_host = 'localhost';
$db_user = 'mytutori_yellows';
$db_pass = '(J{T&)N##=$W';
$db_name = 'mytutori_yellowstone';

$con = new mysqli($db_host, $db_user, $db_pass, $db_name);
if (mysqli_connect_error()){
    include '../errordocs/500.php';
    exit();
}
?>
