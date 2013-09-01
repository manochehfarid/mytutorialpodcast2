<?php

session_start();
/*
 * Yellowstone Admin Area controller
 * Manages admin functions, such as updating content and changing user information
 */

/* * **********************************************************************
 * Security - Check to make sure the user is an admin.
 * If they're not, send them back to the homepage.
 * ********************************************************************* */
if (!$_SESSION['loggedin'] || $_SESSION['role'] != 1) {
    header('location: /');
    exit;
}

/* * **********************************************************************
 * Required files
 * ********************************************************************* */
// Admin Model file
if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/admin/model.php')) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/model.php';
} else {
    header('location: /error/500.php');
    exit;
}

// Sanitation/validation file
if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/lib/validation.php')) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/validation.php';
} else {
    header('location: /error/500.php');
    exit;
}

// Password hashing file
if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/lib/passhash.php')) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/passhash.php';
} else {
    header('location: /error/500.php');
    exit;
}

/* * **********************************************************************
 * Determine actions
 * If no action is defined, take the user to the site overview page
 * ********************************************************************* */
// Page
if (!$_GET && !$_POST) {
    header('location: ?p=main');
    exit;
} elseif (validateString($_GET['p'])) {
    $page = validateString($_GET['p']);
} elseif (validateString($_POST['p'])) {
    $page = validateString($_POST['p']);
}

// User ID
if (validateInt($_GET['uid'])) {
    $accountid = validateInt($_GET['uid']);
} elseif (validateInt($_POST['uid'])) {
    $accountid = validateInt($_POST['uid']);
}

// Action
if (validateString($_GET['action'])) {
    $action = validateString($_GET['action']);
} elseif (validateString($_POST['action'])) {
    $action = validateString($_POST['action']);
}

/* * **********************************************************************
 * Pages & actions
 * ********************************************************************* */
// Main page
if ($page == 'main') {
    // The main page has been requested
    $siteStats = siteStats();
    include 'main.php';
    exit;
}

// View Users page
elseif ($page == 'users') {
    // The View Users page has been requested
    $users = getUsers();
    include 'viewusers.php';
    exit;
}

// Edit user page
elseif ($page == 'edituser' && empty($action)) {
    $users = getUsers();
    $roles = getRoles();
    if (isset($accountid)) {
        $userData = viewUser($accountid);
    }
    include 'edituser.php';
    exit;
}

// Update the user information
elseif ($page == 'edituser' && $action == 'updateuserinfo') {
    // Collect and sanitize the data
    $firstname = validateString($_POST['firstname']);
    $lastname = validateString($_POST['lastname']);
    $email = validateEmail($_POST['email']);
    $accountid = validateInt($_POST['accountid']);
    $userData = viewUser($accountid);

    // Verify the collected data (server-side validation)
    // Store any errors into an array
    $errors = array();
    // Validate the first name
    if (empty($firstname)) {
        $errors[0] = 'Please enter the user\'s first name';
    }
    // Validate the last name
    if (empty($lastname)) {
        $errors[1] = 'Please enter the user\'s last name';
    }
    // Validate the email address
    if (!$email) {
        $errors[2] = 'Please enter a valid email address';
    }
    // Check to make sure someone else isn't using the email address
    if ($email != $userData['email'] && checkExistingEmailAddress($email)) {
        $errors [3] = 'The email address provided is already in use by another user.';
    }

    // Check for errors and send back for correction if needed
    if ($errors) {
        $users = getUsers();
        $roles = getRoles();
        $userData = viewUser($accountid);
        $message['class'] = 'text-error';
        $message['message'] = 'There were errors with the changes made. Please verify the user\'s information and try again.';
        include 'edituser.php';
        exit;
    }

    // If there were no errors, we can press forward and update their information
    // Call the model for DB interaction
    $userUpdate = updateUserInfo($firstname, $lastname, $email, $accountid);

    // If the user was updated successfully, inform the admin
    if ($userUpdate == 1) {
        $users = getUsers();
        $roles = getRoles();
        $userData = viewUser($accountid);
        $message['class'] = 'text-success';
        $message['message'] = 'User information successfully updated';
        include 'edituser.php';
        exit;
    } else {
        $users = getUsers();
        $roles = getRoles();
        $userData = viewUser($accountid);
        $message['class'] = 'text-error';
        $message['message'] = 'There was a problem updating the user\'s information. Please try again, or better yet, check your code!';
        include 'edituser.php';
        exit;
    }
}

