<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Employe - Kelompok 1</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="icon" href="#" type="image/x-icon" />
    <style>

    </style>
  </head>
  <body>
    <nav>
      <div class="logo">
        <a href="home.html">
          <img src="#" alt="Kelompok 1" />
        </a>
      </div>

      <div class="links">
        <ul>
          <li><a href="home.php">Beranda</a></li>
          <li><a href="daftar_karyawan.php">Daftar Pendaftar</a></li>
          <li><a href="#">Tentang Kami</a></li>
          <li><a href="#">Kontak</a></li>
          <li>
              <form action="search.php" method="GET">
                  <input type="search" name="cari" placeholder="Cari Pekerjaan" />
                  <button type="submit">Cari</button>
              </form>
          </li>

        </ul>
      </div>
    </nav>
  


<?php
// Include config.php untuk koneksi database
include('config.php');

// Ambil nilai dari input pencarian
$cari = isset($_GET['cari']) ? $_GET['cari'] : '';

// Pastikan input pencarian aman untuk digunakan dalam query
$cari = htmlspecialchars($cari);

// Query untuk mencari pekerjaan berdasarkan kata kunci
$query = "SELECT * FROM daftar_pekerjaan WHERE nama_pekerjaan LIKE :cari OR kategori LIKE :cari OR deskripsi LIKE :cari";
$stmt = $pdo->prepare($query);
$stmt->execute(['cari' => '%' . $cari . '%']); // Menambahkan % untuk mencocokkan sebagian kata

// Mulai output HTML
echo '<h2>Hasil Pencarian: "' . $cari . '"</h2><hr>';

echo '<section class="daftar-pekerjaan">';

// Jika ada hasil pencarian
if ($stmt->rowCount() > 0) {
    // Loop melalui hasil pencarian
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<div class="card">';
        echo '<img src="Job offers-bro.png" alt="Foto Pekerjaan">';  // Ganti dengan path foto yang sesuai
        echo '<h3>' . htmlspecialchars($row['nama_pekerjaan']) . '</h3>';
        echo '<p><strong>Kategori:</strong> ' . htmlspecialchars($row['kategori']) . '</p>';
        echo '<p>' . htmlspecialchars($row['deskripsi']) . '</p>';
        echo '<div class="tombol">';
        echo '<a href="daftar.php?id_pekerjaan=' . $row['id'] . '"><button class="daftar">Daftar</button></a>';
        echo '<button class="detail">Detail</button>';
        echo '</div>';
        echo '</div>';
    }
} else {
    // Jika tidak ada hasil pencarian
    echo '<p>Tidak ada pekerjaan yang ditemukan untuk kata kunci "' . $cari . '"</p>';
}

echo '</section>';
?>

<footer>
      <div class="logo">
        <a href="home.html">
          <img src="#" alt="Kelompok 1" />
        </a>
      </div>

      <div class="alamat">
        <p>Jl. BantarGebang Kota Bekasi</p>
        <p>Email : kelompok6@gmail.com</p>
        <p>no Telp : 084323182192</p>
      </div>

      <div class="links">
        <ul>
          <li><a href="#">Facebook</a></li>
          <li><a href="#">Youtube</a></li>
          <li><a href="#">Instagram</a></li>
        </ul>
      </div>
    </footer>

</body>
</html>
