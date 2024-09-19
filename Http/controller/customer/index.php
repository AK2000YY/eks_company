<?php

use core\App;
use core\Database;

$data = json_decode(file_get_contents('php://input'), true);

$db = App::resolve(Database::class);

$users = $db->query(
    "select * from users where account_type = 'customer'"
)->get();

accept($users);