<?php

use core\Delete;

$data = json_decode(file_get_contents('php://input'), true);

(new Delete)->deleteProduct([
    'id'=>$data['id']
]);

accept();