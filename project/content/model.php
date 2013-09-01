<?php

/* * **********************************************************************
 * This is the model that will pull the information from the database and
 * will be displayed in the view.
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

function getContent($content_id) {
// Bring dbconnection into scope
    global $dbconn;

// Pull the user's information from the DB
    try {
// SQL statement for selecting user information
        $sql = 'SELECT c.content_id,
            cl.common_lookup_meaning AS content_category,
            c.content_name,
            c.content_description,
            c.content_season,
            c.content_location,
            c.content_rules
            FROM content c INNER JOIN common_lookup cl
            ON c.content_category = cl.common_lookup_id
            WHERE c.content_id = :contentid';
        $statement = $dbconn->prepare($sql);
// Bind the values
        $statement->bindValue(':contentid', $content_id);
// Execute the statement
        $statement->execute();
// Fetch the data into an associative array
        $content = $statement->fetch(PDO::FETCH_ASSOC);
// Disconnect from DB
        $statement->closeCursor();
    } catch (PDOException $e) {
// Something failed in the statement.
// echo 'We had a problem here';
        header('location: /error/500.php');
        exit;
    }

// If the userdata array is empty. Return 0.
    if (!$content) {
        return 0;
    } else {
// Login succeeded and the userdata array is populated.
// Return the array to the controller to start the session.
        return $content;
    }
}

function getContentList() {
    global $dbconn;

    // Create and execute the prepared statement to retrieve all items from the content table
    try {
        $sql = 'SELECT content_id, content_name
            FROM content';
        $statement = $dbconn->prepare($sql);
        // Execute the statement
        $statement->execute();
        // Fetch the data into an array
        $contentlist = $statement->fetchAll(PDO::FETCH_ASSOC);
        // Disconnect
        $statement->closeCursor();
    } catch (PDOException $e) {
        // echo 'Something went wrong';
        header('location: /error/500.php');
        exit;
    }

    if (!$contentlist) {
        return 0;
    } else {
// Login succeeded and the userdata array is populated.
// Return the array to the controller to start the session.
        return $contentlist;
    }
}

?>