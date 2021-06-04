<?php

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
        $newFileName = uniqid() . "." . $fileExtension;

        # move file
        move_uploaded_file($fileDir, $directory . $newFileName);
    } else {
        $newFileName = null;
    }

    return $newFileName;
}
