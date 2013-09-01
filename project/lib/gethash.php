<?php

/*
 * Use this file to get a hash for a password using our encryption method
 */

// Require the password hashing file
if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/lib/passhash.php')) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/passhash.php';
} else {
    header('location: /error/500.php');
    exit;
}

$password = '';
$passwordhash = hashPassword($password);
echo $passwordhash;

?>