// Reset a user's password
elseif ($page == 'edituser' && $action == 'resetpassword') {
    // Collect and sanitize the data
    $newpassword = validateString($_POST['newpassword']);
    $confnewpassword = validateString($_POST['confnewpassword']);
    $accountid = validateInt($_POST['accountid']);

    // Verify collected data (server-side validation)
    // Store any errors into an array
    $errors = array();
    // Verify that a new password was provided
    if (empty($newpassword)) {
        $errors[6] = 'Please provide a new password';
    }
    // Verify that a confirmation password was provided
    if (empty($confnewpassword)) {
        $errors[7] = 'This field cannot be left blank';
    }
    // Make sure the passwords match
    if ($newpassword != $confnewpassword) {
        $errors[8] = 'The passwords provided did not match';
    }

    // Check for errors and send back for correction if needed
    if ($errors) {
        $users = getUsers();
        $roles = getRoles();
        $userData = viewUser($accountid);
        $message['class'] = 'text-error';
        $message['message'] = 'There were errors with the changes made. Please verify the user\'s information and try again.';
        include 'edituser.php';
        exit;
    }

    // If there were no errors, hash the new password
    $passwordhash = hashPassword($newpassword);

    // If there were no errors, we can press forward and update their information
    // Call the model for DB interaction
    $userUpdate = resetPassword($passwordhash, $accountid);

    // If the user was updated successfully, inform the admin
    if ($userUpdate == 1) {
        $users = getUsers();
        $roles = getRoles();
        $userData = viewUser($accountid);
        $message['class'] = 'text-success';
        $message['message'] = 'Password successfully reset';
        include 'edituser.php';
        exit;
    } else {
        $users = getUsers();
        $roles = getRoles();
        $userData = viewUser($accountid);
        $message['class'] = 'text-error';
        $message['message'] = 'There was a problem reseting the user\'s password. Please try again, or better yet, check your code!';
        include 'edituser.php';
        exit;
    }
}

// Change the user's role
elseif ($page == 'edituser' && $action == 'changerole') {
    // Collect and sanitize the data
    $role = validateInt($_POST['role']);
    $accountid = validateInt($_POST['accountid']);

    // Frankly, in this situation, there should be no errors to check for...
    // I'm probably wrong about that... but we'll find out eventually.
    // Press forward. Call the model for DB interaction
    $userUpdate = changeRole($role, $accountid);

    // If the user was updated successfully, inform the admin
    if ($userUpdate == 1) {
        $users = getUsers();
        $roles = getRoles();
        $userData = viewUser($accountid);
        $message['class'] = 'text-success';
        $message['message'] = 'Role successfully updated';
        include 'edituser.php';
        exit;
    } else {
        $users = getUsers();
        $roles = getRoles();
        $userData = viewUser($accountid);
        $message['class'] = 'text-error';
        $message['message'] = 'There was a problem updating the user\'s role. Please try again, or better yet, check your code!';
        include 'edituser.php';
        exit;
    }
}

// Delete the user's registration and information
elseif ($page == 'edituser' && $action == 'deleteuser') {
    // Collect & validate the data
    $accountid = validateInt($_POST['accountid']);

    // Once again, in this situation, we shouldn't really run into any errors.
    // Once again, I'm probably wrong... oh well...
    // Press forward. Call the model for DB interaction
    $deleteResult = deleteUser($accountid);

    // If the user was updated successfully, inform the admin
    if ($deleteResult == 1) {
        $users = getUsers();
        $roles = getRoles();
        $message['class'] = 'text-success';
        $message['message'] = 'User successfully deleted';
        include 'edituser.php';
        exit;
    } else {
        $users = getUsers();
        $roles = getRoles();
        $userData = viewUser($accountid);
        $message['class'] = 'text-error';
        $message['message'] = 'There was a problem deleting this user. Please try again, or better yet, check your code!';
        include 'edituser.php';
        exit;
    }
}
?>