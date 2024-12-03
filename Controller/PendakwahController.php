<?php
include_once 'models/PendakwahModel.php';

class PendakwahController {

    private $model;

    public function __construct($db) {
        $this->model = new PendakwahModel($db);
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get form data
            $namaLengkap = $_POST['nama-lengkap'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Handle file upload
            if (isset($_FILES['dokumen'])) {
                $dokumen = $_FILES['dokumen']['name'];
                $targetDir = "uploads/";
                $targetFile = $targetDir . basename($dokumen);
                move_uploaded_file($_FILES['dokumen']['tmp_name'], $targetFile);
            }

            // Call model method to register the Pendakwah
            $result = $this->model->registerPendakwah($namaLengkap, $email, $password, $dokumen);

            if ($result) {
                header('Location: ../views/success.php'); // Redirect to success page
            } else {
                echo "Registration failed.";
            }
        }
    }
}
?>
