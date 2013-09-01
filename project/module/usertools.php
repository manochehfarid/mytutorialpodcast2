<?php
if($_SESSION['loggedin']){
    // Display the user's first name.
    $tools = 'Hello, '.$_SESSION['firstname'].' | ';
    if($_SESSION['role'] == 1){
        // The user is an admin. Display a link to the admin site
        $tools .= '<a href="/admin">Admin</a> | ';
    }
    $tools .= '<a href="/account/?action=myaccount">My Account</a> | <a href="/account/?action=logout">Logout</a>';
} else{
    $tools = '<a href="/account/?action=register">Register</a> | <a href="/account/?action=login">Login</a>';
}
echo '<div class="pull-right text-info"><h5>'.$tools.'</h5></div>';
?>