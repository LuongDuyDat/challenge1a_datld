<?php

function authorize($condition, $status = Response::$FORBIDDEN)
{
    if (!$condition) {
        die($status);
    }
}