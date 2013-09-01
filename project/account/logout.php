<?php
date_default_timezone_set('MST');
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Logging Out... | Yellowstone Park</title>
        <meta http-equiv="refresh" content="1; url=/">
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
                <h1 class="text-center">Logging Out...</h1>
                <hr>
                <div class="row-fluid">
                    <div class="span2"></div>
                    <div class="span8">
                        <div class='progress progress-striped active'>
                            <div class='bar bar-success' style='width: 100%'></div>
                        </div>
                    </div>
                    <div class="span2"></div>
                </div>
                <div class='text-center text-success'><em>If you are not redirected within 5 seconds, <a href='/'>click here</a>.</em></div>
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