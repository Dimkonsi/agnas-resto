<?php
require_once 'BaseModel.php';

class Menu extends BaseModel{

    private $table_name= "menu";

    public function getAll(){
        $query = "SELECT * FROM ".$this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }

    public function getById($id){
        $query = "SELECT * FROM ". $this->table_name." WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


public function create($nama, $harga, $stok, $photo) {
    $photo_name = null; // Default tanpa gambar
    if ($photo['error'] == 0) {
        $photo_name = time() . '_' . basename($photo['name']);
        $target_path = "../uploads/" . $photo_name;
        move_uploaded_file($photo['tmp_name'], $target_path);
    }

    $query = "INSERT INTO " . $this->table_name . " (nama, harga, stok, photo) VALUES (:nama, :harga, :stok, :photo)";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":nama", $nama);
    $stmt->bindParam(":harga", $harga);
    $stmt->bindParam(":stok", $stok);
    $stmt->bindParam(":photo", $photo_name);
    return $stmt->execute();
}
    
    public function update($id, $nama, $harga, $stok, $photo) {
        $photo_name = null;
    
        if ($photo['error'] == 0) {
            $photo_name = time() . '_' . basename($photo['name']);
            $target_path = "../uploads/" . $photo_name;
            move_uploaded_file($photo['tmp_name'], $target_path);
    
            // Hapus gambar lama
            $oldPhoto = $this->getById($id)['photo'];
            if ($oldPhoto && file_exists("../uploads/" . $oldPhoto)) {
                unlink("../uploads/" . $oldPhoto);
            }
    
            $query = "UPDATE " . $this->table_name . " SET nama = :nama, harga = :harga, stok = :stok, photo = :photo WHERE id = :id";
        } else {
            $query = "UPDATE " . $this->table_name . " SET nama = :nama, harga = :harga, stok = :stok WHERE id = :id";
        }
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":nama", $nama);
        $stmt->bindParam(":harga", $harga);
        $stmt->bindParam(":stok", $stok);
        if ($photo_name) {
            $stmt->bindParam(":photo", $photo_name);
        }
    
        return $stmt->execute();
    }

    public function delete($id) {
    // Ambil nama file foto sebelum menghapus data
    $oldPhoto = $this->getById($id)['photo'];
    if ($oldPhoto && file_exists("../uploads/" . $oldPhoto)) {
        unlink("../uploads/" . $oldPhoto); // Hapus file foto
    }

    $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(":id", $id);
    return $stmt->execute();
}
}