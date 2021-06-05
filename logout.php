<?php

require_once "functions.php";

if (isset($_POST['logout']) && $_POST['logout'] == true) {
    session_start();
    $_SESSION = [];
    session_unset();
    session_destroy();
    setFlash('alert', "You've been logged out!", "success");
}

header("Location: " . base_url());
exit;
