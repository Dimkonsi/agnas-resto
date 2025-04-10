<?php
session_start();
require_once "../classes/menu.php";
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$menu = new Menu();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add'])) {
        $menu->create($_POST['nama'], $_POST['harga'], $_POST['stok'], $_FILES['photo']);
    } elseif (isset($_POST['update'])) {
        $menu->update($_POST['id'], $_POST['nama'], $_POST['harga'], $_POST['stok'], $_FILES['photo']);
    } elseif (isset($_POST['delete'])) {
        $menu->delete($_POST['id']);
    }
}

$dataMenu = $menu->getAll();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manajemen Menu</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
  <!-- Header -->
  <header class="bg-white shadow">
    <?php require('navbar.html'); ?>
  </header>

  <!-- Main Container -->
  <main class="container mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-3xl font-bold text-gray-800">Manajemen Menu Makanan</h1>
      <a href="dashboard.php" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Kembali ke Dashboard</a>
    </div>

    <!-- Card Form Tambah Menu -->
    <div class="bg-white rounded shadow p-6 mb-8">
      <h2 class="text-xl font-semibold mb-4">Tambah Menu</h2>
      <form method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
          <label for="nama" class="block text-gray-700">Nama Menu</label>
          <input type="text" name="nama" id="nama" placeholder="Nama Menu" class="mt-1 block w-full border-gray-300 rounded" required>
        </div>
        <div>
          <label for="harga" class="block text-gray-700">Harga</label>
          <input type="number" name="harga" id="harga" placeholder="Harga" class="mt-1 block w-full border-gray-300 rounded" required>
        </div>
        <div>
          <label for="stok" class="block text-gray-700">Stok</label>
          <input type="number" name="stok" id="stok" placeholder="Stok" class="mt-1 block w-full border-gray-300 rounded" required>
        </div>
        <div>
          <label for="photo" class="block text-gray-700">Gambar</label>
          <input type="file" name="photo" id="photo" accept="image/*" class="mt-1 block w-full text-gray-700">
        </div>
        <div class="md:col-span-4">
          <button type="submit" name="add" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Tambah</button>
        </div>
      </form>
    </div>

    <!-- Tabel Daftar Menu -->
    <div class="bg-white rounded shadow p-6">
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stok</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Gambar</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          <?php $no = 1; ?>
          <?php foreach ($dataMenu as $item) : ?>
            <tr>
              <td class="px-6 py-4 whitespace-nowrap"><?= $no++ ?></td>
              <td class="px-6 py-4 whitespace-nowrap"><?= $item['nama'] ?></td>
              <td class="px-6 py-4 whitespace-nowrap"><?= $item['harga'] ?></td>
              <td class="px-6 py-4 whitespace-nowrap"><?= $item['stok'] ?></td>
              <td class="px-6 py-4 whitespace-nowrap">
                <?php if($item['photo']) : ?>
                  <img src="../uploads/<?= $item['photo'] ?>" alt="<?= $item['nama'] ?>" class="w-12 h-12 object-cover rounded">
                <?php else: ?>
                  <span class="text-gray-500 text-sm">No Image</span>
                <?php endif; ?>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <div class="flex space-x-2">
                  <!-- Form Hapus -->
                  <form method="POST" onsubmit="return confirm('Yakin akan menghapus menu ini?');">
                    <input type="hidden" name="id" value="<?= $item['id'] ?>">
                    <button type="submit" name="delete" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Hapus</button>
                  </form>
                  <!-- Tombol Ubah -->
                  <button onclick="toggleEdit(<?= $item['id'] ?>)" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Ubah</button>
                </div>
              </td>
            </tr>
            <!-- Baris form update, disembunyikan default -->
            <tr id="editRow-<?= $item['id'] ?>" class="hidden bg-gray-50">
              <td colspan="6" class="px-6 py-4">
                <form method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                  <input type="hidden" name="id" value="<?= $item['id'] ?>">
                  <div>
                    <label for="nama-<?= $item['id'] ?>" class="block text-gray-700">Nama</label>
                    <input type="text" name="nama" id="nama-<?= $item['id'] ?>" value="<?= $item['nama'] ?>" class="mt-1 block w-full border-gray-300 rounded">
                  </div>
                  <div>
                    <label for="harga-<?= $item['id'] ?>" class="block text-gray-700">Harga</label>
                    <input type="number" name="harga" id="harga-<?= $item['id'] ?>" value="<?= $item['harga'] ?>" class="mt-1 block w-full border-gray-300 rounded">
                  </div>
                  <div>
                    <label for="stok-<?= $item['id'] ?>" class="block text-gray-700">Stok</label>
                    <input type="number" name="stok" id="stok-<?= $item['id'] ?>" value="<?= $item['stok'] ?>" class="mt-1 block w-full border-gray-300 rounded">
                  </div>
                  <div>
                    <label for="photo-<?= $item['id'] ?>" class="block text-gray-700">Gambar</label>
                    <input type="file" name="photo" id="photo-<?= $item['id'] ?>" accept="image/*" class="mt-1 block w-full text-gray-700">
                  </div>
                  <div class="flex items-end">
                    <button type="submit" name="update" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan Perubahan</button>
                  </div>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </main>
  
  <!-- Script untuk toggle form update -->
  <script>
    function toggleEdit(id) {
      const row = document.getElementById('editRow-' + id);
      row.classList.toggle('hidden');
    }
  </script>
</body>
</html>
