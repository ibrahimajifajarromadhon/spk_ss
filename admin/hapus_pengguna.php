<?php
session_start();

if (!isset($_SESSION['pengguna_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

require_once '../functions.php';

if (isset($_GET['id'])) {
    $id_pengguna = $_GET['id'];

    if (!is_numeric($id_pengguna)) {
        $_SESSION['error_message'] = "ID pengguna tidak valid.";
        header("Location: kelola_pengguna.php");
        exit();
    }

    if ($id_pengguna == $_SESSION['pengguna_id']) {
        $_SESSION['error_message'] = "Anda tidak dapat menghapus akun Anda sendiri melalui halaman ini.";
        header("Location: kelola_pengguna.php");
        exit();
    }

    $stmt_delete = $conn->prepare("DELETE FROM pengguna WHERE id_pengguna = ?");
    $stmt_delete->bind_param("i", $id_pengguna);

    if ($stmt_delete->execute()) {
        $_SESSION['success_message'] = "Pengguna berhasil dihapus.";
    } else {
        $_SESSION['error_message'] = "Gagal menghapus pengguna: " . $stmt_delete->error;
    }

    $stmt_delete->close();
}

header("Location: kelola_pengguna.php");
exit();
?>