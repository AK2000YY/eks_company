<?php

namespace core\middleware;

class Middleware {
    const MAP = [
        'admin' => Admin::class,
        'delegate' => Delegate::class
    ];

    public static function resolve($key) {
        if(! $key) return;
        $middleware = static::MAP[$key] ?? false;
        if(!$middleware)
            throw new \Exception("no middleware for this {$key}");
        return (new $middleware)->handle();
    }
}