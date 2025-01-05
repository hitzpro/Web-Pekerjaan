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
    <title>Hapus Data</title>
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
            // Hapus dari pendaftar
            $query_pendaftar = "DELETE FROM pendaftar WHERE id = :id";
            $stmt_pendaftar = $pdo->prepare($query_pendaftar);
            $stmt_pendaftar->execute(['id' => $id]);

            // Hapus dari pendaftar_umum
            $query_umum = "DELETE FROM pendaftar_umum WHERE id = :id";
            $stmt_umum = $pdo->prepare($query_umum);
            $stmt_umum->execute(['id' => $id]);

            // Reset ID di tabel pendaftar
            $pdo->query("CALL reset_id_pendaftar()");

            // Reset ID di tabel pendaftar_umum
            $pdo->query("CALL reset_id_pendaftar_umum()");

            ?>
            <script>
                Swal.fire({
                    title: 'Berhasil!',
                    text: 'Data pendaftar berhasil dihapus.',
                    icon: 'success',
                    timer: 1500
                }).then(function() {
                    window.location = 'dashboard.php';
                });
            </script>
            <?php
            
        } catch (Exception $e) {
            ?>
            <script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Gagal menghapus data. <?php echo addslashes($e->getMessage()); ?>',
                    icon: 'error'
                }).then(function() {
                    window.location = 'dashboard.php';
                });
            </script>
            <?php
        }
    } else {
        ?>
        <script>
            Swal.fire({
                title: 'Error!',
                text: 'ID tidak valid.',
                icon: 'error'
            }).then(function() {
                window.location = 'dashboard.php';
            });
        </script>
        <?php
    }
    ?>
</body>
</html>
