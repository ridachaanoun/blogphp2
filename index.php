<?php
include("db.php");
include("authentication/isAuthenticated.php");
$secret_key = "your_secret_key";  // Same secret key used for encoding the token

$user_data = isAuthenticated();

if (!$user_data) {
    // Redirect to login page if the token is not valid or expired
    header("Location: authentication/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#120309] text-[#95B2B8] min-h-screen flex items-center justify-center">
    <div class="bg-[#2E0F15] rounded-lg p-8 shadow-lg w-full max-w-md">
        <h1 class="text-3xl font-semibold text-center mb-6 text-[#95B2B8]">Welcome, <?php echo htmlspecialchars($user_data ["email"] ); ?>!</h1>

        <div class="text-center mb-6">
            <p class="text-[#95B2B8]">You are successfully logged in. Here are your account details:</p>
            <p class="text-[#95B2B8]">Email: <?php echo htmlspecialchars($user_data ["email"] ); ?></p>
        </div>

        <form action="authentication/logout.php" method="POST">
            <button type="submit" class="w-full p-3 bg-[#307351] hover:bg-[#2E0F15] text-white font-semibold rounded-md transition duration-300">
                Logout
            </button>
        </form>
    </div>
</body>
</html>
