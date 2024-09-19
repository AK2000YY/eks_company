<?php

namespace core;

class Delete {
    public function deleteUser($attributes)
    {
        $db = App::resolve(Database::class);
        $db->query('select * from users where id=:id',[
            ':id'=>$attributes['id']
        ])->findOrFail(['user' => "don't find this user"]);
        $db->query('delete from users where id=:id',[
            ':id'=>$attributes['id']
        ]);
    }

    public function deleteProduct($attributes)
    {
        $db = App::resolve(Database::class);
        $db->query('select * from products where id=:id',[
            ':id'=>$attributes['id']
        ])->findOrFail(['product' => "don't find this product"]);
        $db->query('delete from products where id=:id',[
            ':id'=>$attributes['id']
        ]);
    }
}