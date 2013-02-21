<?php

$db_host = 'host goes here';
$db_user = 'proxi user goes here';
$db_pass = 'password goes here';
$db_name = 'db name goes here';

$con = new mysqli($db_host, $db_user, $db_pass, $db_name);
if (mysqli_connect_error()){
    include '../errordocs/500.php';
    exit();
}
?>
