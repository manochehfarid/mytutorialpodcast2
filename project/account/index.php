<?php

/*
 Controls the account functionality
 */
if (file_exists($_SERVER['DOCUMENT_ROOT'].'model.php')) {
    require_once $_SERVER['DOCUMENT_ROOT'].'model.php';
}else{
    header('location: /errordocs/500.php');
    exit();
}
if ($_GET['action'])
{
    $action = $_GET['action'];
}elseif ($_POST['action']) {
    $action = $_POST['action'];
}
if ($action == 'register')
{
    include 'register.php';
    exit();
}elseif ($action == 'login'){
    include 'login.php';
    exit();
}elseif ($action == 'signmeup') {
   // Collect the data
    $firstname = $_POST['ifirst'];
    $lastname = $_POST['ilast'];
    $username = $_POST['iusername'];
    $password = $_POST['ipassword'];
    
    // Hash the password
    $salt = 'palt09re1pe3it5rmgc961'; // My salt
    $saltedpassword = $salt.$password;
    $password = sha1($saltedpassword); // creates a 40 character hash
    
    $signupresult = signMeUp($firstname, $lastname, $username, $password);
    if($signupresult == 1){
        // Send a success view
        $message = $firstname.', your registration was a success, please login with your supplied email and password.';
        include 'login.php';
        exit();
    } else {
        // Send a failure view
        $message = $firstname.', Sorry your registration was a failure. Please try again or contact the site administrator.';
        include 'register.php';
    }
    
}
?>
