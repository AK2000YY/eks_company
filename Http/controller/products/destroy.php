<?php

use Http\Form\ProductForm;

$data = json_decode(file_get_contents('php://input'), true);

(new ProductForm(['id'=>$data['id']]))->delete();

accept();