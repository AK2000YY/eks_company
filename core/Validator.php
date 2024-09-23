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

    public static function invoiceType($value)
    {
        $types = ['sell', 'buy'];
        return in_array($value, $types);
    }

    public static function number($value)
    {
        return is_numeric($value);
    }

    public static function invoiceItems($items)
    {
        if (! is_array($items)) return false;
        foreach ($items as $item) {
            if (
                isset($item['name'], $item['quantity'], $item['price']) &&
                static::string($item['name']) &&
                static::number($item['quantity']) &&
                static::number($item['price'])

            )
                continue;
            else
                return false;
        }
        return true;
    }
}
