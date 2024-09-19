<?php

namespace Http\Form;

use core\App;
use core\Database;
use core\ValidationException;
use core\Validator;

class UnitForm
{

    protected $errors = [];
    protected $attributes = [];

    public function __construct($attributes)
    {
        $this->attributes = $attributes;
        if (! Validator::string($this->attributes['unit']))
            $this->errors['unit'] = 'put a valid unit !';
    }

    public static function validate($attributes)
    {
        $instance = new UnitForm($attributes);
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

    public function show()
    {
        $db = App::resolve(Database::class);
        $units = $db->query("select id,type as unit from units")->get();
        return $units;
    }

    public function addUnit($attributes)
    {
        $db = App::resolve(Database::class);
        $unit = $db->query("select id from units where type=:type", [
            ':type' => $attributes['type']
        ])->find();
        if (! $unit) {
            $db->query('insert into units(type) values(:type)', [
                ':type' => $attributes['type']
            ]);
            $unit = $db->query("select id from units where type=:type", [
                ':type' => $attributes['type']
            ])->find();
        }
        return $unit['id'];
    }

    public function updateUnit() {}

    public function deleteUnit() {}

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
