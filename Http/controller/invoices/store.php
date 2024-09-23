<?php

use Http\Form\InvoiceForm;

$data = json_decode(file_get_contents('php://input'), true);

$form = InvoiceForm::validate($attributes = [
    "number" => $data['number'],
    "date" => $data['date'],
    "invoice_type" => $data['invoice_type'],
    "name" => $data['name'],
    "total_price" => $data['total_price'],
    "items" => $data['items']
]);

if (! $form->add())
    $form->error('code or name', 'code or name is used')
        ->throw();

accept();
