<?php
$dsn = 'mysql:host=localhost;dbname=mytutori_yellowstone';
$dbusername = 'mytutori_yellows';
$dbpassword = '(J{T&)N##=$W';
$dboptions = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

try {
    $dbconn = new PDO($dsn, $dbusername, $dbpassword, $dboptions);
}
catch (PDOException $exc){
     //echo 'Could not connect to database.<br>
     //Database connection error: ' . $exc->getMessage();
     header('location: /error/500.php');
     exit;
}

?>