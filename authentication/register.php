<?php

include '../db.php';
$error_message='';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, Email, pass_word) VALUES (:username, :email, :password)");
        $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':password' => $password
        ]);
        header('location: login.php');
        echo "good";

    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
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
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#120309] text-[#95B2B8] min-h-screen flex items-center justify-center">
    <div class="bg-[#2E0F15] rounded-lg p-8 shadow-lg w-full max-w-md">
        <h1 class="text-3xl font-semibold text-center mb-6 text-[#95B2B8]">Register</h1>

        <?php if ($error_message): ?>
            <div class="text-red-500 text-sm mb-4 text-center"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <form method="POST" action="register.php" class="space-y-4">
            <input type="text" name="username" placeholder="Username" required
                class="w-full p-3 rounded-md bg-[#70163C] text-[#95B2B8] placeholder-[#95B2B8] focus:outline-none focus:ring-2 focus:ring-[#307351]">
            <input type="email" name="email" placeholder="Email" required
                class="w-full p-3 rounded-md bg-[#70163C] text-[#95B2B8] placeholder-[#95B2B8] focus:outline-none focus:ring-2 focus:ring-[#307351]">
            <input type="password" name="password" placeholder="Password" required
                class="w-full p-3 rounded-md bg-[#70163C] text-[#95B2B8] placeholder-[#95B2B8] focus:outline-none focus:ring-2 focus:ring-[#307351]">
            <input type="password" name="confirm_password" placeholder="Confirm Password" required
                class="w-full p-3 rounded-md bg-[#70163C] text-[#95B2B8] placeholder-[#95B2B8] focus:outline-none focus:ring-2 focus:ring-[#307351]">
            <button type="submit" name="register"
                class="w-full p-3 bg-[#307351] hover:bg-[#2E0F15] text-white font-semibold rounded-md transition duration-300">
                Register
            </button>
        </form>

        <p class="text-center mt-4">Already have an account? <a href="login.php" class="text-[#307351] hover:underline">Login here</a></p>
    </div>
</body>
</html>
