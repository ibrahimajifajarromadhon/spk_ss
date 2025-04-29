<?php
require_once('functions.php');

session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['pengguna_id'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit();
}

$id_pengguna_login = $_SESSION['pengguna_id']; // Gunakan nama variabel yang lebih jelas

if (isset($_POST['ranking'])) {

    $jmlData = $_POST['jmlData'];

    // Hapus data peringkat pengguna yang login sebelumnya
    mysqli_query($conn, "DELETE FROM peringkat WHERE pengguna_id = '$id_pengguna_login'");

    for ($i = 1; $i <= $jmlData; $i++) {
        $id_kandungan = $_POST['kandungan' . $i];
        $total = $_POST['total' . $i];

        // Tambah/ganti data peringkat yang baru
        mysqli_query($conn, "REPLACE INTO peringkat(id_peringkat, kandungan_id, pengguna_id, nilai_total) VALUES(NULL, $id_kandungan, $id_pengguna_login, $total)");
    }
} else {
    $empty = true;
}


// query untuk tabel peringkat => perangkingan HANYA untuk pengguna yang login
$peringkat = query("SELECT * FROM peringkat WHERE pengguna_id = '$id_pengguna_login' ORDER BY nilai_total DESC");
$query = query("SELECT * FROM kandungan_sunscreen k INNER JOIN peringkat p ON k.id_kandungan = p.kandungan_id WHERE p.pengguna_id = '$id_pengguna_login' ORDER BY nilai_total DESC");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Peringkat</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <?php
    include_once('template.php');
    ?>

    <div class="container">

        <div class="row mt-2 d-flex justify-content-center ">
            <div class="col-md-8">

                <div class="display-4 text-center mb-2">
                    Peringkat Data Kandungan
                </div>

                <?php if (isset($empty)) : ?>
                    <div class='alert alert-primary mt-2' role='alert'>
                        <div class='display-6'> Silahkan lakukan <b>perhitungan ulang</b> di halaman pengguna untuk data terbaru!</div>
                    </div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-header badge-info">
                        <div class="display-6">Tabel Peringkat</div>
                    </div>
                    <div class="card-body pb-0 mb-0">
                        <table class="table table-hover table-striped text-center">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Nilai</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php if (!empty($query)) : ?>
                                    <?php foreach ($query as $q) : ?>
                                        <tr>
                                            <td><?= $i; ?></td>
                                            <td><?= $q['nama']; ?></td>
                                            <td><?= $q['nilai_total']; ?></td>
                                        </tr>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="3">Tidak ada data peringkat untuk pengguna ini.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="alert alert-primary mt-2" role="alert">
                    <div class="display-6">
                        <?php if (!empty($query)) : ?>
                            <b><?= $query[0]["nama"]; ?></b> adalah kandungan yang berada pada urutan pertama dalam peringkat Anda.
                        <?php else : ?>
                            Tidak ada data peringkat untuk ditampilkan untuk pengguna ini.
                        <?php endif; ?>
                    </div>
                </div>

                <a href="pengguna.php" class="btn btn-warning btn-block mb-4"><i class="fa fa-backward"></i> Kembali ke halaman Pengguna</a>

            </div>
            </div>
        </div>

</body>

</html>