<?php
require_once "BaseModel.php";

class Pesanan extends BaseModel {
    private $table_name = "pesanan";
    
    // Ambil semua data pesanan (tambahkan field photo)
    public function getAll() {
        $query = "SELECT pesanan.id, pelanggan.nama AS pelanggan, menu.nama AS menu, menu.photo AS photo_menu, 
                         pesanan.jumlah, pesanan.total, pesanan.tanggal 
                  FROM " . $this->table_name . " 
                  JOIN pelanggan ON pesanan.pelanggan_id = pelanggan.id 
                  JOIN menu ON pesanan.menu_id = menu.id 
                  ORDER BY pesanan.id ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    // Fungsi untuk mendapatkan data pesanan berdasarkan id (digunakan saat update)
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Fungsi create dengan penanganan upload gambar
    public function create($pelanggan_id, $menu_id, $jumlah, $total, $photo) {
        $photo_name = null;
        if (is_array($photo) && isset($photo['error']) && $photo['error'] == 0) {
            $photo_name = time() . '_' . basename($photo['name']);
            $target_path = "../uploads/" . $photo_name;
            move_uploaded_file($photo['tmp_name'], $target_path);
        }
        
        $query = "INSERT INTO " . $this->table_name . " (pelanggan_id, menu_id, jumlah, total, photo) VALUES (:pelanggan_id, :menu_id, :jumlah, :total, :photo)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":pelanggan_id", $pelanggan_id);
        $stmt->bindParam(":menu_id", $menu_id);
        $stmt->bindParam(":jumlah", $jumlah);
        $stmt->bindParam(":total", $total);
        $stmt->bindParam(":photo", $photo_name);
        return $stmt->execute();
    }
    
    // Fungsi update dengan penanganan update gambar
    public function update($id, $pelanggan_id, $menu_id, $jumlah, $total, $photo) {
        $photo_name = null;
        
        if (is_array($photo) && isset($photo['error']) && $photo['error'] == 0) {
            $photo_name = time() . '_' . basename($photo['name']);
            $target_path = "../uploads/" . $photo_name;
            move_uploaded_file($photo['tmp_name'], $target_path);
            
            // Hapus file gambar lama jika ada
            $oldData = $this->getById($id);
            if ($oldData && $oldData['photo'] && file_exists("../uploads/" . $oldData['photo'])) {
                unlink("../uploads/" . $oldData['photo']);
            }
            
            $query = "UPDATE " . $this->table_name . " 
                      SET pelanggan_id = :pelanggan_id, menu_id = :menu_id, jumlah = :jumlah, total = :total, photo = :photo 
                      WHERE id = :id";
        } else {
            $query = "UPDATE " . $this->table_name . " 
                      SET pelanggan_id = :pelanggan_id, menu_id = :menu_id, jumlah = :jumlah, total = :total 
                      WHERE id = :id";
        }
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":pelanggan_id", $pelanggan_id);
        $stmt->bindParam(":menu_id", $menu_id);
        $stmt->bindParam(":jumlah", $jumlah);
        $stmt->bindParam(":total", $total);
        if ($photo_name) {
            $stmt->bindParam(":photo", $photo_name);
        }
        return $stmt->execute();
    }
    
    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
    
    public function getLaporanPenjualan($tanggal = null) {
        $query = "SELECT pesanan.id, pelanggan.nama AS pelanggan, menu.nama AS menu, pesanan.jumlah, pesanan.total, pesanan.tanggal 
                  FROM pesanan 
                  JOIN pelanggan ON pesanan.pelanggan_id = pelanggan.id 
                  JOIN menu ON pesanan.menu_id = menu.id";
    
        if ($tanggal) {
            $query .= " WHERE DATE(pesanan.tanggal) = :tanggal";
        }
    
        $query .= " ORDER BY pesanan.tanggal DESC";
        
        $stmt = $this->conn->prepare($query);
        
        if ($tanggal) {
            $stmt->bindParam(":tanggal", $tanggal);
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getRingkasanPenjualan() {
        $query = "SELECT COUNT(id) as total_pesanan, SUM(total) as total_pendapatan FROM pesanan";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
