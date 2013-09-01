<?php
date_default_timezone_set('MST');
session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $content['content_name'] ?> | Yellowstone Park</title>
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
            <h1 class="text-center"><?php echo $content['content_name'] ?></h1>
            <hr>
            <div class="row-fluid">
            <!--<div class="span12 pagination-centered"><img src="img/buffalos.jpg" alt="Stupid Buffalo" /></div> -->
            </div>
            <div class="row-fluid">
                <div class="span3">
            <?php include $_SERVER['DOCUMENT_ROOT'].'/module/sidenav.php' ?>        
                </div>
                <div class="span9">
                    <h3><?php
                        if(isset($content['content_category'])) {
                            echo 'Cateogry: '.$content['content_category'].'<br>';
                        }
                        if(isset($content['content_season'])) {
                            echo 'Season: '.$content['content_season'].'<br>';
                        }
                        if(isset($content['content_location'])) {
                            echo 'Location: '.$content['content_location'].'<br>';
                        }
                    ?></h3>
            <?php include $_SERVER['DOCUMENT_ROOT'].'/module/carousel.php' ?>
                    <p><?php echo $content['content_description'] ?></p>
                    <h4>
                        <?php 
                        if(isset($content['content_rules'])) {
                            echo 'Rules: '.$content['content_rules'].'<br>';
                        }
                        ?>
                    </h4>
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