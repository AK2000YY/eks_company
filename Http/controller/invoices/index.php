<?php

use core\App;
use core\Database;

$db = App::resolve(Database::class);

$invoices = $db->query('select * from invoices')->get();

accept($invoices);
