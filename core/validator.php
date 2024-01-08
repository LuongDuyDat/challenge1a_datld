<?php

class Validator
{
    static function required($value, $item)
    {
        if (strlen($value) == 0) {
            return "Không chấp nhận $item rỗng";
        }
        return "";
    }

    static function min($value, $item, $min)
    {
        if (strlen($value) < $min) {
            return "Yêu cầu $item có ít nhất $min ký tự";
        }
        return "";
    }

    static function max($value, $item, $max)
    {
        if (strlen($value) > $max) {
            return "Yêu cầu $item có nhiều nhất $max ký tự";
        }
        return "";
    }

    static function string($value, $item, $min, $max) {
        $result = self::required($value, $item);
        if (strlen($result) != 0) {
            return $result;
        }
        $result = self::min($value, $item, $min);
        if (strlen($result) != 0) {
            return $result;
        }
        $result = self::max($value, $item, $max);

        return $result;
    }
}

?>