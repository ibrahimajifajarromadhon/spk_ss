<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sistem Penunjang Keputusan Sunscreen</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .register-container {
            width: 400px;
            margin: 80px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .register-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #007bff;
        }

        .form-group label {
            font-weight: bold;
        }

        .btn-primary {
            width: 100%;
        }

        .mt-3 {
            margin-top: 1.5rem;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="register-container">
            <h2>Daftar Akun Baru</h2>
            <?php if (isset($_SESSION['register_error'])): ?>
                <p class="error"><?php echo $_SESSION['register_error']; ?></p>
                <?php unset($_SESSION['register_error']); ?>
            <?php endif; ?>
            <form action="auth_process.php" method="post">
                <div class="form-group">
                    <label for="nama">Nama Lengkap:</label>
                    <input type="text" class="form-control" id="nama" name="nama" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary" name="register">Daftar</button>
            </form>
            <p class="mt-3">Sudah punya akun? <a href="login.php">Login di sini</a>.</p>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>