<?php

use Http\Form\CustomerForm;

$data = json_decode(file_get_contents('php://input'), true);

(new CustomerForm(['id' => $data['id']]))->delete();

accept();