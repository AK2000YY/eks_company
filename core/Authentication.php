<?php

namespace core;

class Authentication
{

    public function attempt($username, $password)
    {
        $db = App::resolve(Database::class);
        $user = $db->query('select * from users where username = :username', [
            ':username' => $username
        ])->find();

        if($user) {
            
        }
    }

    public function registerDelegate($username, $account_type, $password)
    {
        $db = App::resolve(Database::class);
        $user = $db->query('select * from users where username = :username and account_type = :account_type', [
            ':username' => $username,
            ':account_type' => $account_type
        ])->find();

        if(! $user) {
            $db->query('insert into users (username,account_type,password) values( :username , :account_type, :password )', [
                ':username' => $username,
                ':account_type' => $account_type,
                ':password' => password_hash($password, PASSWORD_BCRYPT)
            ]);

            return true;
        }
        return false;
    }

    public function registerCustomer($username, $account_type, $address, $phone, $administratorName, $administratorPhone)
    {
        $db = App::resolve(Database::class);
        $user = $db->query('select * from users where username = :username and account_type = :account_type', [
            ':username' => $username,
            ':account_type' => $account_type
        ])->find();

        if(! $user) {
            $db->query('insert into 
            users (username,account_type,address,phone,administrator_name,administrator_phone) 
            values(:username,:account_type,:address,:phone,:administrator_name,:administrator_phone)', [
                ':username' => $username,
                ':account_type' => $account_type,
                ':address' => $address,
                ':phone' => $phone,
                ':administrator_name' => $administratorName,
                ':administrator_phone' => $administratorPhone
            ]);

            return true;
        }
        return false;
    }

    public function registerDealer($username, $account_type, $address, $phone, $administratorName, $administratorPhone)
    {
        $db = App::resolve(Database::class);
        $user = $db->query('select * from users where username = :username and account_type = :account_type', [
            ':username' => $username,
            ':account_type' => $account_type
        ])->find();

        if(! $user) {
            $db->query('insert into 
            users (username,account_type,address,phone,administrator_name,administrator_phone) 
            values(:username,:account_type,:address,:phone,:administrator_name,:administrator_phone)', [
                ':username' => $username,
                ':account_type' => $account_type,
                ':address' => $address,
                ':phone' => $phone,
                ':administrator_name' => $administratorName,
                ':administrator_phone' => $administratorPhone
            ]);

            return true;
        }
        return false;
    }
    
}
