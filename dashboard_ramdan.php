<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ramdan Dashboard</title>
    <style>
      * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f4f6f9;
    color: #333;
}

.sidenav {
    position: fixed;
    left: 0;
    top: 0;
    height: 100%;
    width: 220px;
    background: linear-gradient(180deg, #4e73df, #224abe);
    padding-top: 20px;
}

.sidenav ul {
    list-style: none;
}

.sidenav a {
    display: block;
    padding: 15px 20px;
    text-decoration: none;
    color: white;
    font-weight: 500;
    transition: 0.2s;
}

.sidenav a:hover {
    background: rgba(255,255,255,0.15);
    padding-left: 25px;
}

#Logout {
    background: #e74a3b;
    margin-top: 20px;
}

.main {
    margin-left: 220px;
    padding: 30px;
}

h2 {
    margin-bottom: 25px;
}

.container {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.box {
    flex: 1;
    min-width: 220px;
    background: white;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    text-align: center;
    transition: transform 0.2s, box-shadow 0.2s;
}

.box:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 14px rgba(0,0,0,0.12);
}

.box h2 {
    font-size: 32px;
    color: #4e73df;
    margin-bottom: 10px;
}

.box p {
    font-size: 14px;
    color: #666;
}

@media (max-width: 768px) {
    .sidenav {
        width: 70px;
    }

    .sidenav a {
        font-size: 12px;
        padding: 12px;
        text-align: center;
    }

    .main {
        margin-left: 70px;
    }
}

    </style>
</head>
<body>
    <div class="sidenav" id="mySidenav">
    <ul>
        <li><a href="dashboard_ramdan.php" id="Dashboard"> Dashboard</a></li>
        <li><a href="siswa_ramdan.php" id="Produk">Siswa</a></li>
        <li><a href="nilai_ramdan.php" id="Kategori">Nilai</a></li>
        <li><a href="logout_ramdan.php" id="Logout">Logout</a></li>
    </ul>
    </div>

    <div class="main">
    <h2>Dashboard</h2><br>
        <?php
        include "koneksi_ramdan.php";
        $querysiswa = mysqli_query($koneksi, "SELECT COUNT(*) AS total_siswa FROM siswa_ramdan");
        $datasiswa = mysqli_fetch_array($querysiswa);

        $queryKelas = mysqli_query($koneksi, "SELECT COUNT(*) AS total_kelas FROM kelas_ramdan");
        $dataKelas = mysqli_fetch_array($queryKelas);

        $queryNilai = mysqli_query($koneksi, "SELECT COUNT(DISTINCT nis) AS sudah_nilai FROM nilai_ramdan");
        $dataNilai = mysqli_fetch_array($queryNilai);

        $belumNilai = $datasiswa['total_siswa'] - $dataNilai['sudah_nilai'];
        ?>

        <div class="container">
    <div class="box">
        <h2><?php echo $datasiswa['total_siswa']; ?></h2>
        <p>Jumlah Siswa</p>
    </div>

    <div class="box">
        <h2><?php echo $dataKelas['total_kelas']; ?></h2>
        <p>Jumlah Kelas</p>
    </div>

    <div class="box">
        <h2><?php echo $dataNilai['sudah_nilai']; ?> / <?php echo $datasiswa['total_siswa']; ?></h2>
        <p>Status Pengisian Nilai</p>
    </div>
</div>
    </table>
    <br>
</body>
</html>