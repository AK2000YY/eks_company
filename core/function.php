<?php

use core\Response;

function dd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    die();
}

function authorize($condition, $status = Response::FORBIDDEN)
{
    if (! $condition)
        echo "not authorize";
}

function base_path($value)
{
    return BASE_PATH . $value;
}

function wrong($value)
{
    $result = [
        'state' => 'not success',
        'errors' => $value
    ];

    print_r(json_encode($result));
    die();
}

function accept($value = [])
{
    $result = [
        'state' => 'success',
        'data' => $value
    ];
    print_r(json_encode($result));
    die();
}

function verifyToken($token, $secret_key)
{
    $secret_key;

    list($encoded_payload, $provided_signature) = explode('.', $token);
    $calculated_signature = hash_hmac('sha256', $encoded_payload, $secret_key);

    if (hash_equals($calculated_signature, $provided_signature)) {
        $payload = json_decode(base64_decode($encoded_payload), true);
        return $payload;
    } else
        wrong("you can't do that !");
}
