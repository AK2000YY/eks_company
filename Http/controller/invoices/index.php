<?php

use core\App;
use core\Database;

$db = App::resolve(Database::class);

$invoices = $db->query('select * from invoices')->get();

for ($i = 0; $i< count($invoices); $i++) {
    $items = $db->query('select * from invoice_products where invoice_id=:invoice_id', [
        ':invoice_id' => $invoices[$i]['id']
    ])->get();
    $invoices[$i]['items'] = $items;
}

accept($invoices);
