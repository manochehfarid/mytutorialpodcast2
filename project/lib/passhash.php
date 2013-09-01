<?php
/* 
 * New BRW password hasher
 * This file is used to hash passwords.
 * This file must be included whenever you need to hash a password.
 */

function hashPassword($password) {
    // Define our password hashing method
    $hash = '$2y$12$iJk7889HIvb324qicn730z$';
    $passwordhash = crypt($password, $hash);
    return $passwordhash;
}
?>