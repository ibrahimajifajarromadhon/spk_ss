<?php
session_start();

if (!isset($_SESSION['pengguna_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

require_once '../functions.php';

if (isset($_POST['tambah_pengguna'])) {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // Validasi input (tambahkan validasi sesuai kebutuhan)
    if (empty($nama) || empty($email) || empty($_POST['password'])) {
        $_SESSION['error_message'] = "Semua kolom wajib diisi.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = "Format email tidak valid.";
    } else {
        // Cek apakah email sudah terdaftar
        $stmt_check = $conn->prepare("SELECT email FROM pengguna WHERE email = ?");
        $stmt_check->bind_param("s", $email);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();

        if ($result_check->num_rows > 0) {
            $_SESSION['error_message'] = "Email sudah terdaftar.";
        } else {
            $stmt_insert = $conn->prepare("INSERT INTO pengguna (nama, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt_insert->bind_param("ssss", $nama, $email, $password, $role);

            if ($stmt_insert->execute()) {
                $_SESSION['success_message'] = "Pengguna baru berhasil ditambahkan.";
                header("Location: kelola_pengguna.php");
                exit();
            } else {
                $_SESSION['error_message'] = "Gagal menambahkan pengguna: " . $stmt_insert->error;
            }

            $stmt_insert->close();
        }
        $stmt_check->close();
    }
}

include_once('../template.php');
?>

<div class="container">

    <div class="row mt-2 d-flex justify-content-center">
        <div class="display-4 text-center mb-2">
            Tambah Data Pengguna
        </div>
        <div class="col-md-11">
            <div class="card mb-2">
                <div class="card-header">
                    <div class="display-6">Form Tambah Data Pengguna</div>
                </div>
                <div class="card-body">

                    <?php if (isset($_SESSION['error_message'])): ?>
                        <p class="error"><?php echo $_SESSION['error_message']; ?></p>
                        <?php unset($_SESSION['error_message']); ?>
                    <?php endif; ?>

                    <form method="post">
                        <div class="form-group">
                            <label for="nama">Nama Lengkap:</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label for="role">Role:</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="user">Pengguna Biasa</option>
                                <option value="admin">Administrator</option>
                            </select>
                        </div>
                        <button type="submit" name="tambah_pengguna" class="btn btn-success"><i class="fa fa-plus"></i> Tambah Data</button>
                        <a href="kelola_pengguna.php" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>