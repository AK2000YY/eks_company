<?php

use Http\Form\UnitForm;

$data = json_decode(file_get_contents('php://input'), true);

$form = UnitForm::validate($attributes = [
    'type' => $data['type']
]);

if (! $form->add())
    $form->error(
        'username',
        'username are used'
    )->throw();


accept();
