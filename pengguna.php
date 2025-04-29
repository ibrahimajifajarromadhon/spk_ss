<?php
require_once('functions.php');

session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['pengguna_id'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit();
}

$kandungan = query("SELECT
    ks.id_kandungan ,
    ks.nama AS nama,
    jk.nilai AS nilai_jk,
    mk.nilai AS nilai_mk,
    al.nilai AS nilai_al,
    ak.nilai AS nilai_ak
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

$pengguna_id = $_SESSION['pengguna_id'];

$pengguna = query("SELECT
        p.id_preferensi,
        u.nama,
        jk.nama AS nama_jk,
        mk.nama AS nama_mk,
        al.nama AS nama_al,
        ak.nama AS nama_ak,
        jk.nilai AS nilai_jk,
        mk.nilai AS nilai_mk,
        al.nilai AS nilai_al,
        ak.nilai AS nilai_ak
    FROM
        preferensi_pengguna p
    INNER JOIN
        sub_kriteria jk ON p.profil_jenis_kulit = jk.id_sub_kriteria
    INNER JOIN
        sub_kriteria mk ON p.profil_masalah_kulit = mk.id_sub_kriteria
    INNER JOIN
        sub_kriteria al ON p.profil_reaksi_alergi = al.id_sub_kriteria
    INNER JOIN
        sub_kriteria ak ON p.profil_aktivitas_pengguna = ak.id_sub_kriteria
    INNER JOIN
        pengguna u ON p.id_pengguna = u.id_pengguna
    WHERE
        p.id_pengguna = $pengguna_id");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pengguna</title>
    <!-- bootstrap 4 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.0/css/all.min.css">
    <!-- my css -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <?php
    include_once('template.php');
    ?>

    <div class="container">
        <div class="display-4 text-center mb-2">
            Data Profil Pengguna
        </div>
        <div class="row mt-2 mb-5">
            <div class="col-md-11 mx-auto">

                <!-- button modal box - tambah kriteria -->
                <a href="pengguna_tambah.php" class="btn btn-primary btn-block mb-2">
                    <i class="fa fa-plus"></i> Tambah Profil Pengguna
                </a>

                <div class="card">
                    <div class="card-header badge-info">
                        <div class="display-6">Tabel Profil Pengguna</div>
                    </div>
                    <div class="card-body pb-0 mb-0">
                        <?php if (!empty($pengguna)) : ?>
                            <table class="table table-hover table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Profil Jenis Kulit</th>
                                        <th>Profil Masalah Kulit</th>
                                        <th>Profil Reaksi Alergi</th>
                                        <th>Profil Aktivitas Pengguna</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($pengguna as $p) : ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td><?= $p['nama']; ?></td>
                                            <td><?= $p['nama_jk']; ?></td>
                                            <td><?= $p['nama_mk']; ?></td>
                                            <td><?= $p['nama_al']; ?></td>
                                            <td><?= $p['nama_ak']; ?></td>
                                        </tr>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else : ?>
                            <p class="text-center">Data profil pengguna belum tersedia. Silahkan tambah profil anda.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <hr>

            </div>

            <div class="col-md-11 mx-auto">
                <div class="card">
                    <div class="card-header badge-info">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="display-6">Tabel Nilai Kandungan</div>
                            </div>
                            <div class="col-md-6 ">
                                <button type="button" data-toggle="modal" data-target="#modalKet" class="btn btn-sm btn-info float-right">Keterangan</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pb-2 mb-0">
                        <form action="" method="post">
                            <table class="table table-hover table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>Nama Kandungan</th>
                                        <th>Jenis Kulit</th>
                                        <th>Masalah Kulit</th>
                                        <th>Reaksi Alergi</th>
                                        <th>Aktivitas Pengguna</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($kandungan as $data) : ?>
                                        <tr>
                                            <td><?= $data['nama']; ?></td>
                                            <td><?= $data['nilai_jk']; ?></td>
                                            <td><?= $data['nilai_mk']; ?></td>
                                            <td><?= $data['nilai_al']; ?></td>
                                            <td><?= $data['nilai_ak']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr class="badge-info">
                                        <?php if (!empty($pengguna)) : ?>
                                            <?php foreach ($pengguna as $p) : ?>
                                                <td>Nilai Profil <?= $p['nama']; ?></td>
                                                <td><?= $p['nilai_jk']; ?></td>
                                                <td><?= $p['nilai_mk']; ?></td>
                                                <td><?= $p['nilai_al']; ?></td>
                                                <td><?= $p['nilai_ak']; ?></td>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <td colspan="5">Data profil pengguna belum tersedia. Silahkan tambah profil anda.</td>
                                        <?php endif; ?>
                                    </tr>
                                </tfoot>
                            </table>

                    </div>
                </div>
            </div>

            <div class="col-md-11 mx-auto">

                <button type="submit" name="hasil" class="btn btn-primary btn-block mt-2">Hitung</button>
                </form>

                <hr>

                <?php if (isset($_POST['hasil'])) : ?>

                    <!-- table pemetaan gap -->
                    <div class="card">
                        <div class="card-header badge-info">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="display-6">Tabel Pemetaan GAP</div>
                                </div>
                                <div class="col-md-6 ">
                                    <button type="button" data-toggle="modal" data-target="#modalBobot" class="btn btn-sm btn-info float-right">Keterangan Bobot Penilaian</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pb-2 mb-0">
                            <form action="peringkat.php" method="post">
                                <table class="table table-hover table-striped text-center">
                                    <thead>
                                        <tr>
                                            <th>Nama Kandungan</th>
                                            <th>Bobot Jenis Kulit</th>
                                            <th>Bobot Masalah Kulit</th>
                                            <th>Bobot Reaksi Alergi</th>
                                            <th>Bobot Aktivitas Pengguna</th>
                                            <th>NCF</th>
                                            <th>NSF</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        <?php foreach ($kandungan as $data) : ?>
                                            <?php
                                            $data_pengguna = $pengguna[0]; // Ambil baris pertama dari tabel pengguna

                                            // nilai kandungan dikurangi nilai profil pengguna
                                            $bobot_jk = $data_pengguna['nilai_jk'] - $data['nilai_jk'];
                                            $bobot_mk = $data_pengguna['nilai_mk'] - $data['nilai_mk'];
                                            $bobot_al = $data_pengguna['nilai_al'] - $data['nilai_al'];
                                            $bobot_ak = $data_pengguna['nilai_ak'] - $data['nilai_ak'];

                                            // pembobotan (note: buat tabel baru di database)
                                            // bobot = [0, 1, -1, 2, -2, 3, -3, 4, -4];
                                            // cek selisih > Set nilai bobot
                                            switch ($bobot_jk) {
                                                case 0:
                                                    $jk_bobot = 5;
                                                    break;
                                                case 1:
                                                    $jk_bobot = 4.5;
                                                    break;
                                                case -1:
                                                    $jk_bobot = 4;
                                                    break;
                                                case 2:
                                                    $jk_bobot = 3.5;
                                                    break;
                                                case -2:
                                                    $jk_bobot = 3;
                                                    break;
                                                case 3:
                                                    $jk_bobot = 2.5;
                                                    break;
                                                case -3:
                                                    $jk_bobot = 2;
                                                    break;
                                                case 4:
                                                    $jk_bobot = 1.5;
                                                    break;
                                                case -4:
                                                    $jk_bobot = 1;
                                                    break;
                                            }
                                            switch ($bobot_mk) {
                                                case 0:
                                                    $mk_bobot = 5;
                                                    break;
                                                case 1:
                                                    $mk_bobot = 4.5;
                                                    break;
                                                case -1:
                                                    $mk_bobot = 4;
                                                    break;
                                                case 2:
                                                    $mk_bobot = 3.5;
                                                    break;
                                                case -2:
                                                    $mk_bobot = 3;
                                                    break;
                                                case 3:
                                                    $mk_bobot = 2.5;
                                                    break;
                                                case -3:
                                                    $mk_bobot = 2;
                                                    break;
                                                case 4:
                                                    $mk_bobot = 1.5;
                                                    break;
                                                case -4:
                                                    $mk_bobot = 1;
                                                    break;
                                            }
                                            switch ($bobot_al) {
                                                case 0:
                                                    $al_bobot = 5;
                                                    break;
                                                case 1:
                                                    $al_bobot = 4.5;
                                                    break;
                                                case -1:
                                                    $al_bobot = 4;
                                                    break;
                                                case 2:
                                                    $al_bobot = 3.5;
                                                    break;
                                                case -2:
                                                    $al_bobot = 3;
                                                    break;
                                                case 3:
                                                    $al_bobot = 2.5;
                                                    break;
                                                case -3:
                                                    $al_bobot = 2;
                                                    break;
                                                case 4:
                                                    $al_bobot = 1.5;
                                                    break;
                                                case -4:
                                                    $al_bobot = 1;
                                                    break;
                                            }
                                            switch ($bobot_ak) {
                                                case 0:
                                                    $ak_bobot = 5;
                                                    break;
                                                case 1:
                                                    $ak_bobot = 4.5;
                                                    break;
                                                case -1:
                                                    $ak_bobot = 4;
                                                    break;
                                                case 2:
                                                    $ak_bobot = 3.5;
                                                    break;
                                                case -2:
                                                    $ak_bobot = 3;
                                                    break;
                                                case 3:
                                                    $ak_bobot = 2.5;
                                                    break;
                                                case -3:
                                                    $ak_bobot = 2;
                                                    break;
                                                case 4:
                                                    $ak_bobot = 1.5;
                                                    break;
                                                case -4:
                                                    $ak_bobot = 1;
                                                    break;
                                            }

                                            // nilai rata-rata untuk core dan secondary factor
                                            $ncf = ($mk_bobot + $jk_bobot) / 2;
                                            $nsf = ($al_bobot + $ak_bobot) / 2;
                                            $total = 0.7 * $ncf + 0.3 * $nsf;
                                            ?>
                                            <tr>
                                                <td><?= $data['nama']; ?></td>
                                                <td><?= $bobot_jk; ?></td>
                                                <td><?= $bobot_mk; ?></td>
                                                <td><?= $bobot_al; ?></td>
                                                <td><?= $bobot_ak; ?></td>
                                                <td><?= $ncf; ?></td>
                                                <td><?= $nsf; ?></td>
                                                <td><?= $total; ?></td>
                                            </tr>
                                            <input type="hidden" name="kandungan<?= $i; ?>" value="<?= $data['id_kandungan']; ?>">
                                            <input type="hidden" name="total<?= $i; ?>" value="<?= $total; ?>">
                                            <?php $i++; ?>
                                        <?php endforeach; ?>
                                        <input type="hidden" name="jmlData" value="<?= count($kandungan) ?>">
                                    </tbody>
                                </table>

                                <!-- rangking page -->
                                <button type="submit" name="ranking" class="btn btn-primary btn-block mt-2">Cek Peringkat</button>
                            </form>
                        </div>
                    </div>


                <?php endif; ?>

            </div>

        </div>

    </div>

    <!-- Modal Keterangan -->
    <div class="modal fade" id="modalKet" tabindex="-1" role="dialog" aria-labelledby="modalKetTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header badge-info">
                    <h5 class="modal-title" id="modalKetTitle">Keterangan Nilai Kandungan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php
                    $kriteria = query("SELECT k.nama FROM kriteria k LEFT JOIN sub_kriteria sk ON k.id_kriteria = sk.kriteria_id");
                    $sub = query("SELECT * FROM sub_kriteria ORDER BY id_sub_kriteria ASC");
                    ?>
                    <table class="table table-striped">
                        <thead>
                            <th width="30%">Kriteria</th>
                            <th width="60%">Sub-Kriteria</th>
                            <th>Nilai</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <table>
                                        <?php foreach ($kriteria as $k) : ?>
                                            <tr>
                                                <td><?= $k['nama']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>
                                </td>
                                <hr>
                                <td>
                                    <table class="table-striped">
                                        <?php foreach ($sub as $sk) : ?>
                                            <tr>
                                                <td><?= $sk['nama']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>
                                </td>
                                <hr>
                                <td>
                                    <table class="table-striped">
                                        <?php foreach ($sub as $sk) : ?>
                                            <tr>
                                                <td><?= $sk['nilai']; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Keterangan Bobot Nilai -->
    <div class="modal fade" id="modalBobot" tabindex="-1" role="dialog" aria-labelledby="modalBobotTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header badge-info">
                    <h5 class="modal-title" id="modalBobotTitle">Keterangan Bobot Penilaian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php
                    $pembobotan = query("SELECT * FROM pembobotan");
                    ?>
                    <table class="table table-striped">
                        <thead>
                            <th>#</th>
                            <th>Selisih</th>
                            <th>Bobot Nilai</th>
                            <th>Keterangan</th>
                        </thead>
                        <tbody>
                            <?php foreach ($pembobotan as $p) : ?>
                                <tr>
                                    <td>#</td>
                                    <td><?= $p['selisih']; ?></td>
                                    <td><?= $p['bobot']; ?></td>
                                    <td><?= $p['ket']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha512-bnIvzh6FU75ZKxp0GXLH9bewza/OIw6dLVh9ICg0gogclmYGguQJWl8U30WpbsGTqbIiAwxTsbe76DErLq5EDQ==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.5.4/umd/popper.min.js" integrity="sha512-7yA/d79yIhHPvcrSiB8S/7TyX0OxlccU8F/kuB8mHYjLlF1MInPbEohpoqfz0AILoq5hoD7lELZAYYHbyeEjag==" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

</body>

</html>