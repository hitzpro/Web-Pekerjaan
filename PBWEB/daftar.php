<?php
// Include config.php for database connection
include('config.php');

// Get job ID from query string
$id_pekerjaan = isset($_GET['id_pekerjaan']) ? $_GET['id_pekerjaan'] : '';

// Check if job ID is missing
if (empty($id_pekerjaan)) {
    die("Invalid job ID.");
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $nama = $_POST['nama'];
    $umur = $_POST['umur'];
    $alamat = $_POST['alamat'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $no_telepon = $_POST['no_telepon'];
    $email = $_POST['email'];

    try {
        // Query to insert applicant data into the pendaftar table
        $query_pendaftar = "INSERT INTO pendaftar (id_pekerjaan, nama, umur, alamat, jenis_kelamin, no_telepon, email) 
                            VALUES (:id_pekerjaan, :nama, :umur, :alamat, :jenis_kelamin, :no_telepon, :email)";
        $stmt_pendaftar = $pdo->prepare($query_pendaftar);
        $stmt_pendaftar->execute([
            'id_pekerjaan' => $id_pekerjaan,
            'nama' => $nama,
            'umur' => $umur,
            'alamat' => $alamat,
            'jenis_kelamin' => $jenis_kelamin,
            'no_telepon' => $no_telepon,
            'email' => $email
        ]);

        // Insert the applicant data into the pendaftar_umum table with 'pending' status
        $query_pendaftar_umum = "INSERT INTO pendaftar_umum (nama, status) VALUES (:nama, 'pending')";
        $stmt_pendaftar_umum = $pdo->prepare($query_pendaftar_umum);
        $stmt_pendaftar_umum->execute([
            'nama' => $nama
        ]);

        // Redirect to the same page with success parameter
        header("Location: daftar.php?id_pekerjaan=$id_pekerjaan&success=1");
        exit;
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Pekerjaan</title>
    <link rel="stylesheet" href="style2.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        #login {
            font-size: 14px;
            padding: 8px 10px;
            border: none;
            border-radius: 3px;
            background-color: #4caf50;
            color: white;
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
            <li><a href="#">Tentang Kami</a></li>
            <li><a href="#">Kontak</a></li>
            <li>
                <form action="search.php" method="GET">
                    <input type="search" name="cari" placeholder="Cari Pekerjaan" />
                    <button type="submit">Cari</button>
                </form>
            </li>
            <li><a target="_blank" href="login.php" id="login">Login</a></li>
        </ul>
    </div>
</nav>

<h2>Pendaftaran Pekerjaan</h2>
<form class="form" action="daftar.php?id_pekerjaan=<?php echo $id_pekerjaan; ?>" method="POST">
    <label for="nama">Nama Lengkap:</label><br>
    <input type="text" name="nama" id="nama" required><br><br>

    <label for="umur">Umur:</label><br>
    <input type="number" name="umur" id="umur" required><br><br>

    <label for="alamat">Alamat:</label><br>
    <textarea name="alamat" id="alamat" rows="4" required></textarea><br><br>

    <label for="jenis_kelamin">Jenis Kelamin:</label><br>
    <select name="jenis_kelamin" id="jenis_kelamin" required>
        <option value="Laki-laki">Laki-laki</option>
        <option value="Perempuan">Perempuan</option>
    </select><br><br>

    <label for="no_telepon">Nomor Telepon:</label><br>
    <input type="text" name="no_telepon" id="no_telepon" required><br><br>

    <label for="email">Email:</label><br>
    <input type="email" name="email" id="email" required><br><br>

    <input type="submit" value="Daftar">
</form>

<footer>
    <div class="logo">
        <a href="home.html">
            <img src="#" alt="Kelompok 1" />
        </a>
    </div>

    <div class="alamat">
        <p>Jl. BantarGebang Kota Bekasi</p>
        <p>Email : kelompok6@gmail.com</p>
        <p>No Telp : 084323182192</p>
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
    // Sweet Alert script
    window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('success') && urlParams.get('success') === '1') {
            Swal.fire({
                title: "Berhasil!",
                text: "Pendaftaran berhasil dilakukan.",
                icon: "success",
                confirmButtonText: "OK"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.history.replaceState(null, null, window.location.pathname);
                }
            });
        }
    };
</script>
</body>
</html>
