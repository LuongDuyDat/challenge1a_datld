<?php

require base_path('core/response.php');

function authorize($condition, $status = Response::FORBIDDEN)
{
    if (!$condition) {
        die($status);
    }
}

function dd($value)
{
    echo '<pre>' , var_dump($value) , '</pre>';

    die();
}

function base_path($path)
{
    return BASE_PATH . $path;
}

function abort($code = 404)
{
    http_response_code($code);

    $heading = '';

    require base_path("view/response/$code.php");

    die();
}

function formatBytes($size, $precision = 2)
{
    $base = log($size, 1024);
    $suffixes = array('', 'KB', 'MB', 'GB', 'TB');   

    return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
}