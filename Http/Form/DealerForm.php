<?php

namespace Http\Form;

use core\ValidationException;
use core\Validator;

class DealerForm
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

        if (! Validator::string($this->attributes['address'], 2, 255))
            $this->errors['address'] = 'get a valid address!';

        if (! Validator::string($this->attributes['phone'], 3, 255))
            $this->errors['phone'] = 'get a valid phone!';

        if (! Validator::string($this->attributes['administrator_name'], 2, 255))
            $this->errors['phone'] = 'get a valid administrator name!';

        if (! Validator::string($attributes['administrator_phone'], 3, 255))
            $this->errors['phone'] = 'get a valid administrator phone!';
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
