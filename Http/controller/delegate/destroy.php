<?php

use Http\Form\DelegateForm;

$data = json_decode(file_get_contents('php://input'), true);

(new DelegateForm(['id' => $data['id']]))->delete();

accept();