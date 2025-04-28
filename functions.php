<?php
// koneksi
$conn = mysqli_connect('localhost', 'root', '', 'spk_ss');

// fetch data
function query($query)
{
    global $conn;

    $res = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($res)) {
        $rows[] = $row;
    }

    return $rows;
}

function tambahPengguna($data)
{
    global $conn;

    $id_pengguna = $_SESSION['pengguna_id'];
    $jenis_kulit = $_POST['jenis_kulit'];
    $masalah_kulit = $_POST['masalah_kulit'];
    $reaksi_alergi = $_POST['reaksi_alergi'];
    $aktivitas_pengguna = $_POST['aktivitas_pengguna'];

    $stmt_check = $conn->prepare("SELECT id_preferensi FROM preferensi_pengguna WHERE id_pengguna = ?");
    $stmt_check->bind_param("i", $id_pengguna);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // Update preferensi jika sudah ada
        $stmt_update = $conn->prepare("UPDATE preferensi_pengguna SET profil_jenis_kulit = ?, profil_masalah_kulit = ?, profil_reaksi_alergi = ?, profil_aktivitas_pengguna = ? WHERE id_pengguna = ?");
        $stmt_update->bind_param("ssssi", $jenis_kulit, $masalah_kulit, $reaksi_alergi, $aktivitas_pengguna, $id_pengguna);
        if ($stmt_update->execute()) {
            header("Location: pengguna.php");
            exit();
        } else {
            $_SESSION['preferensi_error'] = "Gagal memperbarui preferensi.";
            header("Location: pengguna.php");
            exit();
        }
    } else {
        // Insert preferensi baru jika belum ada
        $stmt_insert = $conn->prepare("INSERT INTO preferensi_pengguna (id_pengguna, profil_jenis_kulit, profil_masalah_kulit, profil_reaksi_alergi, profil_aktivitas_pengguna) VALUES (?, ?, ?, ?, ?)");
        $stmt_insert->bind_param("issss", $id_pengguna, $jenis_kulit, $masalah_kulit, $reaksi_alergi, $aktivitas_pengguna);
        if ($stmt_insert->execute()) {
            header("Location: pengguna.php");
            exit();
        } else {
            $_SESSION['preferensi_error'] = "Gagal menyimpan preferensi.";
            header("Location: pengguna.php");
            exit();
        }
    }
}
