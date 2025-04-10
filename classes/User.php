<?php
require_once 'BaseModel.php';

class User extends BaseModel{
    private $table_name = "users";

    // public function login($username, $password) {
    //     $query = "SELECT * FROM " . $this->table_name . " WHERE username = :username";
    //     $stmt = $this->conn->prepare($query);
    //     $stmt->bindParam(":username", $username);
    //     $stmt->execute();
    //     $user = $stmt->fetch(PDO::FETCH_ASSOC);

    //     if ($user && $password === $user['password']) { 
    //         return $user; // Login berhasil
    //     } else {
    //         return false; // Login gagal
    //     }
    // }

    public function login($username, $password) {
        // Konversi nama pengguna ke huruf kecil untuk pencocokan tidak sensitif huruf besar/kecil
        $username = strtolower($username);
    
        // Kueri untuk mendapatkan informasi pengguna berdasarkan nama pengguna
        $query = "SELECT * FROM " . $this->table_name . " WHERE LOWER(username) = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Verifikasi kata sandi
        if ($user && password_verify($password, $user['password'])) {
            return $user; // Login berhasil
        } else {
            return false; // Login gagal
        }
    }
    
}