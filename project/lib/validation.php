<?php

/*
 * Yellowsnow Validation functions
 * Used to validate and sanitize strings, and emails, as well as
 * check to see whether a user has already registered with an email address
 */

// Include the DB connection file for database interaction
if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/db/pdo.php')) {
    /* If that file exists, we're going to include it */
    require_once $_SERVER['DOCUMENT_ROOT'] . '/db/pdo.php';
} else {
    /* If for some reason, the server monster ate the file, we need to direct
     * the user to the 500 page
     */
    header('location: /error/500.php');
    exit;
}

// Sanitize a string to remove certain special characters and tags
function validateString($string) {
    $string = filter_var($string, FILTER_SANITIZE_STRING);
    return $string;
}

// Sanitize and validate integers
function validateInt($number) {
    $number = filter_var($number, FILTER_SANITIZE_NUMBER_INT);
    return $number;
}

// Sanitizes and filters a provided email address
// This does NOT check to see whether the email address is in the database
function validateEmail($email) {
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return $email;
    } else {
        return FALSE;
    }
}

// Checks to see whether the provided email address is in the database
function checkExistingEmailAddress($email) {
    // Bring the db connection object into scope
    global $dbconn;

    // Enclose this in a try block
    try {
        $sql = 'SELECT email FROM account
                WHERE email = :email';

        // Prepare the statement
        $statement = $dbconn->prepare($sql);
        // Bind the value to the $email variable
        $statement->bindValue(':email', $email);
        $statement->execute();
        // Get the results of the query and store in an array
        $results = $statement->fetch();
        $statement->closeCursor();
    } catch (PDOException $e) {
        // $error = $e->getMessage();
        // echo 'Something broke at try block 1: '.$error;
        header('location: /error/500.php');
        exit;
    }

// If the results array is empty, that means that there were no matches
// That's a GOOD thing :)
    if (!$results) {
        // In this case, we'll return false, meaning we did NOT find a match.
        return FALSE;
    } else {
        return TRUE;
    }
}

?>