<?php

require base_path('core/response.php');

//var_dump and die for debug purpose
function dd($value)
{
    echo '<pre>' , var_dump($value) , '</pre>';

    die();
}

//add prefix to match current directory with root directory of web
function base_path($path)
{
    return BASE_PATH . $path;
}

//For page not found or authorize problems
function abort($code = 404)
{
    http_response_code($code);

    $heading = '';

    require base_path("view/response/$code.php");

    die();
}

//format size of file
function formatBytes($size, $precision = 2)
{
    $base = log($size, 1024);
    $suffixes = array('', 'KB', 'MB', 'GB', 'TB');   

    return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
}

//add unique prefix for file name that upload to server
function uniqueUploadFile() {
    return time()."-".rand(1000, 9999)."-";
}