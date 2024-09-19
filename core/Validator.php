<?php

namespace core;

class Validator
{
    public static function string($value, $min = 1, $max = 1000)
    {
        $value = strlen(trim($value));
        return $value >= $min && $value <= $max;
    }

    public static function type($value)
    {
        $types = ['dealer', 'delegate', 'customer'];
        return in_array($value, $types);
    }

    public static function number($value)
    {
        return is_numeric($value);
    }
}
