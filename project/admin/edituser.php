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
        <title>Edit User | Yellowstone Park</title>
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
                <h1 class="text-center">Edit User</h1>
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
                    <div class="span3"><?php include $_SERVER['DOCUMENT_ROOT'] . '/admin/modules/adminsidebar.php' ?></div>
                    <div class="span9">
                        <form method="post" action="?p=edituser">
                            <select name="uid" onchange="this.form.submit()">
                                <option value="" selected></option>
                                <?php
                                foreach ($users as $user) {
                                    echo '<option value="' . $user['account_id'] . '">' . $user['first_name'] . ' ' . $user['last_name'] . ' (' . $user['email'] . ')</option>';
                                }
                                ?>
                            </select>
                        </form>
                        <?php
                        if (!empty($userData)) {
                            echo '<p class="text-info lead">Editing account information for ';
                            echo $userData['first_name'] . ' ' . $userData['last_name'] . ' (' . $userData['email'] . ')';
                            echo '</p>';
                            echo '<p class="text-info">Account ID: ';
                            echo $userData['account_id'];
                        }
                        ?>
                        <fieldset>
                            <legend>User Information</legend>
                            <form class="form-horizontal" method="post" action=".">
                                <div class="control-group">
                                    <label class="control-label" for="firstname">First Name</label>
                                    <div class="controls">
                                        <input type="text" name="firstname" id="firstname" <?php
                                        if (isset($userData['first_name'])) {
                                            echo 'value="' . $userData['first_name'] . '"';
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
                                        if (isset($userData['last_name'])) {
                                            echo 'value="' . $userData['last_name'] . '"';
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
                                        if (isset($userData['email'])) {
                                            echo 'value="' . $userData['email'] . '"';
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
                                <input type="hidden" name="accountid" value="<?php echo $userData['account_id'] ?>">
                                <input type="hidden" name="p" value="edituser">
                                <input type="hidden" name="action" value="updateuserinfo">
                                <div class="controls">
                                    <button type="submit" class="btn btn-success">Update User Information</button>
                                </div>
                            </form>
                        </fieldset>
                        <fieldset>
                            <legend>Reset Password</legend>
                            <form class="form-horizontal" method="post" action=".">
                                <div class="control-group">
                                    <label class="control-label" for="newpassword">New Password</label>
                                    <div class="controls">
                                        <input type="password" name="newpassword" id="newpassword" required>
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
                                    <label class="control-label" for="confnewpassword">Confirm New Password</label>
                                    <div class="controls">
                                        <input type="password" name="confnewpassword" id="confnewpassword" required>
                                        <?php
                                        if (isset($errors[7])) {
                                            echo "<br><span class='text-center text-error'>";
                                            echo $errors[7];
                                            echo "</span>";
                                        }
                                        if (isset($errors[8])) {
                                            echo "<br><span class='text-center text-error'>";
                                            echo $errors[8];
                                            echo "</span>";
                                        }
                                        ?>
                                    </div>
                                </div>
                                <input type="hidden" name="accountid" value="<?php echo $userData['account_id'] ?>">
                                <input type="hidden" name="p" value="edituser">
                                <input type="hidden" name="action" value="resetpassword">
                                <div class="controls">
                                    <button type="submit" class="btn btn-success">Reset Password</button>
                                </div>
                            </form>
                        </fieldset>
                        <fieldset>
                            <legend>Change User's Role</legend>
                            <form class="form-horizontal" method="post" action=".">
                                <input type="hidden" name="accountid" value="<?php echo $userData['account_id'] ?>">
                                <input type="hidden" name="p" value="edituser">
                                <input type="hidden" name="action" value="changerole">
                                <div class="control-group">
                                    <label class="control-label" for="role">Role</label>
                                    <div class="controls">
                                        <select name="role" id="role">
                                            <?php
                                            foreach ($roles as $role) {
                                                echo '<option value="';
                                                echo $role['common_lookup_id'];
                                                echo '"';
                                                if ($userData['role'] == $role['common_lookup_id']) {
                                                    echo ' selected';
                                                }
                                                echo '>';
                                                echo $role['common_lookup_meaning'];
                                                echo '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="controls">
                                    <button type="submit" class="btn btn-success">Update Role</button>
                                </div>
                            </form>
                        </fieldset>
                        <fieldset>
                            <legend>Delete User</legend>
                            <form class="form-horizontal" method="post" action="." onsubmit="return confirm('Are you sure you want to delete this user? This cannot be undone!')">
                                <input type="hidden" name="accountid" value="<?php echo $userData['account_id'] ?>">
                                <input type="hidden" name="p" value="edituser">
                                <input type="hidden" name="action" value="deleteuser">
                                <div class="controls">
                                    <button type="submit" class="btn btn-danger">Delete This User</button>
                                </div>
                            </form>
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