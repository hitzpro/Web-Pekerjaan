<?php
session_start();
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil inputan username dan password dari form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk memeriksa data admin
    $query = "SELECT * FROM admin WHERE username = :username AND status = 'aktif'";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['username' => $username]);

    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifikasi password
    if ($admin && hash('sha256', $password) === $admin['password']) {
        // Jika login berhasil, set session dan arahkan ke dashboard
        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['login_status'] = 'success'; // Set status login berhasil
        header('Location: login.php'); // Redirect ke halaman login setelah login berhasil
        exit();
    } else {
        $_SESSION['login_status'] = 'failed'; // Set status login gagal
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href="style3.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        </ul>
    </div>
</nav>

<div class="login-form">
    <h2>Login Admin</h2>
    <form action="login.php" method="POST">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Login</button>

        <?php if (isset($_SESSION['login_status']) && $_SESSION['login_status'] == 'failed') { 
            echo '<p class="error">Username atau password salah!</p>';
        } ?>
    </form>
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
    // Cek jika login berhasil atau gagal berdasarkan session
    <?php if (isset($_SESSION['login_status'])): ?>
        <?php if ($_SESSION['login_status'] == 'success'): ?>
            Swal.fire({
                title: 'Login Berhasil!',
                text: 'Selamat datang, Admin!',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(function() {
                window.location = 'dashboard.php';
            });
        <?php elseif ($_SESSION['login_status'] == 'failed'): ?>
            Swal.fire({
                title: 'Login Gagal!',
                text: 'Username atau password salah!',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        <?php endif; ?>
        <?php unset($_SESSION['login_status']); ?>
    <?php endif; ?>
</script>

</body>
</html>
