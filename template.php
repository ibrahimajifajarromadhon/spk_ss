<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPK Kandungan Sunscreen</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <style>
        body {
            display: flex;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            background-color: #343a40;
            /* Warna bg-dark */
            color: white;
            width: 250px;
            /* Lebar sidebar sesuai kebutuhan */
            flex-shrink: 0;
            /* Agar sidebar tidak mengecil */
            padding-top: 20px;
        }

        .sidebar .navbar-brand {
            padding: 15px;
            text-align: center;
            display: block;
        }

        .sidebar .navbar-nav {
            flex-direction: column;
            /* Mengatur item menu menjadi vertikal */
        }

        .sidebar .nav-item {
            margin-bottom: 5px;
        }

        .sidebar .nav-link {
            padding: 10px 20px;
            color: white;
            display: block;
        }

        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            text-decoration: none;
        }

        .content {
            flex-grow: 1;
            /* Agar konten utama mengisi sisa ruang */
            padding: 20px;
        }

        .sidebar .nav-link.active {
            background-color: #007bff;
            /* Contoh warna biru Bootstrap */
            color: white !important;
            /* Pastikan teks tetap putih */
            font-weight: bold;
            /* Opsional: buat teks lebih tebal */
        }
    </style>
</head>

<body>

    <?php
    $current_page = basename($_SERVER['PHP_SELF']);
    ?>

    <nav class="sidebar navbar-dark">
        <a class="navbar-brand" href="index.php">SPK Sunscreen</a>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link <?php if ($current_page == 'index.php') echo 'active'; ?>" href="index.php"><i class="fa fa-home mr-2"></i> Home </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if ($current_page == 'pengguna.php') echo 'active'; ?>" href="pengguna.php"><i class="fa fa-user mr-2"></i> Profil Pengguna </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if ($current_page == 'pengguna_tambah.php') echo 'active'; ?>" href="pengguna_tambah.php"><i class="fa fa-user-plus mr-2"></i> Tambah Profil </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if ($current_page == 'skin_test.php') echo 'active'; ?>" href="skin_test.php"><i class="fa fa-sun mr-2"></i> Skin Test </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if ($current_page == 'peringkat.php') echo 'active'; ?>" href="peringkat.php"><i class="fa fa-trophy mr-2"></i> Rekomendasi </a>
            </li>
            <li class="nav-item mt-auto">
                <a class="nav-link" href="auth_process.php?logout"><i class="fa fa-sign-out-alt mr-2"></i> Logout</a>
            </li>
        </ul>
    </nav>
</body>

</html>