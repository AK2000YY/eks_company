<?php

namespace Http\Form;

use core\App;
use core\Database;
use core\ValidationException;
use core\Validator;

class DelegateForm
{
    protected $errors = [];
    protected $attributes = [];

    public function __construct($attributes)
    {
        $this->attributes = $attributes;
        if (isset($this->attributes['username']) && ! Validator::string($this->attributes['username'], 2, 255))
            $this->errors['username'] = 'put a valid name !';

        if (isset($this->attributes['account_type']) && ! Validator::type($this->attributes['account_type']))
            $this->errors['account_type'] = 'this type not found !';

        if (isset($this->attributes['password']) && ! Validator::string($this->attributes['password'], 7, 255))
            $this->errors['password'] = 'get a strong password!';
    }


    public function add()
    {
        $db = App::resolve(Database::class);
        $user = $db->query('select * from users where username = :username and account_type = :account_type', [
            ':username' => $this->attributes['username'],
            ':account_type' => $this->attributes['account_type']
        ])->find();

        if (! $user) {
            $db->query('insert into 
            users (username,account_type,password) 
            values(:username,:account_type,:password)', [
                ':username' => $this->attributes['username'],
                ':account_type' => $this->attributes['account_type'],
                ':password' => $this->attributes['password']
            ]);

            return true;
        }
        return false;
    }

    public function update()
    {
        $db = App::resolve(Database::class);
        $user = $db->query('select * from users where id = :id', [
            ':id' => $this->attributes['id']
        ])->findOrFail(['user' => "don't found this user"]);
        $can = $db->query("select * from users where id!=:id and username=:username and account_type='delegate'", [
            ':id' => $this->attributes['id'],
            ':username' => $this->attributes['username']
        ])->find();
        if ($user && ! $can) {
            $db->query('update users set username=:username,address=:address,phone=:phone,administrator_name=:administrator_name,administrator_phone=:administrator_phone where id = :id', [
                ':id' => $this->attributes['id'],
                ':username' => $this->attributes['username'],
                ':password' => $this->attributes['password']
            ]);
            return true;
        }
        return false;
    }

    public function delete()
    {
        $db = App::resolve(Database::class);
        $db->query('select * from users where id=:id', [
            ':id' => $this->attributes['id']
        ])->findOrFail(['user' => "don't find this user"]);
        $db->query('delete from users where id=:id', [
            ':id' => $this->attributes['id']
        ]);
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
