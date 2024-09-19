<?php

use core\App;
use core\Database;

$db = App::resolve(Database::class);

$products = $db->query("SELECT products.id,name,code,IFNULL(type, '') as unit,quantity,price
FROM products left join units on products.unit_id = units.id")
    ->get();

accept($products);
