<?php
session_start();
include('config.php');

// Cek login admin
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

// Query untuk daftar pendaftar
$query_pendaftar = "
    SELECT p.*, pu.status
    FROM pendaftar p
    LEFT JOIN pendaftar_umum pu ON p.id = pu.id
    ORDER BY p.id ASC
";
$stmt_pendaftar = $pdo->query($query_pendaftar);

// Query untuk daftar pekerjaan
$query_pekerjaan = "SELECT id, nama_pekerjaan, kategori FROM daftar_pekerjaan ORDER BY id ASC";
$stmt_pekerjaan = $pdo->query($query_pekerjaan);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah_pekerjaan'])) {
  $nama_pekerjaan = $_POST['nama_pekerjaan'];
  $kategori = $_POST['kategori'];
  $deskripsi = $_POST['deskripsi'];

  // Menambah pekerjaan baru ke database
  $query_tambah_pekerjaan = "INSERT INTO daftar_pekerjaan (nama_pekerjaan, kategori, deskripsi) VALUES (:nama_pekerjaan, :kategori, :deskripsi)";
  $stmt_tambah = $pdo->prepare($query_tambah_pekerjaan);
  $stmt_tambah->execute([
      'nama_pekerjaan' => $nama_pekerjaan,
      'kategori' => $kategori,
      'deskripsi' => $deskripsi
  ]);

  // Menambahkan SweetAlert untuk konfirmasi sukses
  $_SESSION['tambah_status_pekerjaan'] = 'success'; // Status berhasil menambah pekerjaan
  header("Location: dashboard.php?tab=daftar-pekerjaan");
  exit();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="style3.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
    /* CSS Khusus Section Pendaftar */
    #pendaftar {
        margin: 20px auto;
        padding: 20px;
        max-width: 1200px;
        background: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow-x: auto; /* Scroll horizontal untuk tabel besar */
    }

    #pendaftar h2 {
        font-size: 24px;
        font-weight: bold;
        color: #333;
        text-align: center;
        margin-bottom: 20px;
    }

    #pendaftar .data-table {
        width: 100%;
        border-collapse: collapse;
        font-family: Arial, sans-serif;
    }

    #pendaftar .data-table thead {
        background-color: #007bff;
        color: #fff;
    }

    #pendaftar .data-table th, 
    #pendaftar .data-table td {
        padding: 12px;
        text-align: center;
        border: 1px solid #ddd;
    }

    #pendaftar .data-table tbody tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #pendaftar .data-table tbody tr:hover {
        background-color: #e9f7ff;
        cursor: pointer;
    }

    #pendaftar .tombol-hapus {
        padding: 8px 12px;
        background-color: #dc3545;
        color: #fff;
        border: none;
        border-radius: 4px;
        font-size: 14px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    #pendaftar .tombol-hapus:hover {
        background-color: #c82333;
    }

    #pendaftar .status {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
        cursor: pointer;
        display: inline-block;
        transition: all 0.3s ease;
    }

    #pendaftar .status.pending {
        background-color: #ffc107;
        color: #856404;
    }

    #pendaftar .status.approved {
        background-color: #28a745;
        color: #fff;
    }

    #pendaftar .status.rejected {
        background-color: #dc3545;
        color: #fff;
    }

    #pendaftar .status:hover {
        transform: scale(1.1);
    }
</style>

</head>
<body>
    <!-- Navbar -->
    <nav>
    <div class="logo">
        <a href="home.html">Kelompok 1</a>
    </div>
    <div class="links">
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="javascript:void(0);" id="logoutBtn">Logout</a></li>
        </ul>
    </div>
</nav>

<!-- SweetAlert 2 script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Menangani klik pada tombol logout
    document.getElementById('logoutBtn').addEventListener('click', function() {
        // Menampilkan SweetAlert konfirmasi logout
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda akan keluar dari akun ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Logout',
            cancelButtonText: 'Batal'
        }).then((result) => {
            // Jika pengguna mengonfirmasi logout
            if (result.isConfirmed) {
                // Redirect ke halaman logout.php untuk menghapus session dan logout
                window.location.href = 'logout.php';
            }
        });
    });
</script>

