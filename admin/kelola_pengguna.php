<?php
session_start();

if (!isset($_SESSION['pengguna_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

require_once '../functions.php';

// Ambil data pengguna dengan role admin
$query_admin = "SELECT id_pengguna, nama, email, role FROM pengguna WHERE role = 'admin'";
$result_admin = $conn->query($query_admin);

if (!$result_admin) {
    die("Error fetching admin users: " . $conn->error);
}

// Ambil data pengguna selain role admin
$query_user = "SELECT id_pengguna, nama, email, role FROM pengguna WHERE role != 'admin'";
$result_user = $conn->query($query_user);

if (!$result_user) {
    die("Error fetching non-admin users: " . $conn->error);
}

?>

<?php
include_once('../template.php');
?>
<div class="container">
    <div class="display-4 text-center mb-2">
        Data Pengguna
    </div>
    <div class="row mt-2 mb-5">
        <div class="col-md-11 mx-auto">
            <div class="mb-3">
                <a href="tambah_pengguna.php" class="btn btn-success btn-block"><i class="fa fa-plus"></i> Tambah Pengguna</a>
            </div>
            <?php
            if (isset($_SESSION['error_message'])): ?>
                <p class="error"><?php echo $_SESSION['error_message']; ?></p>
                <?php unset($_SESSION['error_message']);
                ?>
            <?php endif; ?>
            <?php
            if (isset($_SESSION['success_message'])): ?>
                <p class="success"><?php echo $_SESSION['success_message']; ?></p>
                <?php unset($_SESSION['success_message']);
                ?>
            <?php endif; ?>

            <?php if ($result_admin->num_rows > 0): ?>
                <div class="card mb-4">
                    <div class="card-header badge-warning text-white">
                        <div class="display-6">Tabel Admin</div>
                    </div>
                    <div class="card-body pb-0 mb-0">
                        <table class="table table-hover table-striped text-center">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no_admin = 1; ?>
                                <?php while ($row_admin = $result_admin->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $no_admin++; ?></td>
                                        <td><?php echo $row_admin['nama']; ?></td>
                                        <td><?php echo $row_admin['email']; ?></td>
                                        <td><?php echo $row_admin['role']; ?></td>
                                        <td>
                                            <a href="edit_pengguna.php?id=<?php echo $row_admin['id_pengguna']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                            <a href="hapus_pengguna.php?id=<?php echo $row_admin['id_pengguna']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php else: ?>
                <p>Tidak ada pengguna dengan role Admin.</p>
            <?php endif; ?>

            <?php if ($result_user->num_rows > 0): ?>
                <div class="card">
                    <div class="card-header badge-info">
                        <div class="display-6">Tabel Pengguna Biasa</div>
                    </div>
                    <div class="card-body pb-0 mb-0">
                        <table class="table table-hover table-striped text-center">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no_user = 1; ?>
                                <?php while ($row_user = $result_user->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $no_user++; ?></td>
                                        <td><?php echo $row_user['nama']; ?></td>
                                        <td><?php echo $row_user['email']; ?></td>
                                        <td><?php echo $row_user['role']; ?></td>
                                        <td>
                                            <a href="edit_pengguna.php?id=<?php echo $row_user['id_pengguna']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                            <a href="hapus_pengguna.php?id=<?php echo $row_user['id_pengguna']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php else: ?>
                <p>Tidak ada pengguna selain Admin.</p>
            <?php endif; ?>

        </div>
    </div>
</div>