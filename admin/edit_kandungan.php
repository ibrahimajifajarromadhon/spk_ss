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

if (isset($_GET['id'])) {
    $id_edit = $_GET['id'];
    if (is_numeric($id_edit)) {
        $stmt_select = $conn->prepare("SELECT id_kandungan, nama, kriteria_jenis_kulit, kriteria_masalah_kulit, kriteria_reaksi_alergi, kriteria_aktivitas_pengguna FROM kandungan_sunscreen WHERE id_kandungan = ?");
        $stmt_select->bind_param("i", $id_edit);
        $stmt_select->execute();
        $result_select = $stmt_select->get_result();
        $kandungan_edit = $result_select->fetch_assoc();
        $stmt_select->close();

        if (!$kandungan_edit) {
            $_SESSION['error_message'] = "Data kandungan tidak ditemukan.";
            header("Location: kelola_kandungan.php");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "ID kandungan tidak valid.";
        header("Location: kelola_kandungan.php");
        exit();
    }
} else {
    header("Location: kelola_kandungan.php");
    exit();
}

if (isset($_POST['edit_kandungan'])) {
    $id_kandungan = $_POST['id_kandungan'];
    $nama = $_POST['nama'];
    $kriteria_jenis_kulit = $_POST['kriteria_jenis_kulit'];
    $kriteria_masalah_kulit = $_POST['kriteria_masalah_kulit'];
    $kriteria_reaksi_alergi = $_POST['kriteria_reaksi_alergi'];
    $kriteria_aktivitas_pengguna = $_POST['kriteria_aktivitas_pengguna'];

    $stmt_update = $conn->prepare("UPDATE kandungan_sunscreen SET nama = ?, kriteria_jenis_kulit = ?, kriteria_masalah_kulit = ?, kriteria_reaksi_alergi = ?, kriteria_aktivitas_pengguna = ? WHERE id_kandungan = ?");
    $stmt_update->bind_param("siiiii", $nama, $kriteria_jenis_kulit, $kriteria_masalah_kulit, $kriteria_reaksi_alergi, $kriteria_aktivitas_pengguna, $id_kandungan);

    if ($stmt_update->execute()) {
        $_SESSION['success_message'] = "Data kandungan berhasil diperbarui.";
    } else {
        $_SESSION['error_message'] = "Gagal memperbarui data kandungan: " . $stmt_update->error;
    }
    $stmt_update->close();
    header("Location: kelola_kandungan.php");
    exit();
}

include_once('../template.php');
?>
<div class="container">

    <div class="row mt-2 d-flex justify-content-center">
        <div class="display-4 text-center mb-2">
            Edit Data Kandungan
        </div>
        <div class="col-md-11">
            <div class="card mb-2">
                <div class="card-header">
                    <div class="display-6">Form Edit Data Kandungan</div>
                </div>
                <div class="card-body">

                    <?php if (isset($_SESSION['error_message'])): ?>
                        <p class="error"><?php echo $_SESSION['error_message']; ?></p>
                        <?php unset($_SESSION['error_message']); ?>
                    <?php endif; ?>

                    <form method="post">
                        <input type="hidden" name="id_kandungan" value="<?php echo $kandungan_edit['id_kandungan']; ?>">
                        <div class="form-group">
                            <label for="nama">Nama Kandungan:</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $kandungan_edit['nama']; ?>" required>
                        </div>
                        <?php foreach ($kriteria as $k): ?>
                            <?php
                            $kriteria_field_name = 'kriteria_' . strtolower(str_replace(' ', '_', $k['nama']));
                            $selected_value = $kandungan_edit[$kriteria_field_name];
                            ?>
                            <div class="form-group">
                                <label for="<?= $kriteria_field_name ?>"><?= $k['nama']; ?>:</label>
                                <select class="form-control" id="<?= $kriteria_field_name ?>" name="<?= $kriteria_field_name ?>" required>
                                    <option value="">Pilih <?= strtolower($k['nama']); ?></option>
                                    <?php
                                    $id_kriteria = $k['id_kriteria'];
                                    $sub_kriteria_query = mysqli_query($conn, "SELECT * FROM sub_kriteria WHERE kriteria_id = '$id_kriteria' ORDER BY nama ASC");
                                    while ($sub_kriteria = mysqli_fetch_assoc($sub_kriteria_query)):
                                    ?>
                                        <option value="<?= $sub_kriteria['id_sub_kriteria']; ?>" <?= ($sub_kriteria['id_sub_kriteria'] == $selected_value) ? 'selected' : ''; ?>>
                                            <?= $sub_kriteria['nama']; ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        <?php endforeach; ?>
                        <button type="submit" name="edit_kandungan" class="btn btn-success">Simpan Perubahan</button>
                        <a href="kelola_kandungan.php" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>