<?php
include_once '../Model/PendakwahModel.php';
include_once 'config.php'; // Memasukkan konfigurasi database

class PendakwahController {
    private $model;

    public function __construct() {
        $this->model = new PendakwahModel();
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Mendapatkan data dari form
            $namaLengkap = $_POST['nama-lengkap'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Menangani file upload
            if (isset($_FILES['dokumen'])) {
                $dokumen = $_FILES['dokumen']['name'];
                $targetDir = "uploads/";
                $targetFile = $targetDir . basename($dokumen);
                move_uploaded_file($_FILES['dokumen']['tmp_name'], $targetFile);
            }

            // Panggil model untuk mendaftarkan pendakwah
            $result = $this->model->registerPendakwah($namaLengkap, $email, $password, $dokumen);

            if ($result) {
                header('Location: ../views/success.php'); // Redirect jika sukses
            } else {
                echo "Registrasi gagal.";
            }
        }
    }
}
?>
