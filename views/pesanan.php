<?php
session_start();
require_once __DIR__ . '/../classes/Pesanan.php';
require_once __DIR__ . '/../classes/Pelanggan.php';
require_once __DIR__ . '/../classes/Menu.php';

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$pesanan = new Pesanan();
$pelanggan = new Pelanggan();
$menu = new Menu();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        $menuItem = $menu->getById($_POST['menu_id']);
        $hargaMenu = $menuItem['harga'];
        $total = $hargaMenu * $_POST['jumlah'];
        $pesanan->create($_POST['pelanggan_id'], $_POST['menu_id'], $_POST['jumlah'], $total, $menuItem['photo']);
    } elseif (isset($_POST['delete'])) {
        $pesanan->delete($_POST['id']);
    }
}

$dataPesanan = $pesanan->getAll();
$dataPelanggan = $pelanggan->getAll();
$dataMenu = $menu->getAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pesanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
<header>
    <?php require('navbar.php'); ?>
</header>
<div class="container mx-auto bg-white p-6 rounded-lg shadow-lg">
    <h1 class="text-3xl font-bold mb-4">Manajemen Pesanan</h1>
    <form method="POST" class="mb-4 flex gap-4">
        <select name="pelanggan_id" class="border px-3 py-2" required>
            <option value="">Pilih Pelanggan</option>
            <?php foreach ($dataPelanggan as $p) : ?>
                <option value="<?= $p['id'] ?>"><?= $p['nama'] ?></option>
            <?php endforeach; ?>
        </select>
        <select name="menu_id" class="border px-3 py-2" required>
            <option value="">Pilih Menu</option>
            <?php foreach ($dataMenu as $m) : ?>
                <option value="<?= $m['id'] ?>" data-photo="../uploads/<?= $m['photo'] ?>">
                    <?= $m['nama'] ?> (Rp<?= $m['harga'] ?>)
                </option>
            <?php endforeach; ?>
        </select>
        <input type="number" name="jumlah" placeholder="Jumlah" class="border px-3 py-2" required>
        <button type="submit" name="add" class="bg-green-500 text-white px-4 py-2">Tambah</button>
    </form>
    <div class="mb-4">
        <input type="text" id="filterInput" placeholder="Cari pesanan..." class="border px-3 py-2 w-full">
    </div>
    <table class="w-full border-collapse border text-left" id="pesananTable">
        <thead>
            <tr class="bg-gray-200">
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Pelanggan</th>
                <th class="border px-4 py-2">Menu</th>
                <th class="border px-4 py-2">Gambar</th>
                <th class="border px-4 py-2">Jumlah</th>
                <th class="border px-4 py-2">Total</th>
                <th class="border px-4 py-2">Tanggal</th>
                <th class="border px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;?>
            <?php foreach ($dataPesanan as $item) : ?>
                <tr>
                    <td class="border px-4 py-2"><?= $no++ ?></td>
                    <td class="border px-4 py-2"><?= $item['pelanggan'] ?></td>
                    <td class="border px-4 py-2"><?= $item['menu'] ?></td>
                    <td class="border px-4 py-2">
    <img src="../uploads/<?= $item['photo_menu'] ?>" alt="<?= $item['menu'] ?>" class="w-16 h-16 object-cover">
</td>

                    <td class="border px-4 py-2"><?= $item['jumlah'] ?></td>
                    <td class="border px-4 py-2">Rp<?= $item['total'] ?></td>
                    <td class="border px-4 py-2"><?= $item['tanggal'] ?></td>
                    <td class="border px-4 py-2">
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $item['id'] ?>">
                            <button type="submit" name="delete" class="bg-red-500 text-white px-4 py-2">Hapus</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="dashboard.php" class="mt-4 inline-block bg-gray-500 text-white px-4 py-2">Kembali ke Dashboard</a>
</div>
<script>
    document.getElementById('filterInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#pesananTable tbody tr');
        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
</script>
</body>
</html>
