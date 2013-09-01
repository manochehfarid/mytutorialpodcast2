<?php
date_default_timezone_set('MST');
session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home | Yellowstone Park</title>
    <!-- Page header -->
    <?php include $_SERVER['DOCUMENT_ROOT'].'/module/head.php' ?>
</head>
<body>
    <div class="container">
        <header class="masthead">
            <!-- User Tools -->
            <?php include $_SERVER['DOCUMENT_ROOT'].'/module/usertools.php' ?>
            <!-- Photo Header -->
            <?php include $_SERVER['DOCUMENT_ROOT'].'/module/header.php' ?>
            <!-- Top nav bar -->
            <?php include $_SERVER['DOCUMENT_ROOT'].'/module/topnav.php' ?>
        </header>
        <!-- Main content area -->
        <div class="content">
            <h1 class="text-center">Welcome to My Yellowstone</h1>
            <hr>
            <div class="row-fluid">
            <!--<div class="span12 pagination-centered"><img src="img/buffalos.jpg" alt="Stupid Buffalo" /></div> -->
            </div>
            <div class="row-fluid">
                <div class="span3">
            <?php include $_SERVER['DOCUMENT_ROOT'].'/module/sidenav.php' ?>        
                </div>
                <div class="span9">
            <?php include $_SERVER['DOCUMENT_ROOT'].'/module/carousel.php' ?>
                    <p><br>
            Welcome. Have fun!
            </p>
            </div>   
        </div>
        <!-- Footer -->
        <footer class='footer'>
            <!-- Footer nav bar -->
            <?php include $_SERVER['DOCUMENT_ROOT'].'/module/footernav.php' ?>
            <!-- Copyright and last updated statement -->
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/module/copyright.php' ?>
        </footer>
    </div>
</div>
</body>
</html>