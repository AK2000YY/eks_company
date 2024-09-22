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

    public function __construct($attributes = [])
    {
        $this->attributes = $attributes;
        if (isset($this->attributes['type']) && ! Validator::string($this->attributes['type']))
            $this->errors['unit'] = 'put a valid unit !';
    }

    public function add()
    {
        $db = App::resolve(Database::class);
        $user = $db->query('select * from units where type = :type', [
            ':type' => $this->attributes['type']
        ])->find();

        if (! $user) {
            $db->query('insert into 
                units (type) 
                values(:type)', [
                ':type' => $this->attributes['type']
            ]);

            return true;
        }
        return false;
    }

    public function update()
    {
        $db = App::resolve(Database::class);
        $unit = $db->query('select * from units where id=:id', [
            ':id' => $this->attributes['id']
        ])->findOrFail(['unit' => "don't found this unit"]);
        $can = $db->query("select * from units where id!=:id and type=:type", [
            ':id' => $this->attributes['id'],
            ':type' => $this->attributes['type'],
        ])->find();
        if ($unit && ! $can) {
            $db->query('update units set type=:type where id=:id', [
                ':id' => $this->attributes['id'],
                ':type' => $this->attributes['type']
            ]);
            return true;
        }
        return false;
    }
    public function delete()
    {
        $db = App::resolve(Database::class);
        $db->query('select * from units where id=:id', [
            ':id' => $this->attributes['id']
        ])->findOrFail(['unit' => "don't find this unit"]);
        $db->query('delete from units where id=:id', [
            ':id' => $this->attributes['id']
        ]);
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

    public function getIdUnit()
    {
        $db = App::resolve(Database::class);
        $unit = $db->query("select id from units where type=:type", [
            ':type' => $this->attributes['type']
        ])->find();
        if (! $unit) {
            $db->query('insert into units(type) values(:type)', [
                ':type' => $this->attributes['type']
            ]);
            $unit = $db->query("select id from units where type=:type", [
                ':type' => $this->attributes['type']
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
