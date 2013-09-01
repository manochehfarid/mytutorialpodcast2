<?php

session_start();

/*
 * Yellowstone Admin Area model
 * Manages DB interactions for admin functions
 */

/* * **********************************************************************
 * Require the database connection file
 * ********************************************************************* */
if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/db/pdo.php')) {
    /* If that file exists, we're going to include it */
    require_once $_SERVER['DOCUMENT_ROOT'] . '/db/pdo.php';
} else {
    /* If for some reason, the server monster ate the file, we need to direct
     * the user to the 500 page */
    header('location: /error/500.php');
    exit;
}

/* * ***************************************************
 *  Function to fetch site statistics
 *  This function will grow as the site does.
 *  For now, we'll only pull out user statistics
 * ************************************************** */

function siteStats() {
    global $dbconn;

    // Pull site statistics from the database
    // User count
    try {
        $sql = 'SELECT count(*) FROM account';
        $statement = $dbconn->prepare($sql);
        // Execute the statement
        $statement->execute();
        // Fetch the data into an array
        $userCount = $statement->fetch(PDO::FETCH_ASSOC);
        // Close the cursor
    } catch (PDOException $e) {
        // echo 'Something died';
        header('location: /error/500.php');
        exit;
    }

    // Start storing information in an array
    $siteStats['users'] = $userCount['count(*)'];

    // Most recent user
    try {
        $sql = 'SELECT first_name
            , last_name
            , email
            FROM account
            ORDER BY account_id DESC
            LIMIT 1';
        $statement = $dbconn->prepare($sql);
        // Execute the statement
        $statement->execute();
        // Fetch the data into an array
        $lastUser = $statement->fetch(PDO::FETCH_ASSOC);
        // Close the cursor
    } catch (PDOException $e) {
        // echo 'Something died';
        header('location: /error/500.php');
        exit;
    }

    // Store most recent user info
    $siteStats['recent_user_fn'] = $lastUser['first_name'];
    $siteStats['recent_user_ln'] = $lastUser['last_name'];
    $siteStats['recent_user_email'] = $lastUser['email'];

    return $siteStats;
}

/* * **************************************************
 *  Function to view all users
 * ************************************************** */

function getUsers() {
    global $dbconn;

    // Pull all users' information from the database
    try {
        $sql = 'SELECT a.account_id, a.first_name, a.last_name, a.email, cl.common_lookup_meaning AS role
            FROM account a INNER JOIN common_lookup cl
            ON a.role = cl.common_lookup_id';
        $statement = $dbconn->prepare($sql);
        // Execute the statement
        $statement->execute();
        // Fetch all the data into an associative array
        $users = $statement->fetchAll(PDO::FETCH_ASSOC);
        // Close the cursor
        $statement->closeCursor();
    } catch (PDOException $e) {
        // echo 'Problem in the statement';
        header('location: /error/500.php');
        exit;
    }


// If the users array is empty, that means the fetch failed. Return 0.
    if (!$users) {
        return 0;
    } else {
        return $users;
    }
}

/* * **************************************************
 *  Function to retrieve roles from the common_lookup
 * table
 * ************************************************** */

function getRoles() {
    global $dbconn;

    // Pull a list of all available roles from the DB
    try {
        $sql = 'SELECT common_lookup_id, common_lookup_meaning
            FROM common_lookup
            WHERE common_lookup_table = :account
            AND common_lookup_column = :role';
        $statement = $dbconn->prepare($sql);
        // Bind the values
        $statement->bindValue(':account', 'ACCOUNT');
        $statement->bindValue(':role', 'ROLE');
        // Execute the statement
        $statement->execute();
        // Fetch all the data into an associative array
        $roles = $statement->fetchAll(PDO::FETCH_ASSOC);
        // Close the cursor
        $statement->closeCursor();
    } catch (PDOException $e) {
        // echo 'Problem in the statement';
        header('location: /error/500.php');
        exit;
    }


// If the roles array is empty, that means the fetch failed. Return 0.
    if (!$roles) {
        return 0;
    } else {
        return $roles;
    }
}


/* * **************************************************
 *  Function to view a specific user
 * ************************************************** */

function viewUser($accountid) {
    global $dbconn;

    // Pull the user's information from the database
    try {
        $sql = 'SELECT account_id, first_name, last_name, email, role
            FROM account
            WHERE account_id = :accountid';
        $statement = $dbconn->prepare($sql);
        // Bind the value
        $statement->bindValue(':accountid', $accountid);
        // Execute the statement
        $statement->execute();
        // Fetch all the data into an associative array
        $user = $statement->fetch(PDO::FETCH_ASSOC);
        // Close the cursor
        $statement->closeCursor();
    } catch (PDOException $e) {
        // echo 'Problem in the statement';
        header('location: /error/500.php');
        exit;
    }


// If the users array is empty, that means the fetch failed. Return 0.
    if (!$user) {
        return 0;
    } else {
        return $user;
    }
}

