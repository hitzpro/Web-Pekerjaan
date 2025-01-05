<?php
session_start();
include('config.php');

// Cek login admin
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hapus Pekerjaan</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
      body{
        font-family: Poppins;
      }
    </style>
</head>
<body>
    <?php
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = $_GET['id'];

        try {
            // Langkah 1: Update referensi id_pekerjaan di tabel pendaftar menjadi NULL
            $query_update_pendaftar = "UPDATE pendaftar SET id_pekerjaan = NULL WHERE id_pekerjaan = :id";
            $stmt_update = $pdo->prepare($query_update_pendaftar);
            $stmt_update->execute(['id' => $id]);

            // Langkah 2: Hapus pekerjaan dari tabel daftar_pekerjaan
            $query_pekerjaan = "DELETE FROM daftar_pekerjaan WHERE id = :id";
            $stmt_pekerjaan = $pdo->prepare($query_pekerjaan);
            $stmt_pekerjaan->execute(['id' => $id]);

            // Langkah 3: Jalankan prosedur reset_id_daftar_pekerjaan setelah penghapusan pekerjaan
            $pdo->query("CALL reset_id_daftar_pekerjaan()");

            // Jika berhasil, tampilkan sweetalert sukses
            ?>
            <script>
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Pekerjaan berhasil dihapus.',
                    icon: 'success',
                    timer: 1500
                }).then(function() {
                    window.location = 'dashboard.php?tab=daftar-pekerjaan';
                });
            </script>
            <?php
        } catch (Exception $e) {
            // Jika terjadi error, tampilkan pesan error
            ?>
            <script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Gagal menghapus pekerjaan. <?php echo addslashes($e->getMessage()); ?>',
                    icon: 'error'
                }).then(function() {
                    window.location = 'dashboard.php?tab=daftar-pekerjaan';
                });
            </script>
            <?php
        }
    } else {
        // Jika ID tidak valid, tampilkan error
        ?>
        <script>
            Swal.fire({
                title: 'Error!',
                text: 'ID tidak valid.',
                icon: 'error'
            }).then(function() {
                window.location = 'dashboard.php?tab=daftar-pekerjaan';
            });
        </script>
        <?php
    }
    ?>
</body>
</html>
