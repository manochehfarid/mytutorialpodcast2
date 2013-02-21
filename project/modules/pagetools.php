<?php if($loginflag){
$logingreetings = '<span class="greeting">Welcome ' . $userfirst . '</span> | ';
if($userrights > 10) {
// if the logged in person is an administrator, display an administrative link in the tools area
$logingreetings .= '<a href="/account?action=admin" title="Go to the Admin area">Admin Page</a> | ';
}
$logingreetings .= '<a href="/account?action=logout">Logout</a>

echo $logingreetings;
} else {
echo '<a href="/account?action=register">Register</a> | <a href="/account?action=login">Login</a>
} ?>