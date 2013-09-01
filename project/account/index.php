<?php

// Start or resume the session
session_start();
/* * **********************************************************************
 * Accounts controller
 * This controller handles login, logout, and registration functionality.
 * It also handles user editing.
 * In the future, it will also handle lost password services.
 * ********************************************************************* */

/* * *********************************************************
 * Require certain files (model, validation, passhash, etc)
 * ******************************************************** */

/* Require the model */
if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/account/model.php')) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/account/model.php';
} else {
    header('location: /error/500.php');
    exit;
}

/* Require the sanitation/validation file */
if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/lib/validation.php')) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/validation.php';
} else {
    header('location: /error/500.php');
    exit;
}

/* Require the password hashing file */
if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/lib/passhash.php')) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/lib/passhash.php';
} else {
    header('location: /error/500.php');
    exit;
}

/* Include the Javascript validation files... eventually */

/* * *********************************************************
 * Determine the desired action.
 * By default, we assume they want to login to the site.
 * ******************************************************** */
if (!$_GET && !$_POST) {
    header('location: ?action=login');
    exit;
} elseif (validateString($_GET['action'])) {
    $action = validateString($_GET['action']);
} elseif (validateString($_POST['action'])) {
    $action = validateString($_POST['action']);
}


/* * *********************************************************
 * Account actions
 * Login view, logging in, logout, register view,
 * registration handling, user information editing,
 * and password updates.
 * ******************************************************** */

/* Login */
if ($action == 'login') {
    // A login view has been requested
    include $_SERVER['DOCUMENT_ROOT'] .'account/login.php';
    exit;
}

/* Logging in (code for processing a login) */ 
elseif ($action == 'loggingin') {
    // Collect, sanitize, and validate the username and password
    $email = validateEmail($_POST['email']);
    $password = validateString($_POST['password']);

    // Validate the data (server-side)
    // Client side (Javascript) validation should also be implemented
    $errors = array();
    if (empty($email)) {
        $errors[1] = 'Please provide your email address';
    }
    if (empty($password)) {
        $errors[2] = 'Please provide your password';
    }

    // Check to make sure the errors array is empty.
    // If it's not, send the user back to try again.
    // The message is displayed above the login box, while the 
    // individual errors are displayed under their respective boxes.
    if (!empty($errors)) {
        $message['class'] = 'text-error';
        $message['message'] = 'There was a problem logging you in. Please correct the following errors.';
        include $_SERVER['DOCUMENT_ROOT'] . 'account/login.php';
        exit;
    }

    // If there were no errors, proceed.
    // Hash the password
    $passwordhash = hashPassword($password);

    // Call the model for DB interaction to verify credentials
    // This should return an array (if successful)
    $loginresult = loginUser($email, $passwordhash);

    // If the array has data, they were logged in. Start a session.
    // If the array is empty, their credentials were not valid.
    if (is_array($loginresult)) {
        // Login was successful. Start their session.
        $_SESSION['loggedin'] = TRUE;
        $_SESSION['accountid'] = $loginresult['account_id'];
        $_SESSION['role'] = $loginresult['role'];
        $_SESSION['email'] = $loginresult['email'];
        $_SESSION['firstname'] = $loginresult['first_name'];
        $_SESSION['lastname'] = $loginresult['last_name'];

        // Send them on their way.
        if ($loginresult['role'] == 1) { // 1 is a site admin
            header('location: /admin');
            exit;
        } elseif ($loginresult['role'] > 1) { // Anything above 1 is not an admin
            header('location: /');
            exit;
        }
    } else {
        // Their login was not successful. Send them back to try again.
        $message['class'] = 'text-error';
        $message['message'] = 'There was a problem with your credentials. Please check them and try again.';
        include $_SERVER['DOCUMENT_ROOT'] . 'account/login.php';
        exit;
    }
}

/* Logout */ 
elseif ($action == 'logout') {
    // Code for cleaning up a session and logging the user out
    // Empty the array        
    $_SESSION['loggedin'] = FALSE;
    $_SESSION['accountid'] = '';
    $_SESSION['role'] = '';
    $_SESSION['email'] = '';
    $_SESSION['firstname'] = '';
    $_SESSION['lastname'] = '';

    // For good measure, we'll unset everything
    unset($_SESSION['loggedin']);
    unset($_SESSION['accountid']);
    unset($_SESSION['role']);
    unset($_SESSION['email']);
    unset($_SESSION['firstname']);
    unset($_SESSION['lastname']);

    header('location: logout.php');
    exit;
}

