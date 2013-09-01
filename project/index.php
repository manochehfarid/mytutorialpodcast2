<?php

// Start or resume the session
session_start();
/* * **********************************************************************
 *Information controller
 * This lets the user get certain files and communicates with the database
 * ********************************************************************* */

/* * *********************************************************
 * Require certain files (model,controller ,view)
 * ******************************************************** */

if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/content/model.php')) {
    require_once $_SERVER['DOCUMENT_ROOT'] . '/content/model.php';
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


/* * *********************************************************
 * Determine the desired action.
 * By default, we assume they want the home page
 * ******************************************************** */
if (!$_GET && !$_POST) {
    $cid = 'home';
} elseif (validateString($_GET['cid'])) {
    $cid = validateString($_GET['cid']);
} elseif (validateString($_POST['cid'])) {
    $cid = validateString($_POST['cid']);
}

/* Homepage request */
if ($cid == 'home') {
    // User has requested the homepage
    $contentlist= getContentList();
    include $_SERVER['DOCUMENT_ROOT'].'/content/home.php';
    exit;
}

/* Content request */
elseif ($cid) {
    $content = getContent($cid);
    $contentlist= getContentList();
    include $_SERVER['DOCUMENT_ROOT'].'/content/content.php';
    exit;
}
?>