<?php

use Http\Form\CustomerForm;

$data = json_decode(file_get_contents('php://input'), true);

$form = CustomerForm::validate($attributes = [
    'id' => $data['id'],
    'username' => $data['username'],
    'account_type' => 'delegate',
    //'password' => password_hash(),
]);

if(! $form->update()) {
    $form->error(
        'username',
        'username are used'
    )->throw();
}

accept();