/* * **************************************************
 *  Function to administratively update a user's info
 * ************************************************** */

function updateUserInfo($firstname, $lastname, $email, $accountid) {
    global $dbconn;

    // Begin the transaction
    $dbconn->beginTransaction();

    // Create and execute the prepared statement to update the ACCOUNT table
    try {
        $sql = "UPDATE account
            SET first_name = :firstname
            , last_name = :lastname
            , email = :email
            WHERE account_id = :accountid";
        $statement = $dbconn->prepare($sql);
        // Bind values
        $statement->bindValue(':firstname', $firstname);
        $statement->bindValue(':lastname', $lastname);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':accountid', $accountid);
        // Execute the statement
        $statement->execute();
        //Check to see how many rows were changed
        $rowChange = $statement->rowCount();
        // Close the cursor
        $statement->closeCursor();
    } catch (PDOException $e) {
        // echo 'Something went wrong';
        header('location: /error/500.php');
        exit;
    }

    // Check the rows changed. If it's not one, roll back and send a failure result
    if ($rowChange != 1) {
        $dbconn->rollback();
        return 0;
    } else {
        $dbconn->commit();
        return 1;
    }
}

/* * **************************************************
 *  Function to reset a password
 * ************************************************** */

function resetPassword($passwordhash, $accountid) {
    global $dbconn;

    // Begin the transaction
    $dbconn->beginTransaction();

    // Create and execute the prepared statement to update the ACCOUNT table
    try {
        $sql = "UPDATE account
            SET password = :passwordhash
            WHERE account_id = :accountid";
        $statement = $dbconn->prepare($sql);
        // Bind values
        $statement->bindValue(':passwordhash', $passwordhash);
        $statement->bindValue(':accountid', $accountid);
        // Execute the statement
        $statement->execute();
        // Check to see how many rows were changed
        $rowChange = $statement->rowCount();
        // Close the cursor
        $statement->closeCursor();
    } catch (PDOException $e) {
        // echo 'Something went wrong';
        header('location: /error/500.php');
        exit;
    }

    // Check the rows changed. If it's not one, roll back and send a failure result
    if ($rowChange != 1) {
        $dbconn->rollback();
        return 0;
    } else {
        $dbconn->commit();
        return 1;
    }
}

/* * **************************************************
 *  Function to change a user's role
 * ************************************************** */

function changeRole($role, $accountid) {
    global $dbconn;

    // Begin the transaction
    $dbconn->beginTransaction();

    // Create and execute the prepared statement to update the ACCOUNT table
    try {
        $sql = "UPDATE account
            SET role = :role
            WHERE account_id = :accountid";
        $statement = $dbconn->prepare($sql);
        // Bind values
        $statement->bindValue(':role', $role);
        $statement->bindValue(':accountid', $accountid);
        // Execute the statement
        $statement->execute();
        // Check to see how many rows were changed
        $rowChange = $statement->rowCount();
        // Close the cursor
        $statement->closeCursor();
    } catch (PDOException $e) {
        // echo 'Something went wrong';
        header('location: /error/500.php');
        exit;
    }

    // Check the rows changed. If it's not one, roll back and send a failure result
    if ($rowChange != 1) {
        $dbconn->rollback();
        return 0;
    } else {
        $dbconn->commit();
        return 1;
    }
}

/* * **************************************************
 *  Function to delete a user's information
 * ************************************************** */

function deleteUser($accountid) {
    global $dbconn;

    // Begin the transaction
    $dbconn->beginTransaction();
    
    // Create and execute the prepared statement to delete the information from the ACCOUNT table
    try {
        $sql = 'DELETE FROM account
            WHERE account_id = :accountid';
        $statement = $dbconn->prepare($sql);
        // Bind values
        $statement->bindValue(':accountid', $accountid);
        // Execute the statement
        $statement->execute();
        // Check to see how many rows were changed
        $rowChange = $statement->rowCount();
        // Close the cursor
        $statement->closeCursor();
    } catch (PDOException $e) {
        // echo 'Something went wrong...<br>';
        // echo 'Database error: ' . $e->getMessage();
        header('location: /error/500.php');
        exit;
    }

    // Check the rows changed. If it's not one, roll back and send a failure result
    if ($rowChange != 1) {
        $dbconn->rollback();
        return 0;
    } else {
        $dbconn->commit();
        return 1;
    }
    
}

?>