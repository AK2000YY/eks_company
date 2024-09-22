<?php

use Http\Form\DelegateForm;

$data = json_decode(file_get_contents('php://input'), true);


$form = DelegateForm::validate($attributes = [
    'username' => $data['username'],
    'account_type' => 'delegate',
    'password' => $data['password'],
]);

if (! $form->add()) {
    $form->error(
        'username',
        'username are used'
    )->throw();
}


accept();