<div class="dashboard">
    <!-- Tabs -->
    <div class="tabs">
        <button class="tab-button active" onclick="showSection('daftar-pekerjaan')">Daftar Pekerjaan</button>
        <button class="tab-button" onclick="showSection('pendaftar')">Pendaftar</button>
        <button class="tab-button" onclick="showSection('tambah-pekerjaan')">Tambah Pekerjaan</button>
    </div>

    <!-- Section Daftar Pekerjaan -->
    <div id="daftar-pekerjaan" class="section active">
        <h2>Daftar Pekerjaan</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Pekerjaan</th>
                    <th>Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $stmt_pekerjaan->fetch(PDO::FETCH_ASSOC)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['nama_pekerjaan']); ?></td>
                    <td><?php echo htmlspecialchars($row['kategori']); ?></td>
                    <td>
                        <button class="tombol-hapus" onclick="hapusPekerjaan(<?php echo htmlspecialchars($row['id']); ?>)">Hapus</button>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Section Pendaftar -->
    <div id="pendaftar" class="section">
        <h2>Data Pendaftar</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ID Pekerjaan</th>
                    <th>Nama</th>
                    <th>Umur</th>
                    <th>Alamat</th>
                    <th>Jenis Kelamin</th>
                    <th>No Telepon</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $stmt_pendaftar->fetch(PDO::FETCH_ASSOC)) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['id_pekerjaan']); ?></td>
                    <td><?php echo htmlspecialchars($row['nama']); ?></td>
                    <td><?php echo htmlspecialchars($row['umur']); ?></td>
                    <td><?php echo htmlspecialchars($row['alamat']); ?></td>
                    <td><?php echo htmlspecialchars($row['jenis_kelamin']); ?></td>
                    <td><?php echo htmlspecialchars($row['no_telepon']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td>
                        <span class="status <?php echo htmlspecialchars(strtolower($row['status'] ?? 'pending')); ?>" 
                              data-id="<?php echo htmlspecialchars($row['id']); ?>" 
                              onclick="changeStatus(<?php echo htmlspecialchars($row['id']); ?>, '<?php echo htmlspecialchars($row['status'] ?? 'pending'); ?>')">
                            <?php echo ucfirst(htmlspecialchars($row['status'] ?? 'pending')); ?>
                        </span>
                    </td>

                    <td>
                        <button class="tombol-hapus" onclick="hapusPendaftar(<?php echo htmlspecialchars($row['id']); ?>)">Hapus</button>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <!-- Section Tambah Pekerjaan -->
    <div id="tambah-pekerjaan" class="section">
        <h2>Tambah Pekerjaan Baru</h2>
        <form class="form-tambah-pekerjaan" action="dashboard.php" method="POST">
            <label for="nama_pekerjaan">Nama Pekerjaan</label>
            <input type="text" id="nama_pekerjaan" name="nama_pekerjaan" required>
            <label for="kategori">Kategori</label>
            <input type="text" id="kategori" name="kategori" required>
            <label for="deskripsi">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" rows="4" required></textarea><hr>
            <button type="submit" name="tambah_pekerjaan" class="tombol-tambah">Tambah</button>
        </form>
    </div>
  </div>

    <!-- Footer -->
    <footer>
        <div class="logo">
            <a href="home.html">Kelompok 1</a>
        </div>
        <div class="alamat">
            <p>Jl. BantarGebang Kota Bekasi</p>
            <p>Email: kelompok6@gmail.com</p>
            <p>No Telp: 084323182192</p>
        </div>
        <div class="links">
            <ul>
                <li><a href="#">Facebook</a></li>
                <li><a href="#">YouTube</a></li>
                <li><a href="#">Instagram</a></li>
            </ul>
        </div>
    </footer>

    <script>
        function showSection(sectionId) {
            document.querySelectorAll('.section').forEach(section => {
                section.classList.remove('active');
            });
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active');
            });
            document.getElementById(sectionId).classList.add('active');
            document.querySelector(`[onclick="showSection('${sectionId}')"]`).classList.add('active');
        }

        function hapusPekerjaan(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dipulihkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `hapus_pekerjaan.php?id=${id}`;
                }
            });
        }
    </script>


<script>
  function hapusPendaftar(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data yang dihapus tidak dapat dipulihkan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            // Kirim request ke hapus.php untuk menghapus data
            window.location.href = `hapus.php?id=${id}`;
        }
    });
}

</script>


<script>
  // Cek jika menambah pekerjaan berhasil
<?php if (isset($_SESSION['tambah_status_pekerjaan']) && $_SESSION['tambah_status_pekerjaan'] == 'success'): ?>
    Swal.fire({
        title: 'Pekerjaan Berhasil Ditambahkan!',
        text: 'Data pekerjaan baru telah ditambahkan.',
        icon: 'success',
        confirmButtonText: 'OK'
    });
    <?php unset($_SESSION['tambah_status_pekerjaan']); ?>
<?php endif; ?>

</script>

<script>
    // SweetAlert untuk mengubah status
    function changeStatus(id, currentStatus) {
        Swal.fire({
            title: 'Ubah Status',
            input: 'select',
            inputOptions: {
                'pending': 'Pending',
                'diterima': 'Diterima',
                'ditolak': 'Ditolak'
            },
            inputValue: currentStatus,
            showCancelButton: true,
            confirmButtonText: 'Simpan',
            cancelButtonText: 'Batal',
            inputValidator: (value) => {
                if (!value) {
                    return 'Anda harus memilih status!';
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const selectedStatus = result.value;
                updateStatus(id, selectedStatus);
            }
        });
    }

    // Fungsi untuk mengirim request perubahan status ke server
    function updateStatus(id, status) {
        fetch(`update_status.php?id=${encodeURIComponent(id)}&status=${encodeURIComponent(status)}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: 'Status berhasil diperbarui!',
                        icon: 'success',
                        timer: 1500
                    }).then(() => location.reload());
                } else {
                    Swal.fire('Gagal!', data.message || 'Terjadi kesalahan.', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error!', 'Terjadi kesalahan pada server.', 'error');
            });
    }
</script>

</body>
</html>
