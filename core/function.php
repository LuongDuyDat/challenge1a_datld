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
