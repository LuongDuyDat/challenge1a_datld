<?php

class Validator
{
    static function required($value, $item)
    {
        if (strlen($value) == 0) {
            return "Khong chap nhan $item rong";
        }
        return "";
    }

    static function min($value, $item, $min)
    {
        if (strlen($value) < $min) {
            return "Yeu cau $item co it nhat $min ky tu";
        }
        return "";
    }

    static function max($value, $item, $max)
    {
        if (strlen($value) > $max) {
            return "Yeu cau $item co nhieu nhat $max ky tu";
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