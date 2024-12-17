<?php
// Clear the cookie by setting the expiration time in the past
setcookie("auth_token", "", time() - 3600, "/", "", false, true);

// Redirect to the login page after logout
header("Location: login.php");
exit;

