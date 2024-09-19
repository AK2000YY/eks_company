<?php

namespace Http\Form;

use core\ValidationException;
use core\Validator;

class DelegateForm
{
    protected $errors = [];
    protected $attributes = [];

    public function __construct($attributes)
    {
        $this->attributes = $attributes;
        if (! Validator::string($this->attributes['username'], 2, 255))
            $this->errors['username'] = 'put a valid name !';

        if (! Validator::type($this->attributes['account_type']))
            $this->errors['account_type'] = 'this type not found !';

        if (! Validator::string($this->attributes['password'], 7, 255))
            $this->errors['password'] = 'get a strong password!';
    }

    public static function validate($attributes)
    {
        $instance = new static($attributes);
        return $instance->failed() ? $instance->throw() : $instance;
    }

    public function throw()
    {
        ValidationException::throw($this->errors, $this->attributes);
    }

    public function failed()
    {
        return count($this->errors);
    }

    public function errors()
    {
        return $this->errors;
    }

    public function error($key, $value)
    {
        $this->errors[$key] = $value;
        return $this;
    }
}
