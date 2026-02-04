<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ramdan Nilai</title>
    <style>
        body {
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }
        table,td,th {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 10px;
        }
        table {
            margin-left: 13%;
        }
        th {
            background: #3767af;
        }
        .tombol {
            margin-left: 20%;
        }
        h2 {
            text-align: center;
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
            background: rgba(255,255,255,0.15);
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
        <li><a href="dashboard_ramdan.php" id="Dashboard">Dashboard</a></li>
        <li><a href="siswa_ramdan.php" id="Produk">Siswa</a></li>
        <li><a href="nilai_ramdan.php" id="Kategori">Nilai</a></li>
    </ul>
    </div>

    <div class="main">
    <h2>Daftar Nilai</h2> <br>

    <a style="margin-left: 42%;" href="tambah_nilai_Ramdan.php" class="btn-flip" data-back="Meluncur"data-front="Tambah Data Nilai"></a>

    <table>
        <tr>
            <th>ID Nilai</th>
            <th>Nis</th>
            <th>Nama</th>
            <th>Mapel</th>
            <th>Nilai Tugas</th>
            <th>Nilai UTS</th>
            <th>Nilai UAS</th>
            <th>Nilai Akhir</th>
            <th>Deskripsi</th>
            <th>Semester</th>
            <th>Tahun ajaran</th>
            <th>aksi</th>
        </tr>
        <?php
        include "koneksi_ramdan.php";
        $queryRamdan = mysqli_query($koneksi, "
    SELECT nilai_ramdan.*, siswa_ramdan.nama, mapel_ramdan.nama_mapel
    FROM nilai_ramdan
    JOIN siswa_ramdan ON nilai_ramdan.nis = siswa_ramdan.nis
    JOIN mapel_ramdan ON nilai_ramdan.id_mapel = mapel_ramdan.id_mapel
");
        if(mysqli_num_rows($queryRamdan) > 0){
        while ($data = mysqli_fetch_array($queryRamdan)) {
        ?>
    <tr>
            <td><?php echo $data['id_nilai']; ?></td>
            <td><?php echo $data['nis']; ?></td>
            <td><?php echo $data['nama']; ?></td>
            <td><?php echo $data['nama_mapel']; ?></td>
            <td><?php echo $data['nilai_tugas']; ?></td>
            <td><?php echo $data['nilai_uts']; ?></td>
            <td><?php echo $data['nilai_uas']; ?></td>
            <td><?php echo $data['nilai_akhir']; ?></td>
            <td><?php echo $data['deskripsi']; ?></td>
            <td><?php echo $data['semester']; ?></td>
            <td><?php echo $data['tahun_ajaran']; ?></td>
            <td>
            <a class="btn edit" href="edit_ramdan.php?id_nilai=<?php echo $data['id_nilai']; ?>">Edit</a>
            <a class="btn hapus" href="delete_ramdan.php?id_nilai=<?php echo $data['id_nilai']; ?>" 
               onclick="return confirm('Yakin ingin menghapus data?')">Hapus
            </a>
        </td>
    </tr>
    <?php
        }
    } else {
    ?>
    <tr>
        <td colspan="11">Data tidak ada</td>
    </tr>
    <?php } ?>
</table>
</body>
</html>