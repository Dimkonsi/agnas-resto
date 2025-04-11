<?php
session_start();
require_once"../classes/Pelanggan.php";

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$pelanggan = new Pelanggan();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        $pelanggan->create($_POST['nama'], $_POST['email'], $_POST['telepon']);
    } elseif (isset($_POST['update'])) {
        $pelanggan->update($_POST['id'], $_POST['nama'], $_POST['email'], $_POST['telepon']);
    } elseif (isset($_POST['delete'])) {
        $pelanggan->delete($_POST['id']);
    }
}

$dataPelanggan = $pelanggan->getAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pelanggan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

<header>
  <?php
      require('navbar.php');
      ?>
</header>

    <h1 class="text-3xl font-bold mb-4">Manajemen Pelanggan</h1>
    
    <form method="POST" class="mb-4">
        <input type="hidden" name="id">
        <input type="text" name="nama" placeholder="Nama" class="border px-3 py-2" required>
        <input type="email" name="email" placeholder="Email" class="border px-3 py-2" required>
        <input type="text" name="telepon" placeholder="Telepon" class="border px-3 py-2" required>
        <button type="submit" name="add" class="bg-green-500 text-white px-4 py-2">Tambah</button>
    </form>

    <table class="w-full border-collapse border">
        <thead>
            <tr class="bg-gray-200">
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Nama</th>
                <th class="border px-4 py-2">Email</th>
                <th class="border px-4 py-2">Telepon</th>
                <th class="border px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;?>
            <?php foreach ($dataPelanggan as $item) : ?>
                <tr>
                    <td class="border px-4 py-2"><?= $no++ ?></td>
                    <td class="border px-4 py-2"><?= $item['nama'] ?></td>
                    <td class="border px-4 py-2"><?= $item['email'] ?></td>
                    <td class="border px-4 py-2"><?= $item['telepon'] ?></td>
                    <td class="border px-4 py-2">
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $item['id'] ?>">
                            <button type="submit" name="delete" class="bg-red-500 text-white px-4 py-2">Hapus</button>
                        </form>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $item['id'] ?>">
                            <input type="text" name="nama" value="<?= $item['nama'] ?>" class="border px-2 py-1">
                            <input type="email" name="email" value="<?= $item['email'] ?>" class="border px-2 py-1">
                            <input type="text" name="telepon" value="<?= $item['telepon'] ?>" class="border px-2 py-1">
                            <button type="submit" name="update" class="bg-blue-500 text-white px-4 py-2">Ubah</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="dashboard.php" class="mt-4 inline-block bg-gray-500 text-white px-4 py-2">Kembali ke Dashboard</a>
</body>
</html>
