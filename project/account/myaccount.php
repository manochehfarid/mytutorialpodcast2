<?php
date_default_timezone_set('MST');
session_start();
// If they're not logged in, they should be redirected to the login page.
if (!$_SESSION['loggedin']) {
    header('location: /account/?action=login');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>My Account | Yellowstone Park</title>
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
                <h1 class="text-center">My Account</h1>
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
                        <form class="form-horizontal" method="post" action=".">
                            <fieldset>
                                <legend>User Information</legend>
                                <div class="control-group">
                                    <label class="control-label" for="firstname">First Name</label>
                                    <div class="controls">
                                        <input type="text" name="firstname" id="firstname" <?php
                                        if (isset($userdata['first_name'])) {
                                            echo 'value="' . $userdata['first_name'] . '"';
                                        } elseif (isset($firstname)) {
                                            echo 'value="' . $firstname . '"';
                                        }
                                        ?> required>
                                               <?php
                                               if (isset($errors[0])) {
                                                   echo "<br><span class='text-center text-error'>";
                                                   echo $errors[0];
                                                   echo "</span>";
                                               }
                                               ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="lastname">Last Name</label>
                                    <div class="controls">
                                        <input type="text" name="lastname" id="lastname" <?php
                                        if (isset($userdata['last_name'])) {
                                            echo 'value="' . $userdata['last_name'] . '"';
                                        } elseif (isset($lastname)) {
                                            echo 'value="' . $lastname . '"';
                                        }
                                        ?> required>
                                               <?php
                                               if (isset($errors[1])) {
                                                   echo "<br><span class='text-center text-error'>";
                                                   echo $errors[1];
                                                   echo "</span>";
                                               }
                                               ?>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="email">Email Address</label>
                                    <div class="controls">
                                        <input type="email" name="email" id="email" <?php
                                        if (isset($userdata['email'])) {
                                            echo 'value="' . $userdata['email'] . '"';
                                        } elseif (isset($email)) {
                                            echo 'value="' . $email . '"';
                                        }
                                        ?> required>
                                               <?php
                                               if (isset($errors[2])) {
                                                   echo "<br><span class='text-center text-error'>";
                                                   echo $errors[2];
                                                   echo "</span>";
                                               }
                                               if (isset($errors[3])) {
                                                   echo "<br><span class='text-center text-error'>";
                                                   echo $errors[3];
                                                   echo "</span>";
                                               }
                                               ?>
                                    </div>
                                </div>
                                <input type="hidden" name="action" value="editing">
                                <div class="controls">
                                    <button type="submit" class="btn btn-success">Submit</button>
                            </fieldset>
                        </form>
                        <form class="form-horizontal" method="post" action=".">
                    <fieldset>
                        <legend>Change Password</legend>
                        <div class="control-group">
                            <label class="control-label" for="currpass">Current Password</label>
                            <div class="controls">
                                <input type="password" name="currpass" id="currpass" required>
                                <?php
                                if (isset($errors[4])) {
                                    echo "<br><span class='text-center text-error'>";
                                    echo $errors[4];
                                    echo "</span>";
                                } if (isset($errors[5])) {
                                    echo "<br><span class='text-center text-error'>";
                                    echo $errors[5];
                                    echo "</span>";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="newpass">New Password</label>
                            <div class="controls">
                                <input type="password" name="newpass" id="newpass" required>
                                <?php
                                if (isset($errors[6])) {
                                    echo "<br><span class='text-center text-error'>";
                                    echo $errors[6];
                                    echo "</span>";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="confpass">Confirm New Password</label>
                            <div class="controls">
                                <input type="password" name="confpass" id="confpass" required>
                                <?php
                                if (isset($errors[7])) {
                                    echo "<br><span class='text-center text-error'>";
                                    echo $errors[7];
                                    echo "</span>";
                                } if (isset($errors[8])) {
                                    echo "<br><span class='text-center text-error'>";
                                    echo $errors[8];
                                    echo "</span>";
                                }
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <input type="hidden" name="action" value="changepassword">
                                <button type="submit" class="btn btn-success">Change Password</button>
                            </div>
                        </div>
                    </fieldset>
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