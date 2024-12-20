
<?php
function base64UrlEncode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function createJwt($header, $payload, $secret) {
    // Encode header and payload
    $headerEncoded = base64UrlEncode(json_encode($header));
    $payloadEncoded = base64UrlEncode(json_encode($payload));

    // Create the signature
    $signature = hash_hmac($header['alg'], "$headerEncoded.$payloadEncoded", $secret, true);
    $signatureEncoded = base64UrlEncode($signature);
    
    return "$headerEncoded.$payloadEncoded.$signatureEncoded";

}


