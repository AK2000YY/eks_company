<?php

use core\Delete;

$data = json_decode(file_get_contents('php://input'), true);

(new Delete)->deleteUser([
    'id' => $data['id']
]);

accept();