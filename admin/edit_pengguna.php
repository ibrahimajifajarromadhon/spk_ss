<?php
session_start();

if (!isset($_SESSION['pengguna_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

require_once '../functions.php';

if (isset($_GET['id'])) {
    $id_pengguna = $_GET['id'];

    // Ambil data pengguna berdasarkan ID
    $stmt = $conn->prepare("SELECT id_pengguna, nama, email, role FROM pengguna WHERE id_pengguna = ?");
    $stmt->bind_param("i", $id_pengguna);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows !== 1) {
        $_SESSION['error_message'] = "Pengguna tidak ditemukan.";
        header("Location: kelola_pengguna.php");
        exit();
    }

    $pengguna = $result->fetch_assoc();
    $stmt->close();

    if (isset($_POST['update_pengguna'])) {
        $nama = $_POST['nama'];
        $email = $_POST['email'];
        $role = $_POST['role'];

        $stmt_update = $conn->prepare("UPDATE pengguna SET nama = ?, email = ?, role = ? WHERE id_pengguna = ?");
        $stmt_update->bind_param("sssi", $nama, $email, $role, $id_pengguna);

        if ($stmt_update->execute()) {
            $_SESSION['success_message'] = "Data pengguna berhasil diperbarui.";
            header("Location: kelola_pengguna.php");
            exit();
        } else {
            $_SESSION['error_message'] = "Gagal memperbarui data pengguna: " . $stmt_update->error;
        }

        $stmt_update->close();
    }

    include_once('../template.php');
?>

    <div class="container">

        <div class="row mt-2 d-flex justify-content-center">
            <div class="display-4 text-center mb-2">
                Edit Data Pengguna
            </div>
            <div class="col-md-11">
                <div class="card mb-2">
                    <div class="card-header">
                        <div class="display-6">Form Edit Data Pengguna</div>
                    </div>
                    <div class="card-body">

                        <?php if (isset($_SESSION['error_message'])): ?>
                            <p class="error"><?php echo $_SESSION['error_message']; ?></p>
                            <?php unset($_SESSION['error_message']); ?>
                        <?php endif; ?>

                        <form method="post">
                            <div class="form-group">
                                <label for="nama">Nama:</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $pengguna['nama']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $pengguna['email']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="role">Role:</label>
                                <select class="form-control" id="role" name="role" required>
                                    <option value="user" <?php if ($pengguna['role'] === 'user') echo 'selected'; ?>>Pengguna Biasa</option>
                                    <option value="admin" <?php if ($pengguna['role'] === 'admin') echo 'selected'; ?>>Administrator</option>
                                </select>
                            </div>
                            <button type="submit" name="update_pengguna" class="btn btn-primary">Simpan</button>
                            <a href="kelola_pengguna.php" class="btn btn-secondary">Batal</a>
                        </form>
                    </div>

                <?php
            } else {
                header("Location: kelola_pengguna.php");
                exit();
            }
                ?>
                </div>
            </div>
        </div>
    </div>