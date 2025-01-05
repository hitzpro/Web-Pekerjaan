
<?php
require 'config.php';

// Cek apakah id_pekerjaan ada di query string
if (isset($_GET['id_pekerjaan'])) {
    $id_pekerjaan = $_GET['id_pekerjaan'];

    // Query untuk mendapatkan detail pekerjaan berdasarkan ID
    $query = "SELECT * FROM daftar_pekerjaan WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id_pekerjaan, PDO::PARAM_INT);
    $stmt->execute();
    $pekerjaan = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($pekerjaan) {
        // Tampilkan detail pekerjaan
        echo '<!DOCTYPE html>';
        echo '<html lang="id">';
        echo '<head>';
        echo '<meta charset="UTF-8">';
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        echo '<title>Detail Pekerjaan</title>';
        echo '<link rel="stylesheet" href="style.css">'; // Link ke CSS
        echo '</head>';
        echo '<body>';

        // Navbar
        include 'nav.php';

        echo '<div class="detail-container">';
        echo '<h1>' . htmlspecialchars($pekerjaan['nama_pekerjaan']) . '</h1>';
        echo '<p><strong>Kategori:</strong> ' . htmlspecialchars($pekerjaan['kategori']) . '</p>';
        echo '<p><strong>Deskripsi:</strong> ' . htmlspecialchars($pekerjaan['deskripsi']) . '</p>';
        
        // Tambahkan gambar placeholder
        echo '<img src="https://via.placeholder.com/800x400" alt="Gambar placeholder" class="detail-image">';
        
        // Tambahkan paragraf tambahan
        echo '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin euismod, justo eget fringilla vehicula, eros justo posuere lacus, et pellentesque est tortor at odio. Nam nec tortor id neque scelerisque egestas.</p>';
        echo '<p>Donec ac eros ac lorem malesuada blandit. Sed at lectus vel eros fermentum pellentesque. Integer volutpat, sapien sit amet laoreet tempor, velit sapien suscipit sapien, ut tincidunt mauris nisi et ligula.</p>';
        echo '<p>Suspendisse potenti. Nullam varius augue vel nunc facilisis aliquet. Aliquam erat volutpat. Nam eget purus id libero scelerisque convallis id in lectus.</p>';
        echo '<p>Quisque ac mi quis arcu dictum malesuada. Aenean id tempor eros. Duis eget orci vitae neque malesuada commodo nec quis erat.</p>';
        
        // Tambahkan tombol Daftar
        echo '<a href="daftar.php?id_pekerjaan=' . htmlspecialchars($id_pekerjaan) . '"><button class="daftar">Daftar</button></a>';
        echo '</div>';
        

        // Footer
        include 'footer.php';

        echo '</body>';
        echo '</html>';
    } else {
        echo '<p>Pekerjaan tidak ditemukan.</p>';
    }
} else {
    echo '<p>ID pekerjaan tidak disediakan.</p>';
}
?>
