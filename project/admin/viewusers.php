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
        <title>Site Users | Yellowstone Park</title>
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
                <h1 class="text-center">Registered Users</h1>
                <hr>
                <div class="row-fluid">
                    <div class="span3"><?php include $_SERVER['DOCUMENT_ROOT'] . '/admin/modules/adminsidebar.php' ?></div>
                    <div class="span9">
                        <table class="table table-hover table-bordered table-condensed">
                            <thead>
                                <tr>
                                    <td><b>Edit User</b></td>
                                    <td><b>First Name</b></td>
                                    <td><b>Last Name</b></td>
                                    <td><b>Email Address</b></td>
                                    <td><b>Role</b></td>
                                </tr>
                            </thead>
                            <?php
                                foreach ($users as $user) {
                                    echo '<tr>';
                                    echo '<td><a class="btn btn-primary" href="/admin/?p=edituser&uid='.$user["account_id"].'">Edit</a></td>';
                                    echo '<td>'.$user['first_name'].'</td>';
                                    echo '<td>'.$user['last_name'].'</td>';
                                    echo '<td>'.$user['email'].'</td>';
                                    echo '<td>'.$user['role'].'</td>';
                                    echo '</tr>';
                                }
                            ?>
                        </table>
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