<?php
session_start();

if (!isset($_SESSION['pengguna_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

require_once '../functions.php'; 

if (isset($_GET['id'])) {
    $id_preferensi = $_GET['id'];

    if (!is_numeric($id_preferensi)) {
        $_SESSION['error_message'] = "ID preferensi tidak valid.";
        header("Location: kelola_preferensi.php"); // Arahkan kembali ke halaman kelola preferensi
        exit();
    }

    $stmt_delete = $conn->prepare("DELETE FROM preferensi_pengguna WHERE id_preferensi = ?");
    $stmt_delete->bind_param("i", $id_preferensi);

    if ($stmt_delete->execute()) {
        $_SESSION['success_message'] = "Preferensi pengguna berhasil dihapus.";
    } else {
        $_SESSION['error_message'] = "Gagal menghapus preferensi pengguna: " . $stmt_delete->error;
    }

    $stmt_delete->close();
}

header("Location: kelola_preferensi.php"); // Arahkan kembali ke halaman kelola preferensi
exit();
?>