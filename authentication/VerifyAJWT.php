<?php
function base64UrlDecode($data) {
    return base64_decode(strtr($data, '-_', '+/'));
}

function verifyJwt($jwt, $secret): mixed {
    
    list($headerEncoded, $payloadEncoded, $signatureEncoded) = explode('.', $jwt);

    // Recreate the signature using header and payload
    $signature = base64UrlDecode($signatureEncoded);
    $validSignature = hash_hmac('sha256', "$headerEncoded.$payloadEncoded", $secret, true);

    // Verify the signature matches
    if (!hash_equals($signature, $validSignature)) {
        return false;
    }

    // Decode payload and check expiration
    $payload = json_decode(base64UrlDecode($payloadEncoded), true);
    if (isset($payload['exp']) && $payload['exp'] < time()) {
        return false; // Token is expired
    }

    return $payload; // Return decoded 
}


