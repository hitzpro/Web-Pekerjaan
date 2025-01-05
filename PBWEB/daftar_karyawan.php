<?php
include 'config.php'; // Koneksi database menggunakan PDO

// Query untuk mendapatkan data
$sql = "SELECT * FROM pendaftar_umum";
$stmt = $pdo->prepare($sql); // Gunakan PDO::prepare
$stmt->execute(); // Eksekusi query

// Ambil semua data
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Karyawan</title>
    <link rel="stylesheet" href="style.css">
    <style>
      body{
        /* min-height: 100vh; */
      }
      /* Gaya umum untuk kolom status */
      .status {
          font-weight: bold;
      }

      /* Gaya spesifik berdasarkan status */
      .status.PENDING {
          color: #d9c921;
      }

      .status.DITERIMA {
          color: #34c91a;
      }

      .status.DITOLAK {
          color: #b5150d;
      }

      footer{
        position: relative;
        top: 100px;
      }
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
          <li><a href="tentang-kami.html">Tentang Kami</a></li>
          <li><a href="contact.html">Kontak</a></li>
          <li>
              <form action="search.php" method="GET">
                  <input type="search" name="cari" placeholder="Cari Pekerjaan" />
                  <button type="submit">Cari</button>
              </form>
          </li>
        </ul>
      </div>
</nav>

    <div class="container">
        <h1>Daftar Karyawan</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
              <?php
              foreach ($data as $row) {
                  // Tentukan kelas berdasarkan status
                  $statusClass = strtoupper($row['status']); // Convert status to lowercase for consistency
                  echo "
                  <tr>
                      <td>{$row['id']}</td>
                      <td>{$row['nama']}</td>
                      <td class='status {$statusClass}'>".ucfirst($row['status'])."</td>
                  </tr>
                  ";
              }
              ?>
          </tbody>

        </table>
    </div>

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
