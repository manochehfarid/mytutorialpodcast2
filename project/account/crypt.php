<?php

/*
 * Testing out the crypt function. Hopefully this works under a Windows server.
 */

if(CRYPT_BLOWFISH == 1){
    echo crypt('bacon', '$2y$15$1234567890abcdefghijkl$');
} else {
    echo 'Not supported :(';
}

//$password = 'bacon';
//$salt = '1234567890abcdefghijkl';
//$saltedpassword = $salt . $password;
//$encryptedpassword = sha1($saltedpassword);
//echo '<br>' . $encryptedpassword;
?>