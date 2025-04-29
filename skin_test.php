<?php
require_once('functions.php');
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['pengguna_id'])) {
    // Jika belum login, arahkan ke halaman login
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutorial Perawatan Kulit</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.0/css/all.min.css">

    <style>
        .article-container {
            padding-left: 30px;
            padding-right: 30px;
            padding-top: 10px;
            border-radius: 5px;
        }

        .article-title {
            font-size: 2.5rem;
            margin-bottom: 20px;
            text-align: center;
        }

        .article-section-title {
            font-size: 1.5rem;
            margin-top: 20px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .article-list {
            padding-left: 20px;
            margin-bottom: 15px;
        }

        .article-paragraph {
            margin-bottom: 15px;
            line-height: 1.6;
        }
    </style>
</head>

<body>

    <?php
    include_once('template.php');
    ?>

    <div class="container">
        <div class="article-container">
            <div class="display-4 text-center mb-2">
                Panduan Lengkap Perawatan Kulit
            </div>

            <section>
                <h2 class="article-section-title">Bagaimana Mengetahui Jenis Kulit, Masalah Kulit, dan Alergi?</h2>
                <p class="article-paragraph">Memahami jenis kulit, masalah kulit, dan potensi alergi adalah langkah awal yang krusial dalam memilih dan menggunakan produk perawatan kulit yang tepat. Berikut adalah panduan untuk membantu Anda:</p>

                <h3 class="article-section-title">1. Menentukan Jenis Kulit</h3>
                <p class="article-paragraph">Ikuti langkah berikut untuk mengetahui jenis kulit Anda:</p>
                <ol class="article-list">
                    <li>Bersihkan wajah Anda menggunakan pembersih ringan, lalu keringkan.</li>
                    <li>Biarkan wajah tanpa skincare atau makeup selama 1-2 jam.</li>
                    <li>Amati kondisi kulit Anda:
                        <ul class="article-list">
                            <li><b>Normal:</b> Kulit terasa seimbang, tidak berminyak dan tidak kering.</li>
                            <li><b>Kering:</b> Kulit terasa kencang, kasar, atau mengelupas.</li>
                            <li><b>Berminyak:</b> Kulit tampak mengkilap terutama di area T-zone (dahi, hidung, dagu).</li>
                            <li><b>Kombinasi:</b> Beberapa area berminyak (T-zone) dan area lain kering (pipi).</li>
                            <li><b>Sensitif:</b> Kulit mudah merah, perih, atau terasa panas setelah penggunaan produk tertentu.</li>
                        </ul>
                    </li>
                </ol>

                <h3 class="article-section-title">2. Mengidentifikasi Masalah Kulit</h3>
                <p class="article-paragraph">Beberapa masalah kulit umum yang dapat dikenali:</p>
                <ul class="article-list">
                    <li><b>Jerawat:</b> Muncul komedo, papula, pustula, atau nodul pada kulit.</li>
                    <li><b>Penuaan:</b> Tanda-tanda seperti garis halus, kerutan, atau kehilangan elastisitas.</li>
                    <li><b>Kemerahan:</b> Kulit sering memerah karena iritasi atau sensitivitas tinggi.</li>
                    <li><b>Flek Hitam:</b> Bercak gelap atau pigmentasi tidak merata akibat paparan sinar matahari atau bekas jerawat.</li>
                    <li><b>Kusam:</b> Kulit tampak tidak bercahaya, kurang segar, atau warna kulit tidak merata.</li>
                </ul>

                <h3 class="article-section-title">3. Mengenali Reaksi Alergi</h3>
                <p class="article-paragraph">Cara mengetahui apakah Anda memiliki alergi terhadap bahan tertentu:</p>
                <ul class="article-list">
                    <li>Perhatikan reaksi kulit setelah menggunakan produk baru (misal gatal, merah, atau ruam).</li>
                    <li>Lakukan <b>patch test</b>:
                        <ol class="article-list">
                            <li>Oleskan sedikit produk ke bagian dalam lengan bawah.</li>
                            <li>Biarkan selama 24 jam tanpa dicuci.</li>
                            <li>Jika muncul iritasi, gatal, atau kemerahan, berarti ada reaksi alergi.</li>
                        </ol>
                    </li>
                    <li>Periksa kandungan produk untuk bahan-bahan seperti alkohol, parfum, pengawet, atau lanolin yang sering memicu alergi.</li>
                </ul>

                <p class="article-paragraph">Dengan mengetahui karakteristik kulit Anda, Anda dapat memilih produk perawatan yang paling sesuai untuk kebutuhan Anda.</p>
            </section>

            <section>
                <h2 class="article-section-title">Langkah-Langkah Dasar Perawatan Kulit Harian</h2>
                <p class="article-paragraph">Setelah mengetahui jenis dan masalah kulit Anda, berikut adalah langkah-langkah dasar perawatan kulit yang sebaiknya dilakukan setiap hari:</p>
                <ol class="article-list">
                    <li><b>Pembersih (Cleanser):</b> Gunakan pembersih yang lembut sesuai dengan jenis kulit Anda pada pagi dan malam hari untuk menghilangkan kotoran, minyak, dan makeup.</li>
                    <li><b>Toner:</b> Setelah membersihkan wajah, gunakan toner untuk menyeimbangkan pH kulit dan mempersiapkannya untuk langkah selanjutnya. Pilih toner yang bebas alkohol jika kulit Anda kering atau sensitif.</li>
                    <li><b>Serum:</b> Serum mengandung konsentrasi bahan aktif yang tinggi untuk mengatasi masalah kulit spesifik seperti jerawat, penuaan, atau flek hitam. Gunakan beberapa tetes serum dan tepuk-tepuk lembut pada wajah.</li>
                    <li><b>Pelembap (Moisturizer):</b> Pelembap membantu menjaga kelembapan kulit dan melindunginya dari faktor lingkungan. Pilih pelembap yang sesuai dengan jenis kulit Anda (ringan untuk kulit berminyak, lebih kaya untuk kulit kering).</li>
                    <li><b>Tabir Surya (Sunscreen):</b> Pada pagi hari, langkah terakhir yang sangat penting adalah menggunakan tabir surya dengan SPF minimal 30 untuk melindungi kulit dari kerusakan akibat sinar UV. Aplikasikan secara merata ke seluruh wajah dan leher, bahkan saat cuaca mendung.</li>
                </ol>
            </section>

        </div>
    </div>

</body>

</html>