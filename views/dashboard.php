<?php
session_start();
if(!isset($_SESSION['user'])) {
    header("Location:login.php");
    exit();
}?>
<?php
require_once __DIR__ . '/../classes/Pesanan.php';

$pesanan = new Pesanan();
$ringkasan = $pesanan->getRingkasanPenjualan();
?>

<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard - Manajemen Restoran</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link
            href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css"
            rel="stylesheet"/>
        <style>
            * {
                padding: 0;
                margin: 0;
                box-sizing: border-box;
            }
        </style>
    </head>
    <body>

        <header>
            <?php
            require('navbar.php');
            ?>
        </header>

        <main class="mx-auto p-4 max-w-screen-xl">
            <h1 class="text-3xl font-semibold mb-2 text-center">Selamat Datang,
                <?php echo $_SESSION['user']['username']; ?>!</h1>
            <?php
            if($_SESSION['role'] == 'admin') {
            ?>
            <p class="text-gray-500 dark:text-gray-400 text-center mb-5 text-base">
                Terima kasih telah menjadi bagian penting dari sistem ini. Di sini, Anda dapat dengan mudah mengelola data, 
                memantau aktivitas terbaru, dan memastikan semuanya berjalan lancar. Gunakan berbagai fitur yang tersedia 
                untuk meningkatkan efisiensi dan membuat keputusan terbaik.
                Terus semangat, Admin! Peran Anda sangat berarti
            </p>
            <?php
            }
            ?>

            <?php
            if($_SESSION['role'] == 'kasir') {
            ?>
            <p class="text-gray-500 dark:text-gray-400 text-center mb-5 text-base">
                Halo, Kasir Hebat!
                Selamat datang di halaman kasir tempatmu menjalankan peran penting dengan senyum terbaikmu 😊
                Setiap pelanggan yang kamu layani membawa cerita, dan senyummu bisa jadi cahaya di hari mereka. Walau hatimu mungkin sedang lelah atau sedih, ingatlah bahwa kamu luar biasa karena tetap berdiri, tetap melayani, dan tetap tersenyum.
                Terus semangat, ya! Kamu tidak sendiri, dan kerja kerasmu sangat berarti 💛
            </p>
            <?php
            }
            ?>
            <div
                class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm  dark:bg-gray-800 dark:border-gray-700 ">

                <h5
                    class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Ringkasan Penjualan</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">Total Pesanan:
                    <strong><?= $ringkasan['total_pesanan'] ?></strong>
                </p>
                <p class="font-normal text-gray-700 dark:text-gray-400">Total Pendapatan:
                    <strong>Rp<?= number_format($ringkasan['total_pendapatan'] ?? 0, 2, ',', '.') ?></strong>
                </p>
                <?php
                if($_SESSION['role'] == 'admin') {
                ?>
                <a href="laporan_penjualan.php">
                    <button
                        type="button"
                        class="mt-5 text-white hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-blue-500  dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Lihat Detail Penjualan</button>
                </a>
                <?php
                }
                ?>
            </div>

            <?php
            if($_SESSION['role'] == 'admin') {
            ?>
                <div class="test">
                    <p>message</p>
                </div>
            <?php
            }
            ?>
        </main>
    </body>
</html>