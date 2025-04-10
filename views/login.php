<?php
// session_start();
// require_once '../classes/User.php';

// if($_SERVER["REQUEST_METHOD"] == "POST"){
//     $username = $_POST['username'];
//     $password = $_POST['password'];

//     $user = new User();
//     $logInUser =$user->login($username, $password);

//     if($logInUser){
//         $_SESSION['user'] = $logInUser;
//         header("Location: dasboard.php");
//         exit();
//     }else{
//         $error = "Periksa kembali username dan password!";
//     }
// }
session_start();
require_once '../classes/User.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = new User();
    $logInUser = $user->login($username, $password);

    if ($logInUser) {
        $_SESSION['user'] = $logInUser;
        $_SESSION['role'] = $logInUser['role'];

        // Pengalihan berdasarkan peran
        if ($_SESSION['role'] == 'admin') {
            header("Location: ../admin/dashboard.php");
        } elseif ($_SESSION['role'] == 'kasir') {
            header("Location: ../kasir/dashboard.php");
        } else {
            // Peran tidak dikenal, arahkan ke halaman default atau tampilkan pesan error
            header("Location: ../default/dashboard.php");
        }
        exit();
    } else {
        $error = "Periksa kembali username dan password!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Manajemen Restoran</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
    <div class="bg-white p-6 rounded shadow-md w-96">
        <h2 class="text-center text-2xl font-bold mb-4">Login</h2>
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
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded">Login</button>
        </form>
    </div>
</body>
</html>