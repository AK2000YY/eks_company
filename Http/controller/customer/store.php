<?php

use Http\Form\CustomerForm;

$data = json_decode(file_get_contents('php://input'), true);

$form = CustomerForm::validate($attributes = [
    'username' => $data['username'],
    'account_type' => 'customer',
    'address' => $data['address'],
    'phone' => $data['phone'],
    'administrator_name' => $data['administrator_name'],
    'administrator_phone' => $data['administrator_phone']
]);

if (! $form->add()) {
    $form->error(
        'username',
        'username are used'
    )->throw();
}


accept();
