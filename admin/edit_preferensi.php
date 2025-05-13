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

if (isset($_GET['id'])) {
    $id_edit = $_GET['id'];
    if (is_numeric($id_edit)) {
        $stmt_select = $conn->prepare("SELECT * FROM preferensi_pengguna WHERE id_preferensi = ?");
        $stmt_select->bind_param("i", $id_edit);
        $stmt_select->execute();
        $result_select = $stmt_select->get_result();
        $preferensi_edit = $result_select->fetch_assoc();
        $stmt_select->close();

        if (!$preferensi_edit) {
            $_SESSION['error_message'] = "Data preferensi pengguna tidak ditemukan.";
            header("Location: kelola_preferensi.php");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "ID preferensi tidak valid.";
        header("Location: kelola_preferensi.php");
        exit();
    }
} else {
    header("Location: kelola_preferensi.php");
    exit();
}

if (isset($_POST['edit_preferensi'])) {
    $id_preferensi = $_POST['id_preferensi'];
    $id_pengguna = $_POST['id_pengguna'];
    $profil_jenis_kulit = $_POST['profil_jenis_kulit'];
    $profil_masalah_kulit = $_POST['profil_masalah_kulit'];
    $profil_reaksi_alergi = $_POST['profil_reaksi_alergi'];
    $profil_aktivitas_pengguna = $_POST['profil_aktivitas_pengguna'];

    $stmt_update = $conn->prepare("UPDATE preferensi_pengguna SET id_pengguna = ?, profil_jenis_kulit = ?, profil_masalah_kulit = ?, profil_reaksi_alergi = ?, profil_aktivitas_pengguna = ? WHERE id_preferensi = ?");
    $stmt_update->bind_param("iiiiii", $id_pengguna, $profil_jenis_kulit, $profil_masalah_kulit, $profil_reaksi_alergi, $profil_aktivitas_pengguna, $id_preferensi);

    if ($stmt_update->execute()) {
        $_SESSION['success_message'] = "Data preferensi pengguna berhasil diperbarui.";
    } else {
        $_SESSION['error_message'] = "Gagal memperbarui data preferensi pengguna: " . $stmt_update->error;
    }
    $stmt_update->close();
    header("Location: kelola_preferensi.php");
    exit();
}

include_once('../template.php');
?>

<div class="container">

    <div class="row mt-2 d-flex justify-content-center">
        <div class="display-4 text-center mb-2">
            Edit Data Preferensi Pengguna
        </div>
        <div class="col-md-11">
            <div class="card mb-2">
                <div class="card-header">
                    <div class="display-6">Form Edit Data Preferensi Pengguna</div>
                </div>
                <div class="card-body">

                    <?php if (isset($_SESSION['error_message'])): ?>
                        <p class="error"><?php echo $_SESSION['error_message']; ?></p>
                        <?php unset($_SESSION['error_message']); ?>
                    <?php endif; ?>

                    <form method="post">
                        <input type="hidden" name="id_preferensi" value="<?php echo $preferensi_edit['id_preferensi']; ?>">
                        <div class="form-group">
                            <label for="id_pengguna">Nama Pengguna:</label>
                            <select class="form-control" id="id_pengguna" name="id_pengguna" required>
                                <option value="">Pilih Pengguna</option>
                                <?php foreach ($daftar_pengguna as $pengguna): ?>
                                    <option value="<?= $pengguna['id_pengguna']; ?>" <?= ($pengguna['id_pengguna'] == $preferensi_edit['id_pengguna']) ? 'selected' : ''; ?>>
                                        <?= $pengguna['nama']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <?php foreach ($kriteria as $k): ?>
                            <?php
                            $kriteria_field_name = 'profil_' . strtolower(str_replace(' ', '_', $k['nama']));
                            $selected_value = $preferensi_edit[$kriteria_field_name];
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
                        <button type="submit" name="edit_preferensi" class="btn btn-success">Simpan Perubahan</button>
                        <a href="kelola_preferensi.php" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>