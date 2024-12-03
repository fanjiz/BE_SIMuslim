<?php
class PendakwahModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function registerPendakwah($namaLengkap, $email, $password, $dokumen) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $query = "INSERT INTO pendakwah (nama_lengkap, email, password, dokumen) VALUES (:nama_lengkap, :email, :password, :dokumen)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':nama_lengkap', $namaLengkap);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':dokumen', $dokumen);
        
        return $stmt->execute();
    }
}
?>
