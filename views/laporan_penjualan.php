<?php
session_start();
require_once __DIR__ . '/../classes/Pesanan.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$pesanan = new Pesanan();
$tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : null;
$dataLaporan = $pesanan->getLaporanPenjualan($tanggal); ?>

<!DOCTYPE html>
<html lang="id">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Laporan Penjualan</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body>
        <header>
            <?php
            require('navbar.php');
            ?>
        </header>

        <main class="mx-auto p-4 max-w-screen-xl">
            <h1 class="text-3xl font-semibold mb-4">Laporan Penjualan</h1>

            <form method="GET" class="mb-4">
                <input
                    type="date"
                    name="tanggal"
                    value="<?= $tanggal ?>"
                    class="border px-3 py-2 rounded-md"/>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2">
                    Filter
                </button>
                <a href="laporan_penjualan.php" class="bg-gray-500 text-white px-4 py-2">Reset</a >
            </form>

            <table class="w-full border-collapse border">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border px-4 py-2">ID</th>
                        <th class="border px-4 py-2">Pelanggan</th>
                        <th class="border px-4 py-2">Menu</th>
                        <th class="border px-4 py-2">Jumlah</th>
                        <th class="border px-4 py-2">Total</th>
                        <th class="border px-4 py-2">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;?>
                    <?php if (count($dataLaporan) >
          0) : ?>
                    <?php foreach ($dataLaporan as $item) : ?>
                    <tr>
                        <td class="border px-4 py-2"><?= $no++ ?></td>
                        <td class="border px-4 py-2"><?= $item['pelanggan'] ?></td>
                        <td class="border px-4 py-2"><?= $item['menu'] ?></td>
                        <td class="border px-4 py-2"><?= $item['jumlah'] ?></td>
                        <td class="border px-4 py-2">Rp<?= $item['total'] ?></td>
                        <td class="border px-4 py-2"><?= $item['tanggal'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="border px-4 py-2 text-center">
                            Tidak ada data penjualan
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </main>
    </body>
</html>