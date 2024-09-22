<?php

use Http\Form\DealerForm;

$data = json_decode(file_get_contents('php://input'), true);

(new DealerForm(['id' => $data['id']]))->delete();

accept();