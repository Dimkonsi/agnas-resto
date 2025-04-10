<?php 

if(isset($_SESSION)){
    if ($_SESSION['role']) {
        header("Location: /views/dashboard.php");
    } else {
        // Peran tidak dikenal, arahkan ke halaman default atau tampilkan pesan error
        echo "void";
    }
} else {
    header('Location: /views/login.php');
};