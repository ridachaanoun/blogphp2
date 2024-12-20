<?php
include'VerifyAJWT.php';
function isAuthenticated() {
    $secret_key= "ridachaanoun";

    if (isset($_COOKIE['auth_token'])) {
        $jwtToken = $_COOKIE['auth_token'];
        
        try {
            // Decode the token 
            $decoded = verifyJwt($jwtToken, $secret_key);
            return $decoded;
        } catch (Exception $e) {
            // If decoding fails or token is invalid/expired
            return null;
        }
    }
    return null;
}