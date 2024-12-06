<?php
// Koneksi database
include('config.php');

// Mendapatkan ID dari URL
$idInformasi = $_GET['id'] ?? 0;

// Query untuk mendapatkan data berdasarkan ID
$stmt = $pdo->prepare("SELECT * FROM materi WHERE id = :id");
$stmt->execute(['id' => intval($idInformasi)]);
$informasi = $stmt->fetch(PDO::FETCH_ASSOC);

// Jika data tidak ditemukan
if (!$informasi) {
    echo "<h1>Artikel tidak ditemukan</h1>";
    exit();
}

// Fungsi untuk memformat isi artikel menjadi paragraf
function formatIsiContent($content) {
    $paragraphs = array_map(function($p) {
        return "<p>$p</p>";
    }, str_split($content, 600));
    return implode("\n", $paragraphs);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($informasi['title'], ENT_QUOTES, 'UTF-8') ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="/View/css/isi-materi.css">
</head>

<body>
    <!-- Header -->
    <header class="bg-success text-white py-3">
        <div class="container d-flex align-items-center">
            <a href="/View/materi.html" class="btn btn-light me-3">
                ← Kembali
            </a>
            <h1 class="h4 mb-0 text-center flex-grow-1">Materi Islami</h1>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container my-5">
        <article class="bg-white p-4 rounded shadow">
            <!-- Image -->
            <div class="text-center mb-4">
                <img src="<?= htmlspecialchars($informasi['image'], ENT_QUOTES, 'UTF-8') ?>" alt="Gambar Artikel" class="img-fluid rounded" style="max-width: 100%; height: auto;">
            </div>
            
            <!-- Title -->
            <div class="text-center mb-4">
                <h2 class="h4"><?= htmlspecialchars($informasi['title'], ENT_QUOTES, 'UTF-8') ?></h2>
            </div>

            <!-- Meta Info -->
            <div class="text-muted mb-3">
                <p><strong>Penulis:</strong> <?= htmlspecialchars($informasi['author'], ENT_QUOTES, 'UTF-8') ?></p>
                <p><strong>Tanggal:</strong> <?= date("d F Y", strtotime($informasi['date'])) ?></p>
            </div>

            <!-- Content -->
            <div class="content">
                <?= !empty($informasi['content']) ? formatIsiContent($informasi['content']) : file_get_contents("https://loripsum.net/api/html") ?>
            </div>
        </article>

        <!-- Back to Homepage -->
        <div class="text-center mt-4">
            <a href="/View/materi.html" class="btn btn-success">← Kembali ke Beranda</a>
        </div>
    </main>

    <!-- Footer -->
    <footer class="text-center bg-light py-3">
        <p class="mb-0">&copy; 2024. Semua Hak Dilindungi.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
