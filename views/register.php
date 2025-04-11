<?php
session_start();
require_once '../config/Database.php';

$database = new Database();
$conn = $database->getConnetion();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $check = "SELECT * FROM users WHERE username = :username";
    $stmt = $conn->prepare($check);
    $stmt->execute(['username'=> $username]);

    if($stmt->rowCount()>0){
        echo "Account already axist";
    }else {
        $insert = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $stmt = $conn->prepare($insert);
        $result = $stmt->execute([
            'username' => $username,
            'password' => $password
        ]);

        if ($result) {
            header("Location: login.php");
            exit();
        } else {
            echo "<p style='color:red;'>Registrasi gagal. Silakan coba lagi.</p>";
        }
    }
    $database->closeConnection();
}
?>

<!-- Registration Form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register - manajemen resto</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="bg-white p-6 rounded shadow-md w-96">
        <h2 class="text-center text-2xl font-bold mb-4">Registration</h2>
        <?php if (isset($error)) echo "<p class='text-red-500'>$error</p>"; ?>
        <form method="POST">
            <div class="mb-4">
                <label class="block text-gray-700">Username</label>
                <input type="text" name="username" class="w-full px-3 py-2 border rounded" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Password</label>
                <input type="password" name="password" class="w-full px-3 py-2 border rounded" required>
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded">Register</button>
        </form>
    </div>
</body>
</html>