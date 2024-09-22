<?php

use Http\Form\UnitForm;

$data = json_decode(file_get_contents('php://input'), true);

$form = UnitForm::validate($attributes = [
    'id' => $data['id'],
    'type' => $data['type'],
]);

if(! $form->update()) {
    $form->error(
        'type',
        'this type is used'
    )->throw();
}

accept();

