<?php

use Http\Form\UnitForm;

$data = json_decode(file_get_contents('php://input'), true);

(new UnitForm(['id' => $data['id']]))->delete();

accept();