<?php

namespace core;

class Update
{
    public function updateCustomer($attributes)
    {
        $db = App::resolve(Database::class);
        $user = $db->query('select * from users where id = :id',[
            ':id'=>$attributes['id']
        ])->findOrFail(['user'=>"don't found this user"]);
        $can = $db->query("select * from users where id!=:id and username=:username and account_type='customer'", [
            ':id'=>$attributes['id'],
            ':username'=>$attributes['username']
        ])->find();
        if($user && ! $can) {
            $db->query('update users set username=:username,address=:address,phone=:phone,administrator_name=:administrator_name,administrator_phone=:administrator_phone where id = :id',[
                ':id'=>$attributes['id'],
                ':username'=>$attributes['username'],
                ':address'=>$attributes['address'],
                ':phone'=>$attributes['phone'],
                ':administrator_name'=>$attributes['administrator_name'],
                ':administrator_phone'=>$attributes['administrator_phone'],
            ]);
            return true;
        }
        return false;
    }

    public function updateDealer($attributes)
    {
        $db = App::resolve(Database::class);
        $user = $db->query('select * from users where id = :id',[
            ':id'=>$attributes['id']
        ])->findOrFail(['user'=>"don't found this user"]);
        $can = $db->query("select * from users where id!=:id and username=:username and account_type='dealer'", [
            ':id'=>$attributes['id'],
            ':username'=>$attributes['username']
        ])->find();
        if($user && ! $can) {
            $db->query('update users set username=:username,address=:address,phone=:phone,administrator_name=:administrator_name,administrator_phone=:administrator_phone where id = :id',[
                ':id'=>$attributes['id'],
                ':username'=>$attributes['username'],
                ':address'=>$attributes['address'],
                ':phone'=>$attributes['phone'],
                ':administrator_name'=>$attributes['administrator_name'],
                ':administrator_phone'=>$attributes['administrator_phone'],
            ]);
            return true;
        }
        return false;
    }

    public function updateDelegate($attributes)
    {
        $db = App::resolve(Database::class);
        $user = $db->query('select * from users where id = :id',[
            ':id'=>$attributes['id']
        ])->findOrFail(['user'=>"don't found this user"]);
        $can = $db->query("select * from users where id!=:id and username=:username and account_type='delegate'", [
            ':id'=>$attributes['id'],
            ':username'=>$attributes['username']
        ])->find();
        if($user && ! $can) {
            $db->query('update users set username=:username,address=:address,phone=:phone,administrator_name=:administrator_name,administrator_phone=:administrator_phone where id = :id',[
                ':id'=>$attributes['id'],
                ':username'=>$attributes['username'],
                ':address'=>$attributes['address'],
                ':phone'=>$attributes['phone'],
                ':administrator_name'=>$attributes['administrator_name'],
                ':administrator_phone'=>$attributes['administrator_phone'],
            ]);
            return true;
        }
        return false;
    }
}
