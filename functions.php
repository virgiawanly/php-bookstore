<?php

require_once "connection.php";

function base_url($url = '')
{
    $host = $_SERVER['HTTP_HOST'];
    $host_upper = strtoupper($host);
    $path = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $folder = explode('/', $path);
    $baseurl = "http://" . $host . '/' . $folder[1] . "/";

    if ($url != '') {
        $baseurl .= $url;
    }
    return $baseurl;
}

function upload_image($file, $directory)
{
    if ($file['error'] !== 4) {
        $fileName = $file['name'];
        $fileSize = $file['size'];
        $fileDir = $file['tmp_name'];

        # allowed file type
        $allowedType = ['jpg', 'jpeg', 'png', 'webp', 'svg'];

        # get file extension
        $fileExtension = explode('.', $fileName);
        $fileExtension = strtolower(end($fileExtension));

        # generate new unique name
        $newFileName = "IMG-" . uniqid() . "." . $fileExtension;

        # move file
        move_uploaded_file($fileDir, $directory . $newFileName);
    } else {
        $newFileName = null;
    }

    return $newFileName;
}

function setFlash($name, $message = "", $type = "success")
{
    $_SESSION["$name"] = "<div class='alert alert-$type alert-dismissible fade show' role='alert'>$message
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                        </div>";
}

function getFlash($name)
{
    if (isset($_SESSION["$name"])) {
        echo $_SESSION["$name"];
        unset($_SESSION["$name"]);
    }
}


function addToCart($bookId, $userId)
{
    // Cek apakah user sudah login?
    if (!isset($_SESSION['login'])) {
        header("Location: " . base_url('login.php'));
        exit;
    }

    global $conn;

    // Cek apakah produk sudah ada di keranjang
    $sql = "SELECT * FROM carts WHERE `user_id` = '$userId' AND `book_id` = '$bookId'";
    $hasil =  mysqli_fetch_assoc(mysqli_query($conn, $sql));

    // Jika produk sudah ada di keranjang
    if ($hasil != null) {
        $response = (object) [
            "success" =>  false,
            "message" =>  "Buku sudah ada di Cart"
        ];
        return $response;
    }

    // Insert ke tabel carts
    $sql = "INSERT INTO carts (`user_id`, `book_id`) VALUES ('$userId', '$bookId')";
    mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) > 0) {
        $response = (object) [
            "success" => true,
            "message" => "Buku sudah ditambahkan ke cart"
        ];
        return $response;
    }
}
