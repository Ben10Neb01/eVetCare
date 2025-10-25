<?php
session_start();

//  Clear all session data
$_SESSION = [];

//  Destroy the session completely
session_destroy();

//  Optional: clear cookies (in case “Remember me” or others used)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

//  Redirect user
header("Location: index.php?logged_out=1");
exit();
?>
