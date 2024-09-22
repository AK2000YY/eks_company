<?php

use core\App;
use core\Database;

$db = App::resolve(Database::class);

$users = $db->query(
    "select * from users where account_type = 'customer'"
)->get();

accept($users);