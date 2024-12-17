<?php
require_once 'vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Function to check if the JWT token is valid
function isAuthenticated() {
    $secret_key= "ridachaanoun";

    if (isset($_COOKIE['auth_token'])) {
        $token = $_COOKIE['auth_token'];
        
        try {
            // Decode the token 
            $decoded = JWT::decode($token, new Key($secret_key, 'HS256'));
            return $decoded;
        } catch (Exception $e) {
            // If decoding fails or token is invalid/expired
            return null;
        }
    }
    return null;
}