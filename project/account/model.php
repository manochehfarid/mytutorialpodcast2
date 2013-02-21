<?php

/*
 * Interacts with the database 
 */

if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/connections/PDO.php')) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/connections/PDO.php';
}else{
    header('location: /errordocs/500.php');
    exit();
}


// register a user
function signMeUp($firstname,$lastname,$username,$password){
    global $con;
    
    try {
        $sql = 'INSERT INTO account(first_name,last_name,username,password)VALUES(:first,:last,:username,:password)';
        $stmt = $con->prepare($sql);
        $stmt->bindvalue(':first',$firstname);
        $stmt->bindvalue(':last', $lastname);
        $stmt->bindvalue(':username', $username);
        $stmt->bindvaule(':password', $password);
        $success = $stmt->execute();
        $rows = $stmt->rowCount();
        $stmt->closeCursor();
        
        return $rows;
    }  catch (PDOException $e){
        header('location: /errordocs/500.php');
    }
}
?>
