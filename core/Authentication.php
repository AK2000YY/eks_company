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

        if ($user) {
        }
    }
}
