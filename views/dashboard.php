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
            <p class="text-gray-500 dark:text-gray-400 text-center mb-5 text-base">Welcome
                to the dashboard! Here, you can easily access and manage important data in one
                intuitive view. Monitor the latest statistics, quickly handle information, and
                make smarter decisions based on real-time data. Use the available features to
                enhance efficiency and productivity. Happy working!</p>

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
                <a href="laporan_penjualan.php">
                    <button
                        type="button"
                        class="mt-5 text-white hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-blue-500  dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">Lihat Detail Penjualan</button>
                </a>
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