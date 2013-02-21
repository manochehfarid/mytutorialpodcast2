<?php

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>Login | Yellowstone Project</title>
<?php include $_SERVER['DOCUMENT_ROOT'] . '../modules/head.php'; ?>
<link href="../css/print.css" rel="stylesheet" type="text/css">
</head>
<body>
<header id="page-header">
<div class="container sixteen columns">
<div class="ten columns">
<?php include $_SERVER['DOCUMENT_ROOT'] . '/modules/pageheader.php';?>
</div>
<div id="tools" class="six columns">
<?php include $_SERVER['DOCUMENT_ROOT'].'/modules/pagetools.php';?>
</div>
</div>
</header>
<nav id="pagenav">
<div class="container sixteen columns">
<?php include $_SERVER['DOCUMENT_ROOT'].'/modules/pagenav.php';?>
</div>
</nav>
<div id="page-content">
<div class="container sixteen columns">
<h1>Login</h1>
<?php
if(isset($message)){ echo "<p class='message'>$message</p>";} elseif(!empty($errors)){echo '<ul class="errors">';
foreach($errors as $errors){
	echo '<li>' . $error . '</li>';
	}
	echo '</ul>';
}?>
<p>Login Please</p>

<form method="post" action=".">
<fieldset>
<label for="iusername">Username</label>
<input type="email" name="iusername" id="iusername" size="30"><span class="info">(This is your username)</span><br>
<label for="ipassword">Password</label>
<input type="password" name="ipassword" id="ipassword" size="10"><br>
<label for="action">&nbsp;</label>
<input type="submit" name="submit" id="action" value="Login">
<input type="hidden" name="action" value="loggingin">
</fieldset>
</form>
</div>
</div>
<footer id="page-footer">
<div class="container sixteen columns">
<?php include $_SERVER['DOCUMENT_ROOT'].'/modules/pagefooter';?>
<p>Last Updated: <?php echo date('j F, Y', getlastmod()); ?></p>
</div>
</footer>
</body>
</html>
<?php unset($message); ?>