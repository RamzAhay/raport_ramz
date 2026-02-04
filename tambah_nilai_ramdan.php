<?php
include "koneksi_ramdan.php";

$queryRamdan = mysqli_query(
    $koneksi,
    "SELECT id_nilai FROM nilai_ramdan
    ORDER BY id_nilai  DESC LIMIT 1"
);
$dataRamdan = mysqli_fetch_assoc($queryRamdan);
if ($dataRamdan) {
    $no = (int) substr($dataRamdan['id_nilai'], 2, 3);
    $no++;
} else {
    $no = 1;
}
$id_nilai = "NP" . str_pad($no, 3, "0", STR_PAD_LEFT);

if (isset($_POST["simpan"])) {
    $nis = $_POST['nis'];
    $id_mapel = $_POST['id_mapel'];
    $nilai_tugas = $_POST['nilai_tugas'];
    $nilai_uts = $_POST['nilai_uts'];
    $nilai_uas = $_POST['nilai_uas'];
    $semester = $_POST['semester'];
    $tahun_ajaran = $_POST['tahun_ajaran'];

    $nilai_akhir = ($nilai_tugas * 0.3) + ($nilai_uts * 0.3) + ($nilai_uas * 0.4);

    if ($nilai_akhir >= 85) {
        $deskripsi = "Sangat Baik";
    } elseif ($nilai_akhir >= 70) {
        $deskripsi = "Baik";
    } elseif ($nilai_akhir >= 55) {
        $deskripsi = "Cukup";
    } else {
        $deskripsi = "Kurang";
    }

    $queryRamdan = mysqli_query($koneksi, "
        INSERT INTO nilai_ramdan 
        (id_nilai, nis, id_mapel, nilai_tugas, nilai_uts, nilai_uas, nilai_akhir, deskripsi, semester, tahun_ajaran)
        VALUES
        ('$id_nilai', '$nis','$id_mapel','$nilai_tugas','$nilai_uts','$nilai_uas','$nilai_akhir','$deskripsi','$semester','$tahun_ajaran')
    ");

    if ($queryRamdan) {
        echo "<script>alert('Data berhasil ditambahkan');window.location='nilai_ramdan.php';</script>";
    } else {
        echo "<script>alert('Data gagal ditambahkan');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ramdan Tambah nilai</title>
    <style>
        table,
        tr,
        td {
            border: 1px solid black;
        }

        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            background: #f4f6f9;
            padding: 40px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        form {
            display: flex;
            justify-content: center;
        }

        table {
            background: #ffffff;
            border-collapse: collapse;
            width: 500px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            border-radius: 8px;
            overflow: hidden;
        }

        td {
            padding: 12px 15px;
            font-size: 14px;
        }

        tr:nth-child(even) {
            background: #f9fafc;
        }

        td:first-child {
            font-weight: 600;
            width: 40%;
            color: #444;
        }

        input[type="number"],
        select {
            width: 100%;
            padding: 8px 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
            transition: 0.2s;
        }

        input[type="number"]:focus,
        select:focus {
            border-color: #4e73df;
            outline: none;
            box-shadow: 0 0 0 2px rgba(78, 115, 223, 0.2);
        }

        input[type="submit"] {
            background: #4e73df;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            transition: 0.2s;
        }

        input[type="submit"]:hover {
            background: #2e59d9;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 25px;
            text-decoration: none;
            color: #4e73df;
            font-weight: 600;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <h1>Tambah Nilai</h1>
    <form method="post">
        <table>

            <tr>
                <td>NIS</td>
                <td>
                    <select name="nis" required>
                        <option value="">-- Pilih Nis Siswa --</option>
                        <?php
                        $siswa = mysqli_query($koneksi, "SELECT nis FROM siswa_ramdan");
                        while ($row = mysqli_fetch_assoc($siswa)) {
                            echo "<option value='{$row['nis']}'>{$row['nis']}</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>

            <tr>
                <td>Mata Pelajaran</td>
                <td>
                    <select name="id_mapel" required>
                        <option value="">-- Pilih Mapel --</option>
                        <?php
                        $mapel = mysqli_query($koneksi, "SELECT id_mapel, nama_mapel FROM mapel_ramdan");
                        while ($m = mysqli_fetch_assoc($mapel)) {
                            echo "<option value='{$m['id_mapel']}'>{$m['nama_mapel']}</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Nilai Tugas</td>
                <td><input type="number" name="nilai_tugas" required></td>
            </tr>
            <tr>
                <td>Nilai UTS</td>
                <td><input type="number" name="nilai_uts" required></td>
            </tr>
            <tr>
                <td>Nilai UAS</td>
                <td><input type="number" name="nilai_uas" required></td>
            </tr>
            <tr>
                <td>Semester</td>
                <td>
                    <select name="semester" required>
                        <option value="">-- Pilih Semester --</option>
                        <option value="ganjil">ganjil</option>
                        <option value="genap">genap</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Tahun Ajaran</td>
                <td>
                    <select name="tahun_ajaran" required>
                        <option value="">-- Pilih Tahun Ajaran --</option>
                        <option value="2023/2024">2023/2024</option>
                        <option value="2024/2025">2024/2025</option>
                        <option value="2025/2026">2025/2026</option>
                        <option value="2026/2027">2026/2027</option>
                        <option value="2027/2028">2027/2028</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="simpan" value="Simpan"></td>
            </tr>
        </table>
    </form>

    <a href="nilai_ramdan.php">← Kembali ke Daftar Nilai</a>
</body>

</html>