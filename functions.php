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
