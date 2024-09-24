<?php

use core\App;
use core\Database;

$data = json_decode(file_get_contents('php://input'), true);

$db = App::resolve(Database::class);

$items = $db->query('select name,quantity,price from invoice_products where invoice_id=:invoice_id', [
    ':invoice_id' => $data['id']
])->get();

accept($items);
