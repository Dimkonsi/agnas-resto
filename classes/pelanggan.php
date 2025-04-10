<?php
require_once "BaseModel.php";

class Pelanggan extends BaseModel{
   
    private $table_name = "pelanggan";

    public function getAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($nama, $email, $telepon) {
        $query = "INSERT INTO " . $this->table_name . " (nama, email, telepon) VALUES (:nama, :email, :telepon)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":nama", $nama);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":telepon", $telepon);
        return $stmt->execute();
    }

    public function update($id, $nama, $email, $telepon) {
        $query = "UPDATE " . $this->table_name . " SET nama = :nama, email = :email, telepon = :telepon WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":nama", $nama);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":telepon", $telepon);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
?>
