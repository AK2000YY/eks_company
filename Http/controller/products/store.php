<?php

use Http\Form\ProductForm;

$data = json_decode(file_get_contents('php://input'), true);

$form = ProductForm::validate($attributes = [
    "name" => $data['name'],
    "code" => $data['code'],
    "unit" => $data['unit'],
    "quantity" => $data['quantity'] ?? 0,
    "price" => $data['price'] ?? 0
]);

$productAdd = $form->addProduct($attributes);

if (! $productAdd)
    $form->error('code or name', 'code or name is used')
        ->throw();

accept();
