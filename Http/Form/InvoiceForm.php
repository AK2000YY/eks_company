<?php

namespace Http\Form;

use core\App;
use core\Database;
use core\ValidationException;
use core\Validator;
use Exception;

class InvoiceForm
{
    protected $attributes = [];
    protected $errors = [];

    public function __construct($attributes)
    {
        $this->attributes = $attributes;
        if (isset($this->attributes['number']) && ! Validator::number($this->attributes['number']))
            $this->errors['number'] = "the number can't be empty !";

        if (isset($this->attributes['date']) && ! Validator::string($this->attributes['date'], 1, 10))
            $this->errors['date'] = "date isn't correct";

        if (isset($this->attributes['invoice_type']) && ! Validator::invoiceType($this->attributes['invoice_type']))
            $this->errors['type'] = "type isn't correct !";

        if (isset($this->attributes['name']) && ! Validator::string($this->attributes['name']))
            $this->errors['name'] = "get a valid name !";

        if (isset($this->attributes['total_price']) && ! Validator::string($this->attributes['total_price']))
            $this->errors['total_price'] = "get a valid total_price !";

        if (isset($this->attributes['items']) && ! Validator::invoiceItems($this->attributes['items']))
            $this->errors['items'] = "get a valid items !";
    }

    public static function validate($attributes)
    {
        $instance = new InvoiceForm($attributes);
        return $instance->failed() ? $instance->throw() : $instance;
    }

    public function add()
    {
        $db = App::resolve(Database::class);
        try {

            $db->connection->exec("LOCK TABLES products WRITE, invoices WRITE");

            $db->connection->beginTransaction();

            $invoice = $db->query("select * from invoices where number=:number", [
                ':number' => $this->attributes['number']
            ])->find();

            if ($invoice) throw new Exception('this invoice is entered !');

            $invoice = $db->query("INSERT INTO 
            invoices(number,date,invoice_type,name,total_price) 
            VALUES (:number,:date,:invoice_type,:name,:total_price)", [
                ':number' => $this->attributes['number'],
                ':date' => $this->attributes['date'],
                ':invoice_type' => $this->attributes['invoice_type'],
                ':name' => $this->attributes['name'],
                ':total_price' => $this->attributes['total_price'],
            ])
                ->lastIndex();

            foreach ($this->attributes['items'] as $item) {
                $product = $db->query('select * from products where name=:name', [
                    ':name' => $item['name']
                ])->find();

                if (! $product)
                    throw new Exception("one of product isn't found !");

                if ($product['quantity'] < $item['quantity'] && $this->attributes['invoice_type'] === 'sell')
                    throw new Exception("one of product quantity isn't enough !");

                if ($this->attributes['invoice_type'] === 'sell')
                    $newQuantity = $product['quantity'] - $item['quantity'];
                else
                    $newQuantity = $product['quantity'] + $item['quantity'];

                $db->query("UPDATE products SET quantity=:quantity where name=:name", [
                    ':quantity' => $newQuantity,
                    ':name' => $product['name']
                ]);

                $db->query("INSERT INTO invoice_products(name,quantity,price,invoice_id) 
                VALUES (:name,:quantity,:price,:invoice_id)", [
                    'name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'invoice_id' => $invoice
                ]);
            }

            $db->connection->exec("UNLOCK TABLES");
            $db->connection->commit();
        } catch (Exception $e) {
            $db->connection->exec("UNLOCK TABLES");
            $db->connection->rollBack();
            wrong($e->getMessage());
        }

        return true;
    }

    public function delete()
    {
        $db = App::resolve(Database::class);
        try {
            $db->connection->exec("LOCK TABLES products WRITE, invoices WRITE");

            $db->connection->beginTransaction();

            $invoice = $db->query("select * from invoices where id=:id", [
                ':id' => $this->attributes['id']
            ])->find();

            if (! $invoice) throw new Exception("this invoice isn't found !");
            $items = $db->query("select * from invoice_products where invoice_id=:invoice_id", [
                ':invoice_id' => $this->attributes['id']
            ])->get();

            foreach ($items as $item) {
                $product = $db->query('select * from products where name=:name', [
                    ':name' => $item['name']
                ])->find();

                if (! $product) continue;

                $newQuantity = $product['quantity'] + $item['quantity'];

                $db->query("UPDATE products SET quantity=:quantity where name=:name", [
                    ':quantity' => $newQuantity,
                    ':name' => $product['name']
                ]);
            }

            $db->connection->exec("UNLOCK TABLES");
            $db->connection->commit();
        } catch (Exception $e) {
            $db->connection->exec("UNLOCK TABLES");
            $db->connection->rollBack();
            wrong($e->getMessage());
        }
    }

    public function failed()
    {
        return count($this->errors);
    }

    public function throw()
    {
        ValidationException::throw($this->errors, []);
    }

    public function errors()
    {
        return $this->errors;
    }

    public function error($key, $value)
    {
        $this->errors[$key] = $value;
        return $this;
    }
}
