<?php
session_start();

if (!isset($_SESSION['pengguna_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

require_once '../functions.php'; // Pastikan path ke file koneksi benar

if (isset($_GET['id'])) {
    $id_kandungan = $_GET['id'];

    if (!is_numeric($id_kandungan)) {
        $_SESSION['error_message'] = "ID kandungan tidak valid.";
        header("Location: kelola_kandungan.php"); // Arahkan kembali ke halaman kelola kandungan
        exit();
    }

    $stmt_delete = $conn->prepare("DELETE FROM kandungan_sunscreen WHERE id_kandungan = ?");
    $stmt_delete->bind_param("i", $id_kandungan);

    if ($stmt_delete->execute()) {
        $_SESSION['success_message'] = "Kandungan berhasil dihapus.";
    } else {
        $_SESSION['error_message'] = "Gagal menghapus kandungan: " . $stmt_delete->error;
    }

    $stmt_delete->close();
}

header("Location: kelola_kandungan.php"); // Arahkan kembali ke halaman kelola kandungan
exit();
?>