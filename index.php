<?php
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['pengguna_id'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <!-- bootstrap 4 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.0/css/all.min.css">
    <!-- my css -->
    <link rel=" stylesheet" href="assets/css/style.css">
</head>

<body>

    <!-- navbar -->
    <?php
    include_once('template.php');

    require_once('functions.php');

    $kandungan = query("SELECT
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
    $pembobotan = query("SELECT * FROM pembobotan");
    ?>

    <div class="container">

        <div class="row mt-2">
            <div class="col-md-12 justify-content-center">


                <div class="display-4 text-center">
                    Selamat Datang, di
                </div>
                <div class="display-4 text-center">
                    Aplikasi SPK - Pemilihan Kandungan Sunscreen
                </div>
                <hr>
                <div class="row mt-2">
                    <div class="col-md-11 mx-auto">
                        <p>Dibawah ini adalah tabel kandungan sunscreen yang telah ditetapkan</p>
                        <div class="card">
                            <div class="card-body pb-0">
                                <table class="table table-sm table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th class="text-left">Nama Kandungan</th>
                                            <th>Jenis Kulit</th>
                                            <th>Masalah Kulit</th>
                                            <th>Reaksi Alergi</th>
                                            <th>Aktivitas Pengguna</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($kandungan as $k) : ?>
                                            <tr>
                                                <td class="text-left"><?= $k['nama_kandungan']; ?></td>
                                                <td><?= $k['nama_jk']; ?></td>
                                                <td><?= $k['nama_mk']; ?></td>
                                                <td><?= $k['nama_al']; ?></td>
                                                <td><?= $k['nama_ak']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr>
                        <p>Dibawah ini adalah tabel pembobotan</p>
                        <div class="card">
                            <div class="card-body pb-0">
                                <table class="table table-sm table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th>Selisih</th>
                                            <th>Bobot Nilai</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($pembobotan as $p) : ?>
                                            <tr>
                                                <td><?= $p['selisih']; ?></td>
                                                <td><?= $p['bobot']; ?></td>
                                                <td><?= $p['ket']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- jumbotron -->
                        <div class="jumbotron mt-2 py-2">
                            <p class="lead">Aplikasi SPK Pemilihan Kandungan Sunscreen</p>
                            <hr class="my-2">
                            <p>Selengkapnya</p>
                            <p class="lead">
                                <a class="btn btn-primary" href="pengguna.php" role="button">Klik disini &raquo;</a>
                            </p>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>
    <!-- /. container -->

    <!-- Javascript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha512-bnIvzh6FU75ZKxp0GXLH9bewza/OIw6dLVh9ICg0gogclmYGguQJWl8U30WpbsGTqbIiAwxTsbe76DErLq5EDQ==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.5.4/umd/popper.min.js" integrity="sha512-7yA/d79yIhHPvcrSiB8S/7TyX0OxlccU8F/kuB8mHYjLlF1MInPbEohpoqfz0AILoq5hoD7lELZAYYHbyeEjag==" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="assets/js/script.js"></script>

</body>

</html>