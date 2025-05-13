<?php
session_start();

if (!isset($_SESSION['pengguna_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include_once('../template.php');
require_once('../functions.php');

// Ambil semua data kandungan dari database
$kandungan = query("SELECT
ks.id_kandungan AS id_kandungan,
ks.nama AS nama_kandungan,
jk.nama AS nama_jk,
mk.nama AS nama_mk,
al.nama AS nama_al,
ak.nama AS nama_ak
FROM
kandungan_sunscreen ks
INNER JOIN
sub_kriteria jk ON ks.kriteria_jenis_kulit = jk.id_sub_kriteria
INNER JOIN
sub_kriteria mk ON ks.kriteria_masalah_kulit = mk.id_sub_kriteria
INNER JOIN
sub_kriteria al ON ks.kriteria_reaksi_alergi = al.id_sub_kriteria
INNER JOIN
sub_kriteria ak ON ks.kriteria_aktivitas_pengguna = ak.id_sub_kriteria");


?>

<div class="container">
    <div class="display-4 text-center mb-2">
        Data Kandungan
    </div>
    <div class="row mt-2 mb-5">
        <div class="col-md-11 mx-auto">
            <p><a href="tambah_kandungan.php" class="btn btn-success btn-block"><i class="fa fa-plus"></i> Tambah Kandungan</a></p>
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
                    <div class="display-6">Tabel Kandungan</div>
                </div>
                <div class="card-body pb-0 mb-0">
                    <table class="table table-hover table-striped text-center">
                        <thead>
                            <tr>
                                <th width="20%">Nama Kandungan</th>
                                <th width="15%">Jenis Kulit</th>
                                <th>Masalah Kulit</th>
                                <th>Reaksi Alergi</th>
                                <th>Aktivitas Pengguna</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($kandungan as $k) : ?>

                                <tr>
                                    <td><?= $k['nama_kandungan']; ?></td>
                                    <td><?= $k['nama_jk']; ?></td>
                                    <td><?= $k['nama_mk']; ?></td>
                                    <td><?= $k['nama_al']; ?></td>
                                    <td><?= $k['nama_ak']; ?></td>
                                    <td>
                                        <a href="edit_kandungan.php?id=<?= $k['id_kandungan']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                        <a href="hapus_kandungan.php?id=<?= $k['id_kandungan']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kandungan ini?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>