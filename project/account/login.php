<?php
date_default_timezone_set('MST');
session_start();
// If they're already logged in, we don't want them logging in again!
// Send them to the my account page
if($_SESSION['loggedin']){
    header('location: /account/?action=myaccount');
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Login | Yellowstone Park</title>
        <!-- Page header -->
        <?php include $_SERVER['DOCUMENT_ROOT'] . '/module/head.php' ?>
    </head>
    <body>
        <div class="container">
            <header class="masthead">
                <!-- User Tools -->
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/module/usertools.php' ?>
                <!-- Photo Header -->
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/module/header.php' ?>
                <!-- Top nav bar -->
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/module/topnav.php' ?>
            </header>
            <!-- Main content area -->
            <div class="content">
                <h1 class="text-center">Login</h1>
                <hr>
                <?php
                // If there was a message generated, echo it at the top.
                if (is_array($message)) {
                    echo "<div class='text-center lead'>";
                    echo "<p class='" . $message['class'] . "'>" . $message['message'] . "</p>";
                    echo "</div>";
                }
                ?>
                <div class="row-fluid">
                    <div class="span2"></div>
                    <div class="span8">
                        <form class='form-signin' method='post' action='.'>
                            <input type='hidden' name='action' id='action' value='loggingin'>
                            <input type='email' class='input-block-level' name='email' id='email' placeholder='Email' autofocus required>
                            <?php
                            if (isset($errors)) {
                                echo "<span class='text-center text-error'>";
                                echo $errors[1];
                                echo "</span>";
                            }
                            ?>
                            <input type='password' class='input-block-level' name='password' id='password' placeholder='Password' required>
                            <?php
                            if (isset($errors)) {
                                echo "<span class='text-center text-error'>";
                                echo $errors[2];
                                echo "</span>";
                            }
                            ?>
                            <button class='btn btn-large btn-info' type='submit'>Sign in</button>
                        </form>
                    </div>
                    <div class="span2"></div>
                </div>
            </div>
            <!-- Footer -->
            <footer class='footer'>
                <!-- Footer nav bar -->
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/module/footernav.php' ?>
                <!-- Copyright and last updated statement -->
                <?php include $_SERVER['DOCUMENT_ROOT'] . '/module/copyright.php' ?>
            </footer>
        </div>
    </body>
</html>