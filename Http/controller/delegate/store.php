<?php

use core\Authentication;
use Http\Form\DelegateForm;

$data = json_decode(file_get_contents('php://input'), true);


$form = DelegateForm::validate($attributes = [
    'username' => $data['username'],
    'account_type' => 'delegate',
    'password' => $data['password'],
]);

$signedIn = (new Authentication())->registerDelegate(
    $attributes['username'],
    $attributes['account_type'],
    $attributes['password'],
);

if (! $signedIn) {
    $form->error(
        'username',
        'username are used'
    )->throw();
}


accept();
