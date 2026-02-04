<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ramdan Siswa</title>
    <style>
        body {

            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }

        table,
        td,
        th {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 10px;
        }

        table {
            margin-left: 18%;
        }

        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
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
            background: rgba(255, 255, 255, 0.15);
            padding-left: 25px;
        }

        #Logout {
            background: #e74a3b;
            margin-top: 20px;
        }

        .main {
            margin-left: 100px;
            padding: 0px 10px;
        }

        th {
            background: #3767af;
        }

        h2 {
            text-align: center;
        }

        .filter-box {
            background: #f8f9fc;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            width: fit-content;
            margin: 0 auto 20px auto;
            font-size: 14px;
        }

        .filter-box label {
            margin-right: 8px;
            font-weight: 600;
        }

        .filter-box input,
        .filter-box select {
            padding: 6px 8px;
            border-radius: 4px;
            border: 1px solid #ccc;
            margin-right: 15px;
            font-size: 14px;
        }

        .filter-box button {
            padding: 6px 14px;
            border: none;
            border-radius: 4px;
            background: #4e73df;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: 0.2s;
        }

        .filter-box button:hover {
            background: #2e59d9;
        }

        .btn-flip {
            opacity: 1;
            outline: 0;
            color: #fff;
            line-height: 30px;
            position: relative;
            text-align: center;
            letter-spacing: 1px;
            display: inline-block;
            text-decoration: none;
            font-family: "Open Sans";
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .btn-flip:hover:after {
            opacity: 1;
            transform: translateY(0) rotateX(0);
        }

        .btn-flip:hover:before {
            opacity: 0;
            transform: translateY(50%) rotateX(90deg);
        }

        .btn-flip:after {
            top: 0;
            left: 0;
            opacity: 0;
            width: 100%;
            color: #323237;
            display: block;
            transition: 0.5s;
            position: absolute;
            background: #adadaf;
            content: attr(data-back);
            transform: translateY(-50%) rotateX(90deg);
        }

        .btn-flip:before {
            top: 0;
            left: 0;
            opacity: 1;
            color: white;
            display: block;
            padding: 0 10px;
            line-height: 30px;
            transition: 0.5s;
            position: relative;
            background: #3767af;
            content: attr(data-front);
            transform: translateY(0) rotateX(0);
        }
    </style>
</head>

<body>
    <div class="sidenav" id="mySidenav">
        <ul>
            <li><a href="dashboard_ramdan.php" id="Dashboard"> Dashboard</a></li>
            <li><a href="siswa_ramdan.php" id="Produk">Siswa</a></li>
            <li><a href="nilai_ramdan.php" id="Kategori">Nilai</a></li>
        </ul>
    </div>

    <div class="main">
        <h2>Daftar Siswa</h2> <br>

        <?php
        include_once "koneksi_ramdan.php";
        $kelasList = mysqli_query($koneksi, "SELECT id_kelas, nama_kelas FROM kelas_ramdan ORDER BY nama_kelas");
        ?>

        <form method="GET" class="filter-box">
            <label>Nama Siswa</label>
            <input type="text" name="nama" value="<?php echo $_GET['nama'] ?? ''; ?>">

            <label>Tahun Ajaran</label>
            <input type="text" name="tahun" placeholder="2025/2026" value="<?php echo $_GET['tahun'] ?? ''; ?>">


            <label>Kelas</label>
            <select name="id_kelas">
                <option value="">Semua</option>
                <?php while ($kelas = mysqli_fetch_array($kelasList)) { ?>
                    <option value="<?php echo $kelas['id_kelas']; ?>" <?php if (($_GET['id_kelas'] ?? '') == $kelas['id_kelas'])
                           echo 'selected'; ?>>
                        <?php echo $kelas['nama_kelas']; ?>
                    </option>
                <?php } ?>
            </select>

            <button type="submit">Filter</button>
        </form>
        <table>
            <tr>
                <th>NIS</th>
                <th>Nama</th>
                <th>Tempat Lahir</th>
                <th>Tgl Lahir</th>
                <th>Alamat</th>
                <th>Kelas</th>
                <th>Cetak Rapor</th>
            </tr>
            <?php
            include_once "koneksi_ramdan.php";

            $nama = $_GET['nama'] ?? '';
            $tahun = $_GET['tahun'] ?? '';
            $id_kelas = $_GET['id_kelas'] ?? '';

            $sql = "SELECT DISTINCT siswa_ramdan.*, kelas_ramdan.nama_kelas\n        FROM siswa_ramdan\n        LEFT JOIN kelas_ramdan ON siswa_ramdan.id_kelas = kelas_ramdan.id_kelas
        LEFT JOIN nilai_ramdan ON siswa_ramdan.nis = nilai_ramdan.nis
        WHERE 1=1";

            if ($nama != '') {
                $nama = mysqli_real_escape_string($koneksi, $nama);
                $sql .= " AND siswa_ramdan.nama LIKE '%$nama%'";
            }

            if ($tahun != '') {
                $tahun = mysqli_real_escape_string($koneksi, $tahun);
                $sql .= " AND nilai_ramdan.tahun_ajaran = '$tahun'";
            }

            if ($id_kelas != '') {
                $id_kelas = mysqli_real_escape_string($koneksi, $id_kelas);
                $sql .= " AND siswa_ramdan.id_kelas = '$id_kelas'";
            }

            $queryRamdan = mysqli_query($koneksi, $sql);



            while ($data = mysqli_fetch_array($queryRamdan)) {
                ?>
                <tr>
                    <td><?php echo $data['nis']; ?></td>
                    <td><?php echo $data['nama']; ?></td>
                    <td><?php echo $data['tempat_lahir']; ?></td>
                    <td><?php echo $data['tgl_lahir']; ?></td>
                    <td><?php echo $data['alamat']; ?></td>
                    <td><?php echo $data['nama_kelas']; ?></td>
                    <td>
                        <form action="cetak.php" method="GET" target="_blank" style="margin:0;">
                            <input type="hidden" name="nis" value="<?php echo $data['nis']; ?>">

                            <select name="semester" required>
                                <option value="">Pilih Semester</option>
                                <option value="ganjil">Semester Ganjil</option>
                                <option value="genap">Semester Genap</option>
                            </select>
                            <button type="submit">Cetak</button>
                        </form>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>
        <br>
        <a style="margin-left: 40%;" href="cetak_all.php" class="btn-flip" target="_blank" data-back="Meluncur"
            data-front="Cetak Semua Siswa"></a>
</body>

</html>