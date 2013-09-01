<?php

// Start or resume the session
session_start();
/* * **********************************************************************
 * Accounts model
 * This model is used to interact with the database for account functions.
 * Handles logins, registrations, and account information updates.
 * ********************************************************************* */

/* * *********************************************************
 * Require the database connection file
 * ******************************************************** */
if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/db/pdo.php')) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/db/pdo.php';
} else {
    header('location: /error/500.php');
    exit;
}

/* * *********************************************************
 * Account model functions
 * Functions for handling logins, registrations, and account
 * information updates.
 * ******************************************************** */

/* Login user */

function loginUser($email, $passwordhash) {
// Bring dbconnection into scope
    global $dbconn;

// Pull the user's information from the DB
    try {
// SQL statement for selecting user information
        $sql = 'SELECT account_id, first_name, last_name, email, role
            FROM account
            WHERE email = :email AND password = :password';
        $statement = $dbconn->prepare($sql);
// Bind the values
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $passwordhash);
// Execute the statement
        $statement->execute();
// Fetch the data into an associative array
        $userdata = $statement->fetch();
// Disconnect from DB
        $statement->closeCursor();
    } catch (PDOException $e) {
// Something failed in the statement.
// echo 'We had a problem here';
        header('location: /error/500.php');
        exit;
    }

// If the userdata array is empty, that means their login failed. Return 0.
    if (!$userdata) {
        return 0;
    } else {
// Login succeeded and the userdata array is populated.
// Return the array to the controller to start the session.
        return $userdata;
    }
}

/* Regsiter User */

function registerUser($email, $passwordhash, $firstname, $lastname) {
// Bring dbconnection into scope
    global $dbconn;

// Begin the transaction
    $dbconn->beginTransaction();

// Create & execute the prepared statement to write to the ACCOUNT table
    try {
        $sql = "INSERT INTO account (first_name, last_name, email, password, role, creation_date, password_last_updated)
            VALUES
            (:first, :last, :email, :password, 2, NOW(), NOW())"; // 2 is a site user
        $statement = $dbconn->prepare($sql);
// Bind the values
        $statement->bindValue(':first', $firstname);
        $statement->bindValue(':last', $lastname);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $passwordhash);
// Execute the statement
        $statement->execute();
// Get the number of rows inserted
        $rowsInserted = $statement->rowCount();
// Close the cursor
        $statement->closeCursor();
    } catch (PDOException $e) {
// Something failed in the statement.
// echo 'We had a problem here';
        header('location: /error/500.php');
        exit;
    }

// Check the rows inserted
// If it's one, we were successful
// Commit the data and return 1
    if ($rowsInserted == 1) {
        $dbconn->commit();
        return 1;
    } else {
        $dbconn->rollback();
        return 0;
    }
}

/* My Account
 * Used to pull info from the DB for populating the My Account page
 */

function myAccount($accountid) {
// Bring dbconnection into scope
    global $dbconn;

// Pull the user's info from the DB
    try {
        $sql = 'SELECT first_name, last_name, email, creation_date
            FROM account
            WHERE account_id = :accountid';
        $statement = $dbconn->prepare($sql);
// Bind the value
        $statement->bindValue(':accountid', $accountid);
// Execute the statement
        $statement->execute();
// Fetch the data into an associative array
        $userdata = $statement->fetch(PDO::FETCH_ASSOC);
// Disconnect from the DB
        $statement->closeCursor();
    } catch (PDOException $e) {
// Something failed in the statement.
// echo 'We had a problem here';
        header('location: /error/500.php');
        exit;
    }

// If the userdata array is empty, something went wrong. Return 0
    if (!$userdata) {
        return 0;
    } else {
// The SQL statement was successful. Return the array.
        return $userdata;
    }
}

/* Update user information (first name, last name, email */

function updateUserInformation($firstname, $lastname, $email, $accountid) {
// DB connection
    global $dbconn;

// Begin the transaction
    $dbconn->beginTransaction();

// Create and execute the prepared statement to update the ACCOUNT table
    try {
        $sql = 'UPDATE account
            SET first_name = :firstname,
            last_name = :lastname,
            email = :email
            WHERE account_id = :accountid';
        $statement = $dbconn->prepare($sql);
// Bind the values
        $statement->bindValue(':firstname', $firstname);
        $statement->bindValue(':lastname', $lastname);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':accountid', $accountid);
// Execute the statement
        $statement->execute();
// Check to see how many rows were changed
        $rowchange = $statement->rowCount();
// Close the cursor
        $statement->closeCursor();
    } catch (PDOException $e) {
// echo 'Something went wrong';
        header('location: /error/500.php');
        exit;
    }

// Check the rows changed. It should only be 1
    if ($rowchange != 1) {
        $dbconn->rollback();
        return 0;
    } else {
        $dbconn->commit();
        return 1;
    }
}

/* Change Password (allows a user to change their password) */

function changePassword($passwordhash, $accountid) {
// DB connection object
    global $dbconn;

// Begin the transaction
    $dbconn->beginTransaction();

// Create and execute the prepared statement to update the ACCOUNT table
    try {
        $sql = 'UPDATE account
            SET password = :passwordhash
            , password_last_updated = NOW()
            WHERE account_id = :accountid';
        $statement = $dbconn->prepare($sql);
        // Bind the values
        $statement->bindValue(':passwordhash', $passwordhash);
        $statement->bindValue(':accountid', $accountid);
        // Execute the statement
        $statement->execute();
        // Check to see how many rows were changed
        $rowchange = $statement->rowCount();
        // Close the cursor
        $statement->closeCursor();
    } catch (PDOException $e) {
        // echo 'Something went wrong';
        header('location: /error/500.php');
        exit;
    }

    // Check rows changed. If it's not one, rollback
    if ($rowchange != 1) {
        $dbconn->rollback();
        return 0;
    } else {
        $dbconn->commit();
        return 1;
    }
}

?>