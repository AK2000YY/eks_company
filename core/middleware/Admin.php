<?php

namespace core\middleware;

use Exception;

class Admin
{
    protected $secretKey = '#(HJSF(#*)!BKJS*&$$I(VBO(*#Y@#I)**%NO*(4bqt849h(*Y(hp9898YU*(Y9h(*B8uHb(8hNO9h9H9H(*H08h8';

    public function handle()
    {
        try {
            $token = $_SERVER['HTTP_AUTHORIZATION'];
            $decode = verifyToken($token, $this->secretKey);
            if ($decode['account_type'] === 'admin')
                return $decode['id'];
            wrong("you can't do that !");
        } catch (Exception $exception) {
            wrong("you can't do that !");
        }
    }
}
