<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('HTTP/1.0 404 Not Found', TRUE, 404);
    include "../404.php";
    die();
}

require_once "../functions.php";
require_once "../connection.php";

// Insert book
$title = htmlspecialchars($_POST['title']);
$slug = htmlspecialchars($_POST['slug']);
$description = htmlspecialchars($_POST['description']);
$writer = htmlspecialchars($_POST['writer']);
$publisher = htmlspecialchars($_POST['publisher']);
$year = htmlspecialchars($_POST['year']);
$price = htmlspecialchars($_POST['price']);
$stock = htmlspecialchars($_POST['stock']);
$thumbnail = upload_image($_FILES['thumbnail'], '../img/books/');
$category_id = $_POST['category_id'];

if ($thumbnail == null) {
    $thumbnail = "default-cover.svg";
}

$sql = "INSERT INTO `books` (`title`, `slug`, `description`, `writer`, `publisher`, `year`, `price`, `stock`, `category_id`, `thumbnail`) VALUES ('$title', '$slug', '$description', '$writer', '$publisher', '$year', '$price', '$stock', '$category_id', '$thumbnail')";
$query = mysqli_query($conn, $sql);

if (mysqli_affected_rows($conn) > 0) {
    header("Location: books.php");
    exit;
}
