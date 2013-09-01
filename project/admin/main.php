<?php
date_default_timezone_set('MST');
session_start();
if (!$_SESSION['loggedin'] || $_SESSION['role'] != 1) {
    header('location: /');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Site Overview | Yellowstone Park</title>
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
                <h1 class="text-center">Yellowstone Site Overview</h1>
                <hr>
                <div class="row-fluid">
                    <div class="span3"><?php include $_SERVER['DOCUMENT_ROOT'] . '/admin/modules/adminsidebar.php' ?></div>
                    <div class="span9">
                        <p class="lead">Site Overview</p>
                        <fieldset>
                            <legend>Users</legend>
                            <ul>
                                <?php
                                echo '<li><p>There are ' . $siteStats['users'] . ' registered users</p></li>';
                                echo '<li><p>The most recent user to register was ' . $siteStats['recent_user_fn'] . ' ' . $siteStats['recent_user_ln'] . ' (' . $siteStats['recent_user_email'] . ')</p></li>';
                                ?>
                            </ul>
                            <p><a href="/admin/?p=users" class="btn btn-primary">View all users</a>&nbsp;&nbsp;<a href="/admin/?p=edituser" class="btn btn-primary">Edit a user</a></p>
                        </fieldset>
                        <fieldset>
                            <legend>Content</legend>

                        </fieldset>
                    </div>
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