/* Register View */ 
elseif ($action == 'register') {
    // A registration view has been requested
    include $_SERVER['DOCUMENT_ROOT'] . 'account/register.php';
    exit;
}

/* Registration (code for processing a registration request) */ 
elseif ($action == 'registration') {
    // Code for handling a registration request
    // Collect and sanitize the data
    $email = validateEmail($_POST['email']);
    $password = validateString($_POST['password']);
    $confpass = validateString($_POST['confpass']);
    $firstname = validateString($_POST['firstname']);
    $lastname = validateString($_POST['lastname']);

    // Verify the collected data (server side validation)
    // Store any errors into an array
    $errors = array();
    // Check the first and last names
    if (empty($firstname)) {
        $errors[0] = 'Please provide a valid first name.';
    }
    if (empty($lastname)) {
        $errors[1] = 'Please provide a valid last name.';
    }
    // Validate the email address
    if (empty($email)) {
        $errors[2] = 'Please enter a valid email address.';
    }
    // Check to see if the email address has already been used
    if (checkExistingEmailAddress($email)) {
        $errors[3] = 'This email address has already been used. Please try another one or <a href="/account/?action=login">login</a>.';
    }
    // Validate the passwords to make sure they are strings
    if (empty($password)) {
        $errors[4] = 'Please provide a valid password.';
    }
    if (empty($confpass)) {
        $errors[5] = 'This field cannot be empty';
    }
    // Make sure the passwords match
    if ($password != $confpass) {
        $errors[6] = 'The passwords provided don\'t match. Please try again.';
    }

    // Check for errors and send back for correction if needed.
    if ($errors) {
        $message['class'] = 'text-error';
        $message['message'] = 'There were errors with your registration. Please correct these problems and try again';
        include $_SERVER['DOCUMENT_ROOT'] .'account/register.php';
        exit;
    }
    
    // No errors? Let us press on then!
    // Hash the password
    $passwordhash = hashPassword($password);

    // Call the model for DB interaction
    $registration = registerUser($email, $passwordhash, $firstname, $lastname);

    if ($registration == 1) {
        $message['class'] = 'text-success';
        $message['message'] = "$firstname, your registration was successful. Please login using your email address and password.";
        include $_SERVER['DOCUMENT_ROOT'] . 'account/login.php';
        exit;
    } else {
        $message['class'] = 'text-error';
        $message['message'] = 'It seems there was a problem processing your registration. Please contact the website admin.';
        include $_SERVER['DOCUMENT_ROOT'] . 'account/register.php';
        exit;
    }
}

/* My Account view */ 
elseif ($action == 'myaccount') {
    // A My Account view has been requested
    // Never trust the information from the user!
    // For this action, we will pull their information from the database again
    // rather than pulling it form the session data.
    // This might be overkill on security, but better safe than sorry...
    // Call the model for DB interaction
    $userdata = myAccount($_SESSION['accountid']);
    if (is_array($userdata)) {
        $message['class'] = 'text-success';
        $message['message'] = 'User information successfully retrieved from database.<br>Please edit your information.';
        include $_SERVER['DOCUMENT_ROOT'] . 'account/myaccount.php';
        exit;
    } else {
        $message['class'] = 'text-error';
        $message['message'] = 'There was a problem retrieving your information from the database. Try <a href="/account/?action=logout">logging out</a> and logging back in. If the problem persists, contact the website admin.';
        include $_SERVER['DOCUMENT_ROOT'] . 'account/myaccount.php';
        exit;
    }
}

