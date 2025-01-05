<?php
session_start();
include('config.php');

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Unauthorized access']);
    exit();
}

// Check if required parameters are present
if (!isset($_GET['id']) || !isset($_GET['status'])) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Missing required parameters']);
    exit();
}

$id = $_GET['id'];
$status = $_GET['status'];

// Validate status value
$allowed_statuses = ['pending', 'diterima', 'ditolak'];
if (!in_array($status, $allowed_statuses)) {
    header('Content-Type: application/json');
    echo json_encode(['success' => false, 'message' => 'Invalid status value']);
    exit();
}

try {
    // Begin transaction
    $pdo->beginTransaction();

    // Check if record exists in pendaftar_umum
    $check_query = "SELECT id FROM pendaftar_umum WHERE id = ?";
    $check_stmt = $pdo->prepare($check_query);
    $check_stmt->execute([$id]);

    if ($check_stmt->rowCount() > 0) {
        // Update existing record
        $update_query = "UPDATE pendaftar_umum SET status = ? WHERE id = ?";
        $update_stmt = $pdo->prepare($update_query);
        $update_stmt->execute([$status, $id]);
    } else {
        // Insert new record
        $insert_query = "INSERT INTO pendaftar_umum (id, nama, status) 
                        SELECT id, nama, ? FROM pendaftar WHERE id = ?";
        $insert_stmt = $pdo->prepare($insert_query);
        $insert_stmt->execute([$status, $id]);
    }

    // Commit transaction
    $pdo->commit();

    header('Content-Type: application/json');
    echo json_encode(['success' => true]);

} catch (PDOException $e) {
    // Rollback transaction on error
    $pdo->rollBack();
    
    header('Content-Type: application/json');
    echo json_encode([
        'success' => false, 
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
