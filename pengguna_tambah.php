<?php
session_start();
require_once('functions.php');

// Asumsi Anda menyimpan ID pengguna yang login di $_SESSION['user_id']
if (!isset($_SESSION['pengguna_id'])) {
    // Jika pengguna belum login, redirect ke halaman login atau tampilkan pesan error
    header("Location: login.php"); // Ganti dengan halaman login Anda
    exit();
}


if (isset($_POST['tambahPengguna'])) {
    if (tambahPengguna($_POST) > 0) {
        echo "<script>
            alert('data berhasil ditambahkan!');
            document.location.href='pengguna.php';
        </script>";
    } else {
        echo "<script>
            alert('data gagal ditambahkan!');
            document.location.href='pengguna.php';
        </script>";
    }
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
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <?php
    include_once('template.php');
    ?>

    <div class="container">

        <div class="row mt-2 d-flex justify-content-center">
            <div class="display-4 text-center mb-2">
                Tambah Data Profil Pengguna
            </div>
            <div class="col-md-11">

                <!-- jika tombol tambah di klik -> mengirimkan dala lewat method post -->
                <?php
                // maka tangkap
                $kriteria = query("SELECT * FROM kriteria ORDER BY id_kriteria ASC");
                $sub_kriteria = query("SELECT * FROM sub_kriteria ORDER BY id_sub_kriteria ASC");
                ?>

                <form action="" method="post">

                    <div class="card mb-2">
                        <div class="card-header">
                            <div class="display-6">Form Tambah Data Profil Pengguna</div>
                        </div>
                        <div class="card-body">

                            <div class="form-group">
                                <label for="jenis_kulit"><?= $kriteria[0]['nama']; ?></label>
                                <select name="jenis_kulit" id="jenis_kulit" class="form-control" required>
                                    <option value="">Pilih <?= strtolower($kriteria[0]['nama']); ?></option>
                                    <?php
                                    $id_kriteria = $kriteria[0]['id_kriteria'];
                                    $query_sub_kriteria = mysqli_query($conn, "SELECT * FROM sub_kriteria WHERE kriteria_id = '$id_kriteria'");

                                    if (mysqli_num_rows($query_sub_kriteria) > 0) {
                                        while ($row_sub_kriteria = mysqli_fetch_assoc($query_sub_kriteria)) {
                                    ?>
                                            <option value="<?= $row_sub_kriteria['id_sub_kriteria']; ?>">
                                                <?= $row_sub_kriteria['nama']; ?>
                                            </option>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <option value="" disabled>Tidak ada pilihan <?= strtolower($kriteria[0]['nama']); ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="masalah_kulit"><?= $kriteria[1]['nama']; ?></label>
                                <select name="masalah_kulit" id="masalah_kulit" class="form-control" required>
                                    <option value="">Pilih <?= strtolower($kriteria[1]['nama']); ?></option>
                                    <?php
                                    $id_kriteria = $kriteria[1]['id_kriteria'];
                                    $query_sub_kriteria = mysqli_query($conn, "SELECT * FROM sub_kriteria WHERE kriteria_id = '$id_kriteria'");

                                    if (mysqli_num_rows($query_sub_kriteria) > 0) {
                                        while ($row_sub_kriteria = mysqli_fetch_assoc($query_sub_kriteria)) {
                                    ?>
                                            <option value="<?= $row_sub_kriteria['id_sub_kriteria']; ?>">
                                                <?= $row_sub_kriteria['nama']; ?>
                                            </option>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <option value="" disabled>Tidak ada pilihan <?= strtolower($kriteria[1]['nama']); ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="reaksi_alergi"><?= $kriteria[2]['nama']; ?></label>
                                <select name="reaksi_alergi" id="reaksi_alergi" class="form-control" required>
                                    <option value="">Pilih <?= strtolower($kriteria[2]['nama']); ?></option>
                                    <?php
                                    $id_kriteria = $kriteria[2]['id_kriteria'];
                                    $query_sub_kriteria = mysqli_query($conn, "SELECT * FROM sub_kriteria WHERE kriteria_id = '$id_kriteria'");

                                    if (mysqli_num_rows($query_sub_kriteria) > 0) {
                                        while ($row_sub_kriteria = mysqli_fetch_assoc($query_sub_kriteria)) {
                                    ?>
                                            <option value="<?= $row_sub_kriteria['id_sub_kriteria']; ?>">
                                                <?= $row_sub_kriteria['nama']; ?>
                                            </option>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <option value="" disabled>Tidak ada pilihan <?= strtolower($kriteria[2]['nama']); ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="aktivitas_pengguna"><?= $kriteria[3]['nama']; ?></label>
                                <select name="aktivitas_pengguna" id="aktivitas_pengguna" class="form-control" required>
                                    <option value="">Pilih <?= strtolower($kriteria[3]['nama']); ?></option>
                                    <?php
                                    $id_kriteria = $kriteria[3]['id_kriteria'];
                                    $query_sub_kriteria = mysqli_query($conn, "SELECT * FROM sub_kriteria WHERE kriteria_id = '$id_kriteria'");

                                    if (mysqli_num_rows($query_sub_kriteria) > 0) {
                                        while ($row_sub_kriteria = mysqli_fetch_assoc($query_sub_kriteria)) {
                                    ?>
                                            <option value="<?= $row_sub_kriteria['id_sub_kriteria']; ?>">
                                                <?= $row_sub_kriteria['nama']; ?>
                                            </option>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <option value="" disabled>Tidak ada pilihan <?= strtolower($kriteria[3]['nama']); ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" name="tambahPengguna" class="btn btn-primary btn-block"><i class="fa fa-plus"></i> Tambah Data</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Javascript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha512-bnIvzh6FU75ZKxp0GXLH9bewza/OIw6dLVh9ICg0gogclmYGguQJWl8U30WpbsGTqbIiAwxTsbe76DErLq5EDQ==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.5.4/umd/popper.min.js" integrity="sha512-7yA/d79yIhHPvcrSiB8S/7TyX0OxlccU8F/kuB8mHYjLlF1MInPbEohpoqfz0AILoq5hoD7lELZAYYHbyeEjag==" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="assets/js/script.js"></script>

</body>

</html>