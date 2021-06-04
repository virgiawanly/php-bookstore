<?php

/* at the top of 'check.php' */
if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('HTTP/1.0 404 Not Found', TRUE, 404);
    include "../404.php";
    die();
}

require_once "../connection.php";

$id = $_POST['id'];
$sql = "DELETE FROM books WHERE `id` = '$id'";
mysqli_query($conn, $sql);

if (mysqli_affected_rows($conn) > 0) {
    header("Location: books.php");
    exit;
} else {
    // header("Location: books.php");
    // exit;
}
