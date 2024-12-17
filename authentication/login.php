<?php
// Include the Composer autoloader
require_once '../vendor/autoload.php';  // Adjust the path if needed

use Firebase\JWT\JWT;
include("../db.php");

$error_message = ''; // Initialize error message variable

$secret_key = "ridachaanoun";  // Same secret key used for encoding the token

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE Email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['pass_word'])) {
            // Generate a JWT token
            $payload = [
                "iss" => "http://localhost:8000",
                "iat" => time(),
                "exp" => time() + 3600, // Token expires in 1 hour
                "email" => $user['Email']
            ];

            $token = JWT::encode($payload, $secret_key, 'HS256');
            // Set token in a secure cookie

            setcookie("auth_token", $token, time() + 3600, "/", "", false, true); // HTTP-only cookie
            // echo "Login successful! Token set in cookie.";
            header("Location: ../index.php");
        }
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { // Duplicate email/username
            $error_message = "Email already exists.";
        } else {
            die("Error: " . $e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#120309] text-[#95B2B8] min-h-screen flex items-center justify-center">
    <div class="bg-[#2E0F15] rounded-lg p-8 shadow-lg w-full max-w-md">
        <h1 class="text-3xl font-semibold text-center mb-6 text-[#95B2B8]">Login</h1>
        <form method="POST" action="login.php" class="space-y-4">
            <?php if ($error_message): ?>
                <div class="text-red-500 text-sm mb-2"><?php echo htmlspecialchars($error_message); ?></div>
            <?php endif; ?>
            <input type="email" name="email" placeholder="Email" required
                class="w-full p-3 rounded-md bg-[#70163C] text-[#95B2B8] placeholder-[#95B2B8] focus:outline-none focus:ring-2 focus:ring-[#307351]">
            <input type="password" name="password" placeholder="Password" required
                class="w-full p-3 rounded-md bg-[#70163C] text-[#95B2B8] placeholder-[#95B2B8] focus:outline-none focus:ring-2 focus:ring-[#307351]">
            <button type="submit" name="login"
                class="w-full p-3 bg-[#307351] hover:bg-[#2E0F15] text-white font-semibold rounded-md transition duration-300">
                Login
            </button>
        </form>
        <p class="text-center mt-4">Don't have an account? <a href="register.php" class="text-[#307351] hover:underline">Register here</a></p>
    </div>
</body>
</html>
