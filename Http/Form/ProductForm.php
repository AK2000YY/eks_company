<?php

namespace Http\Form;

use core\App;
use core\Database;
use core\ValidationException;
use core\Validator;

class ProductForm
{
    protected $errors = [];
    protected $attributes = [];

    public function __construct($attributes)
    {
        $this->attributes = $attributes;

        if (! Validator::string($this->attributes['name'], 2, 255))
            $this->errors['name'] = 'put a valid name !';

        if (! Validator::string($this->attributes['code'], 1, 255))
            $this->errors['code'] = 'put a valid code !';

        if (! Validator::number($this->attributes['quantity']))
            $this->errors['quantity'] = 'put a valid number !';

        if (! Validator::number($this->attributes['price']))
            $this->errors['price'] = 'put a valid price !';
    }

    public function updateProduct($attributes)
    {
        $db = App::resolve(Database::class);
        $db->query('select * from products where id=:id',[
            ':id' => $attributes['id']
            ])->findOrFail(['product'=>"this product don't found"]);
        $unitId = (new UnitForm)->addUnit(['type'=>$attributes['unit']]);
        $db->query('update products set name=:name,code=:code,quantity=:quantity,price=:price,unit_id=:unit_id,user_id=:user_id where id=:id',[
            ':id' => $attributes['id'],
            ':name'=>$attributes['name'],
            ':code'=>$attributes['code'],
            ':quantity'=>$attributes['quantity'],
            ':price'=>$attributes['price'],
            ':unit_id'=>$unitId,
            ':user_id'=>$attributes['user_id']
        ]);
        return true;
    }

    public function addProduct($attributes)
    {
        $db = App::resolve(Database::class);
        $product = $db->query('select * from products where name=:name or code=:code', [
            ':name' => $attributes['name'],
            ':code' => $attributes['code']
        ])->find();
        if (! $product) {
            $unitId = (new UnitForm)->addUnit(['type' => $attributes['unit']]);
            $db->query('insert into products(name,code,quantity,price,unit_id,user_id)
            values(:name,:code,:quantity,:price,:unit_id,:user_id)', [
                ':name' => $attributes['name'],
                ':code' => $attributes['code'],
                ':quantity' => $attributes['quantity'],
                ':price' => $attributes['price'],
                ':unit_id' => $unitId,
                ':user_id' => 1
            ]);
            return true;
        }
        return false;
    }

    public static function validate($attributes)
    {
        $instance = new static($attributes);
        return $instance->failed()?$instance->throw():$instance;
    }

    public function failed()
    {
        return count($this->errors);
    }

    public function throw(){
        ValidationException::throw($this->errors, []);
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