/* Edit user information */
elseif ($action == 'editing') {
    // Code for handling user account editing
    // Collect and sanitize the data
    $firstname = validateString($_POST['firstname']);
    $lastname = validateString($_POST['lastname']);
    $email = validateEmail($_POST['email']);

    // Verify the collected data (server-side validation)
    // Store any errors into an array
    $errors = array();
    // Validate the first name
    if (empty($firstname)) {
        $errors[0] = 'Please enter your first name';
    }
    // Validate the last name
    if (empty($lastname)) {
        $errors[1] = 'Please enter your last name';
    }
    // Validate the email address
    if (!$email) {
        $errors[2] = 'Please enter a valid email address';
    }
    // Check to make sure someone else isn't using the email address
    if ($email != $_SESSION['email'] && checkExistingEmailAddress($email)) {
        $errors [3] = 'This email address is already in use. Please try another one.';
    }

    // Finally, check to see if there were actually any changes.
    // If not, we don't need to process any futher.
    if ($firstname == $_SESSION['firstname'] && $lastname == $_SESSION['lastname'] && $email == $_SESSION['email']) {
        // Grab their info from the DB again to populate the page
        $userdata = myAccount($_SESSION['accountid']);
        $message['class'] = 'text-info';
        $message['message'] = 'No changes detected';
        include $_SERVER['DOCUMENT_ROOT'] .'account/myaccount.php';
        exit;
    }

    // Check for errors and send back for correction if needed
    if ($errors) {
        // Grab their info from the DB again to populate the page
        $userdata = myAccount($_SESSION['accountid']);
        $message['class'] = 'text-error';
        $message['message'] = 'There were errors with your changes. Please verify your information and try again.';
        include $_SERVER['DOCUMENT_ROOT'] .'account/myaccount.php';
        exit;
    }

    // No errors? Press forward!
    // Call the model for DB interaction
    $userUpdate = updateUserInformation($firstname, $lastname, $email, $_SESSION['accountid']);

    // At this point, we need to take their data and update their session.
    if ($userUpdate == 1) {
        // Grab their info from the DB again to populate the page
        $userdata = myAccount($_SESSION['accountid']);
        // Update the session data
        $_SESSION['firstname'] = $userdata['first_name'];
        $_SESSION['lastname'] = $userdata['last_name'];
        $_SESSION['email'] = $userdata['email'];
        $message['class'] = 'text-success';
        $message['message'] = 'Your information was successfuly updated';
        include $_SERVER['DOCUMENT_ROOT'] .'account/myaccount.php';
        exit;
    } else {
        // Grab their info from the DB again to populate the page
        $userdata = myAccount($_SESSION['accountid']);
        $message['class'] = 'text-error';
        $message['message'] = 'There was a problem updating your information.<br>Please try again or contact the site admin.';
        include $_SERVER['DOCUMENT_ROOT'] .'account/myaccount.php';
        exit;
    }
}

/* Change password */
elseif ($action == 'changepassword') {
    // Code for changing a user's password
    // Collect and sanitize the data
    $currentPassword = validateString($_POST['currpass']);
    $newPassword = validateString($_POST['newpass']);
    $confNewPass = validateString($_POST['confpass']);

    // Verify the collected data (server-side validation)
    // Store any errors into an array
    $errors = array();
    // Verify that the user actually provided their current password
    if (empty($currentPassword)) {
        $errors[4] = 'Please provide your current password';
    }
    // Verify the provided password against the one stored in the database.
    // Hash the currentPassword value for verification against the
    // hash stored in the database
    $currPassHash = hashPassword($currentPassword);
    $passVerification = loginUser($_SESSION['email'], $currPassHash);
    if (!is_array($passVerification)) {
        $errors[5] = 'The password provided does not match what\'s stored in the database';
    }
    // Make sure the new password is a string
    if (empty($newPassword)) {
        $errors[6] = 'Please provide a new password';
    }
    // Make sure the confNewPass is a string
    if (empty($confNewPass)) {
        $errors[7] = 'This field cannot be left blank';
    }
    // Make sure the new password and confirmation match
    if ($newPassword != $confNewPass) {
        $errors [8] = 'The passwords provided do not match';
    }

    // Check for errors and send back for correction if needed
    if ($errors) {
        $userdata = myAccount($_SESSION['accountid']);
        $message['class'] = 'text-error';
        $message['message'] = 'There were errors with your changes. Please verify your information and try again.';
        include $_SERVER['DOCUMENT_ROOT'] .'account/myaccount.php';
        exit;
    }

    // If there were no errors, hash the new password
    $passwordhash = hashPassword($newPassword);

    // Pass the information onto the model for processing
    $passwordUpdate = changePassword($passwordhash, $_SESSION['accountid']);
    
    // Check to make sure their password was updated.
    // We don't need to update their session in this case.
    if ($passwordUpdate == 1) {
        $userdata = myAccount($_SESSION['accountid']);
        $message['class'] = 'text-success';
        $message['message'] = 'Your password was successfuly updated';
        include $_SERVER['DOCUMENT_ROOT'] .'account/myaccount.php';
        exit;
    } else {
        $userdata = myAccount($_SESSION['accountid']);
        $message['class'] = 'text-error';
        $message['message'] = 'There was a problem updating your password.<br>Please try again or contact the site admin.';
        include $_SERVER['DOCUMENT_ROOT'] .'account/myaccount.php';
        exit;
    }
}
?>