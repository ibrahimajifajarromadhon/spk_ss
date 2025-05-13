<?php
session_start();

if (!isset($_SESSION['pengguna_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

require_once '../functions.php';

// Ambil data kriteria
$kriteria_query = mysqli_query($conn, "SELECT * FROM kriteria ORDER BY id_kriteria ASC");
$kriteria = mysqli_fetch_all($kriteria_query, MYSQLI_ASSOC);

if (isset($_POST['tambah_kandungan'])) {
    $nama = $_POST['nama'];
    $kriteria_jenis_kulit = $_POST['kriteria_jenis_kulit'];
    $kriteria_masalah_kulit = $_POST['kriteria_masalah_kulit'];
    $kriteria_reaksi_alergi = $_POST['kriteria_reaksi_alergi'];
    $kriteria_aktivitas_pengguna = $_POST['kriteria_aktivitas_pengguna'];

    $stmt_insert = $conn->prepare("INSERT INTO kandungan_sunscreen (nama, kriteria_jenis_kulit, kriteria_masalah_kulit, kriteria_reaksi_alergi, kriteria_aktivitas_pengguna) VALUES (?, ?, ?, ?, ?)");
    $stmt_insert->bind_param("siiii", $nama, $kriteria_jenis_kulit, $kriteria_masalah_kulit, $kriteria_reaksi_alergi, $kriteria_aktivitas_pengguna);

    if ($stmt_insert->execute()) {
        $_SESSION['success_message'] = "Kandungan baru berhasil ditambahkan.";
        header("Location: kelola_kandungan.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Gagal menambahkan kandungan: " . $stmt_insert->error;
    }
    $stmt_insert->close();
}

include_once('../template.php');
?>

<div class="container">

    <div class="row mt-2 d-flex justify-content-center">
        <div class="display-4 text-center mb-2">
            Tambah Data Kandungan
        </div>
        <div class="col-md-11">
            <div class="card mb-2">
                <div class="card-header">
                    <div class="display-6">Form Tambah Data Kandungan</div>
                </div>
                <div class="card-body">

                    <?php if (isset($_SESSION['error_message'])): ?>
                        <p class="error"><?php echo $_SESSION['error_message']; ?></p>
                        <?php unset($_SESSION['error_message']); ?>
                    <?php endif; ?>

                    <form method="post">
                        <div class="form-group">
                            <label for="nama">Nama Kandungan:</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama kandungan" required>
                        </div>
                        <?php foreach ($kriteria as $k): ?>
                            <div class="form-group">
                                <label for="kriteria_<?= strtolower(str_replace(' ', '_', $k['nama'])); ?>"><?= $k['nama']; ?>:</label>
                                <select class="form-control" id="kriteria_<?= strtolower(str_replace(' ', '_', $k['nama'])); ?>" name="kriteria_<?= strtolower(str_replace(' ', '_', $k['nama'])); ?>" required>
                                    <option value="">Pilih <?= strtolower($k['nama']); ?></option>
                                    <?php
                                    $id_kriteria = $k['id_kriteria'];
                                    $sub_kriteria_query = mysqli_query($conn, "SELECT * FROM sub_kriteria WHERE kriteria_id = '$id_kriteria' ORDER BY nama ASC");
                                    while ($sub_kriteria = mysqli_fetch_assoc($sub_kriteria_query)):
                                    ?>
                                        <option value="<?= $sub_kriteria['id_sub_kriteria']; ?>"><?= $sub_kriteria['nama']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        <?php endforeach; ?>
                        <button type="submit" name="tambah_kandungan" class="btn btn-success"><i class="fa fa-plus"></i> Tambah Data</button>
                        <a href="kelola_kandungan.php" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>