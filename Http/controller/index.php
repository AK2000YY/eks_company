<?php

// dd('hello');

function generateToken($user_id, $username, $user_type, $secret_key) {
    $secret_key;

    $payload = [
        'id' => $user_id,
        'account_type' => $user_type,
        'username' => $username
    ];

    $encoded_payload = base64_encode(json_encode($payload));
    $signature = hash_hmac('sha256', $encoded_payload, $secret_key);
    return $encoded_payload . '.' . $signature;
}


echo generateToken(2, "mohmad" , "delegate" ,'#(HJSF(#*)!BKJS*&$$I(VBO(*#Y@#I)**%NO*(4bqt849h(*Y(hp9898YU*(Y9h(*B8uHb(8hNO9h9H9H(*H08h8');
echo "<br>";