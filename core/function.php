<?php

require 'core/response.php';

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
