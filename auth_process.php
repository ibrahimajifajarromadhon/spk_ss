<?php 
session_start();
require_once('functions.php');

if (isset($_POST['register'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt_check = $conn->prepare("SELECT email FROM pengguna WHERE email = ?");
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $_SESSION['register_error'] = "Email sudah terdaftar.";
        header("Location: register.php");
        exit();
    }

    $stmt_insert = $conn->prepare("INSERT INTO pengguna (nama, email, password) VALUES (?, ?, ?)");
    $stmt_insert->bind_param("sss", $nama, $email, $password);
    if ($stmt_insert->execute()) {
        $_SESSION['register_success'] = "Registrasi berhasil. Silakan login.";
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['register_error'] = "Registrasi gagal. Silakan coba lagi.";
        header("Location: register.php");
        exit();
    }
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt_login = $conn->prepare("SELECT id_pengguna, nama, password FROM pengguna WHERE email = ?");
    $stmt_login->bind_param("s", $email);
    $stmt_login->execute();
    $result_login = $stmt_login->get_result();
    $user = $result_login->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['pengguna_id'] = $user['id_pengguna'];
        $_SESSION['nama_user'] = $user['nama'];
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['login_error'] = "Email atau password salah.";
        header("Location: login.php");
        exit();
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

?>