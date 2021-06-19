<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET' && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
    header('HTTP/1.0 404 Not Found', TRUE, 404);
    include "../404.php";
    die();
}
session_start();

require_once "../functions.php";
require_once "../connection.php";

// Insert book
$id = htmlspecialchars($_POST['id']);
$title = htmlspecialchars($_POST['title']);
$slug = htmlspecialchars($_POST['slug']);
$description = htmlspecialchars($_POST['description']);
$writer = htmlspecialchars($_POST['writer']);
$publisher = htmlspecialchars($_POST['publisher']);
$year = htmlspecialchars($_POST['year']);
$price = htmlspecialchars($_POST['price']);
$stock = htmlspecialchars($_POST['stock']);
$category_id = $_POST['category_id'];
$currentThumbnail = htmlspecialchars($_POST['currentThumbnail']);

if ($_FILES['thumbnail']['error'] === 4) {
    $thumbnail = $currentThumbnail;
} else {
    $thumbnail =  upload_image($_FILES['thumbnail'], '../img/books/');

    // Delete file lama
    if ($currentThumbnail != 'default-cover.svg' && $thumbnail != null) {
        if (file_exists('../img/books/' . $currentThumbnail)) {
            unlink('../img/books/' .  $currentThumbnail);
        }
    }
}

$sql = "UPDATE `books` SET `title` = '$title', 
    `slug` = '$slug', `description` = '$description', 
    `writer` = '$writer', `publisher` = '$publisher', 
    `year` = '$year', `price` = '$price', 
    `stock` = '$stock', `category_id` = '$category_id',
    `thumbnail` = '$thumbnail' 
    WHERE `id` = '$id'";

mysqli_query($conn, $sql);

if (mysqli_affected_rows($conn) > 0) {
    setFlash('alert', 'Buku berhasil diupdate.');
} else {
    setFlash('alert', 'Terjadi kesalahan.', 'danger');
}
header("Location: books.php");
exit;
