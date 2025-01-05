

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Employe - Kelompok 1</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="icon" href="#" type="image/x-icon" />
    <style>
      #searchbar{
        width: 50rem;
        border: 1px solid #ccc;
        height: 40px;
      }

      #cari{
        width: 70px;
        height: 40px;
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
          <li><a target="_blank" href="login.php" class="login">Login</a></li>

        </ul>
      </div>
    </nav>

    <section class="utama">
      <div class="bg">
        <h1>Selamat Datang Di Website Kami</h1>
        <p>
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Expedita
          provident vel vero cum veniam, error enim commodi, earum alias nobis
          consequatur, labore magni optio consequuntur in asperiores voluptatem
          temporibus! Atque?
        </p>
        <button onclick="scrollToElement()">Cari Pekerjaan</button>
      </div>
    </section>


    <h2 id="daftar-pekerjaan">Daftar Pekerjaan</h2>
<hr>

    <form action="search.php" method="GET">
      <input id="searchbar" type="search" name="cari" placeholder="Cari Pekerjaan" />
      <button id="cari" type="submit">Cari</button>
    </form>
    <?php
      // Include config.php untuk koneksi database
      include('config.php');

      // Query untuk mengambil semua data dari tabel daftar_pekerjaan
      $query = "SELECT * FROM daftar_pekerjaan";
      $stmt = $pdo->query($query);

      // Mulai output HTML
      echo '<section class="daftar-pekerjaan">';

      // Loop melalui setiap baris hasil query
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<div class="card">';
        echo '<img src="Job offers-bro.png" alt="Foto Pekerjaan">';  // Ganti dengan path foto yang sesuai
        echo '<h3>' . htmlspecialchars($row['nama_pekerjaan']) . '</h3>';
        echo '<p><strong>Kategori:</strong> ' . htmlspecialchars($row['kategori']) . '</p>';
        echo '<p>' . htmlspecialchars(substr($row['deskripsi'], 0, 100)) . '...</p>'; // Menampilkan deskripsi singkat
        echo '<div class="tombol">';
        // Tombol Daftar dengan link ke halaman pendaftaran
        echo '<a href="daftar.php?id_pekerjaan=' . $row['id'] . '"><button class="daftar">Daftar</button></a>';
        // Tombol Detail dengan link ke halaman detail
        echo '<a href="detail_pekerjaan.php?id_pekerjaan=' . $row['id'] . '"><button class="detail">Detail</button></a>';
        echo '</div>';
        echo '</div>';
      }



      echo '</section>';
      echo'<br><br>';
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

<script>
    function scrollToElement() {
        // Cari elemen dengan id "daftar-pekerjaan"
        const target = document.getElementById("daftar-pekerjaan");
        if (target) {
            // Gulir ke elemen dengan animasi mulus
            target.scrollIntoView({ behavior: "smooth" });
        }
    }
</script>


  </body>
</html>
