<?php
include_once 'config.php'; // Menghubungkan dengan file config.php

class PendakwahModel {
    // Fungsi untuk mendaftarkan pendakwah
    public function registerPendakwah($namaLengkap, $email, $password, $dokumen) {
        global $conn; // Menggunakan koneksi dari config.php

        // Meng-hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        // Menyiapkan query SQL
        $query = "INSERT INTO pendakwah (nama_lengkap, email, password, dokumen) VALUES (?, ?, ?, ?)";

        // Menyiapkan statement
        if ($stmt = $conn->prepare($query)) {
            // Mengikat parameter
            $stmt->bind_param("ssss", $namaLengkap, $email, $hashedPassword, $dokumen);

            // Mengeksekusi query
            $result = $stmt->execute();

            // Menutup statement
            $stmt->close();

            return $result;
        } else {
            return false;
        }
    }
}
?>
