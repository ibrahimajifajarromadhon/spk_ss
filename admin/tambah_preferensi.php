<?php
session_start();

if (!isset($_SESSION['pengguna_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

require_once '../functions.php';

// Ambil data pengguna
$pengguna_query = mysqli_query($conn, "SELECT id_pengguna, nama FROM pengguna WHERE role != 'admin' ORDER BY nama ASC");
$daftar_pengguna = mysqli_fetch_all($pengguna_query, MYSQLI_ASSOC);

// Ambil data kriteria
$kriteria_query = mysqli_query($conn, "SELECT * FROM kriteria ORDER BY id_kriteria ASC");
$kriteria = mysqli_fetch_all($kriteria_query, MYSQLI_ASSOC);

if (isset($_POST['tambah_preferensi'])) {
    $id_pengguna = $_POST['id_pengguna'];
    $profil_jenis_kulit = $_POST['profil_jenis_kulit'];
    $profil_masalah_kulit = $_POST['profil_masalah_kulit'];
    $profil_reaksi_alergi = $_POST['profil_reaksi_alergi'];
    $profil_aktivitas_pengguna = $_POST['profil_aktivitas_pengguna'];

    // Cek apakah preferensi untuk pengguna ini sudah ada
    $stmt_cek = $conn->prepare("SELECT id_preferensi FROM preferensi_pengguna WHERE id_pengguna = ?");
    $stmt_cek->bind_param("i", $id_pengguna);
    $stmt_cek->execute();
    $result_cek = $stmt_cek->get_result();

    if ($result_cek->num_rows > 0) {
        $_SESSION['error_message'] = "Preferensi untuk pengguna ini sudah ada.";
    } else {
        // Jika belum ada, baru lakukan penambahan
        $stmt_insert = $conn->prepare("INSERT INTO preferensi_pengguna (id_pengguna, profil_jenis_kulit, profil_masalah_kulit, profil_reaksi_alergi, profil_aktivitas_pengguna) VALUES (?, ?, ?, ?, ?)");
        $stmt_insert->bind_param("iiiii", $id_pengguna, $profil_jenis_kulit, $profil_masalah_kulit, $profil_reaksi_alergi, $profil_aktivitas_pengguna);

        if ($stmt_insert->execute()) {
            $_SESSION['success_message'] = "Preferensi pengguna baru berhasil ditambahkan.";
        } else {
            $_SESSION['error_message'] = "Gagal menambahkan preferensi pengguna: " . $stmt_insert->error;
        }
        $stmt_insert->close();
    }
    $stmt_cek->close();
    header("Location: kelola_preferensi.php");
    exit();
}

include_once('../template.php');
?>

<div class="container">

    <div class="row mt-2 d-flex justify-content-center">
        <div class="display-4 text-center mb-2">
            Tambah Data Preferensi Pengguna
        </div>
        <div class="col-md-11">
            <div class="card mb-2">
                <div class="card-header">
                    <div class="display-6">Form Tambah Data Preferensi Pengguna</div>
                </div>
                <div class="card-body">

                    <?php if (isset($_SESSION['error_message'])): ?>
                        <p class="error"><?php echo $_SESSION['error_message']; ?></p>
                        <?php unset($_SESSION['error_message']); ?>
                    <?php endif; ?>

                    <form method="post">
                        <div class="form-group">
                            <label for="id_pengguna">Nama Pengguna:</label>
                            <select class="form-control" id="id_pengguna" name="id_pengguna" required>
                                <option value="">Pilih Pengguna</option>
                                <?php foreach ($daftar_pengguna as $pengguna): ?>
                                    <option value="<?= $pengguna['id_pengguna']; ?>"><?= $pengguna['nama']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <?php foreach ($kriteria as $k): ?>
                            <div class="form-group">
                                <label for="profil_<?= strtolower(str_replace(' ', '_', $k['nama'])); ?>"><?= $k['nama']; ?>:</label>
                                <select class="form-control" id="profil_<?= strtolower(str_replace(' ', '_', $k['nama'])); ?>" name="profil_<?= strtolower(str_replace(' ', '_', $k['nama'])); ?>" required>
                                    <option value="">Pilih <?= strtolower(string: $k['nama']); ?></option>
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
                        <button type="submit" name="tambah_preferensi" class="btn btn-success"><i class="fa fa-plus"></i> Tambah Data</button>
                        <a href="kelola_preferensi.php" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>