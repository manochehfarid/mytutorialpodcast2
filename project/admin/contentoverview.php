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
        <title>Site Content | Yellowstone Park</title>
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
                <h1 class="text-center">Content Entries</h1>
                <hr>
                <div class="row-fluid">
                    <div class="span3"><?php include $_SERVER['DOCUMENT_ROOT'] . '/admin/modules/adminsidebar.php' ?></div>
                    <div class="span9">
                        <table class="table table-hover table-bordered table-condensed">
                            <thead>
                                <tr>
                                    <td><b>Edit</b></td>
                                    <td><b>Category</b></td>
                                    <td><b>Title</b></td>
                                    <td><b>Excerpt</b></td>
                                    <td><b>Last Updated</b></td>
                                </tr>
                            </thead>
                            <?php
                                foreach ($contententries as $entry) {
                                    echo '<tr>';
                                    echo '<td><a class="btn btn-primary" href="/admin/?p=editcontent&cid='.$entry["id"].'">Edit</a></td>';
                                    echo '<td>'.$entry['content_category'].'</td>';
                                    echo '<td>'.$entry['name'].'</td>';
                                    echo '<td>'.$entry['description'].'</td>';
                                    echo '<td>'.$entry['last_update_date'].'</td>';
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