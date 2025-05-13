<?php
session_start();

if (!isset($_SESSION['pengguna_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

require_once '../functions.php';

// Ambil semua data preferensi pengguna
$stmt = $conn->prepare("SELECT pp.id_preferensi, p.nama AS nama_pengguna,
                               sk_jenis.nama AS jenis_kulit,
                               sk_masalah.nama AS masalah_kulit,
                               sk_alergi.nama AS reaksi_alergi,
                               sk_aktivitas.nama AS aktivitas_pengguna
                        FROM preferensi_pengguna pp
                        JOIN pengguna p ON pp.id_pengguna = p.id_pengguna
                        LEFT JOIN sub_kriteria sk_jenis ON pp.profil_jenis_kulit = sk_jenis.id_sub_kriteria
                        LEFT JOIN sub_kriteria sk_masalah ON pp.profil_masalah_kulit = sk_masalah.id_sub_kriteria
                        LEFT JOIN sub_kriteria sk_alergi ON pp.profil_reaksi_alergi = sk_alergi.id_sub_kriteria
                        LEFT JOIN sub_kriteria sk_aktivitas ON pp.profil_aktivitas_pengguna = sk_aktivitas.id_sub_kriteria");
$stmt->execute();
$result = $stmt->get_result();
$daftar_preferensi = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

include_once('../template.php');
?>

<div class="container">
    <div class="display-4 text-center mb-2">
        Data Preferensi Pengguna
    </div>
    <div class="row mt-2 mb-5">
        <div class="col-md-11 mx-auto">
            <div class="mb-3">
                <a href="tambah_preferensi.php" class="btn btn-success btn-block"><i class="fa fa-plus"></i> Tambah Preferensi Pengguna</a>
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

            <div class="card">
                <div class="card-header badge-info">
                    <div class="display-6">Tabel Preferensi Pengguna</div>
                </div>
                <div class="card-body pb-0 mb-0">
                    <table class="table table-hover table-striped text-center">
                        <thead>
                            <tr>
                                <th width="15%">Nama Pengguna</th>
                                <th width="15%">Jenis Kulit</th>
                                <th>Masalah Kulit</th>
                                <th>Reaksi Alergi</th>
                                <th>Aktivitas Pengguna</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($daftar_preferensi)): ?>
                                <tr>
                                    <td colspan="8">Tidak ada data preferensi pengguna.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($daftar_preferensi as $preferensi): ?>
                                    <tr>
                                        <td><?php echo $preferensi['nama_pengguna']; ?></td>
                                        <td><?php echo $preferensi['jenis_kulit']; ?></td>
                                        <td><?php echo $preferensi['masalah_kulit']; ?></td>
                                        <td><?php echo $preferensi['reaksi_alergi']; ?></td>
                                        <td><?php echo $preferensi['aktivitas_pengguna']; ?></td>
                                        <td>
                                            <a href="edit_preferensi.php?id=<?php echo $preferensi['id_preferensi']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                            <a href="hapus_preferensi.php?id=<?php echo $preferensi['id_preferensi']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus preferensi pengguna ini?')">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>