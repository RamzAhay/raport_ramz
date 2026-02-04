<?php
include('koneksi_ramdan.php');

$id_nilai = $nis = $id_mapel = $nilai_tugas = $nilai_uts = $nilai_uas = '';
$deskripsi = $semester = $tahun_ajaran = '';

if (isset($_GET['id_nilai'])) {
    $id_nilai = mysqli_real_escape_string($koneksi, $_GET['id_nilai']);
    $result = mysqli_query($koneksi, "SELECT * FROM nilai_ramdan WHERE id_nilai = '$id_nilai'");

    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        $id_nilai = $data['id_nilai'];
        $nis = $data['nis'];
        $id_mapel = $data['id_mapel'];
        $nilai_tugas = $data['nilai_tugas'];
        $nilai_uts = $data['nilai_uts'];
        $nilai_uas = $data['nilai_uas'];
        $deskripsi = $data['deskripsi'];
        $semester = $data['semester'];
        $tahun_ajaran = $data['tahun_ajaran'];
    } else {
        echo "<script>alert('Data tidak ditemukan');window.location='nilai_ramdan.php';</script>";
        exit;
    }
}

if (isset($_POST['simpan'])) {
    $id_nilai = isset($_POST['id_nilai']) ? mysqli_real_escape_string($koneksi, $_POST['id_nilai']) : '';
    $nis = intval($_POST['nis']);
    $id_mapel = intval($_POST['id_mapel']);
    $nilai_tugas = floatval($_POST['nilai_tugas']);
    $nilai_uts = floatval($_POST['nilai_uts']);
    $nilai_uas = floatval($_POST['nilai_uas']);
    $deskripsi = $_POST['deskripsi'];
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

    if ($id_nilai > 0) {
        $query = mysqli_query($koneksi, "
    UPDATE nilai_ramdan SET
        nilai_tugas = $nilai_tugas,
        nilai_uts = $nilai_uts,
        nilai_uas = $nilai_uas,
        nilai_akhir = $nilai_akhir,
        deskripsi = '$deskripsi',
        semester = '$semester',
        tahun_ajaran = '$tahun_ajaran'
    WHERE id_nilai = '$id_nilai'
");
        $msg = 'diperbarui';

    } else {
        $query = mysqli_query($koneksi, "
    INSERT INTO nilai_ramdan
    (nis, id_mapel, nilai_tugas, nilai_uts, nilai_uas, nilai_akhir, deskripsi, semester, tahun_ajaran)
    VALUES
    ($nis, $id_mapel, $nilai_tugas, $nilai_uts, $nilai_uas, $nilai_akhir, '$deskripsi', '$semester', '$tahun_ajaran')
");
$msg = "ditambahkan";

    }
    if ($query) {
        echo "<script>alert('Data berhasil $msg');window.location='nilai_ramdan.php';</script>";
        exit;
    } else {
        $error = mysqli_error($koneksi);
        echo "<script>alert('Gagal menyimpan data: $error');</script>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Form Nilai Siswa</title>
    <style>
    * {
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        margin: 0;
        background: linear-gradient(135deg, #eef2f7, #dbe7ff);
        padding: 40px 15px;
    }

    form {
        width: 560px;
        margin: auto;
        background: #ffffff;
        padding: 30px 35px;
        border-radius: 14px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
        animation: fadeIn 0.4s ease-in-out;
    }

    @keyframes fadeIn {
        from {opacity: 0; transform: translateY(10px);}
        to {opacity: 1; transform: translateY(0);}
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    td {
        padding: 10px 6px;
        vertical-align: middle;
    }

    td:first-child {
        width: 38%;
        font-weight: 600;
        color: #444;
        letter-spacing: 0.3px;
    }

    input[type="number"],
    input[type="text"] {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #d0d7e2;
        border-radius: 8px;
        background: #f9fbff;
        transition: all 0.2s ease;
        font-size: 14px;
    }

    input[readonly] {
        background: #eef1f6;
        color: #666;
        cursor: not-allowed;
    }

    input:focus {
        border-color: #4e73df;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.15);
        outline: none;
    }

    .btn-container {
        text-align: right;
        padding-top: 15px;
    }

    input[type="submit"] {
        background: linear-gradient(135deg, #4e73df, #224abe);
        color: white;
        padding: 11px 22px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: all 0.25s ease;
    }

    input[type="submit"]:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(34, 74, 190, 0.25);
    }

    .back-link {
        display: block;
        width: 560px;
        margin: 18px auto 0;
        color: #4e73df;
        text-decoration: none;
        font-weight: 600;
        transition: 0.2s;
    }

    .back-link:hover {
        color: #1c3faa;
        text-decoration: underline;
    }

    @media (max-width: 640px) {
        form, .back-link {
            width: 95%;
        }
        td:first-child {
            width: 42%;
        }
    }
</style>

</head>

<body>

    <form method="post" action="edit_ramdan.php?id_nilai=<?php echo $id_nilai; ?>">

        <table>
            <tr>
                <td>ID Nilai</td>
                <td><input type="text" readonly name="id_nilai" value="<?php echo $id_nilai; ?>"></td>
            </tr>
            <tr>
                <td>NIS</td>
                <td><input type="number" readonly name="nis" value="<?php echo htmlspecialchars($nis); ?>"></td>
            </tr>
            <tr>
                <td>Mata Pelajaran</td>
                <td><input type="number" readonly name="id_mapel" value="<?php echo htmlspecialchars($id_mapel); ?>">
                </td>
            </tr>
            <tr>
                <td>Nilai Tugas</td>
                <td><input type="number" name="nilai_tugas" value="<?php echo htmlspecialchars($nilai_tugas); ?>"
                        required></td>
            </tr>
            <tr>
                <td>Nilai UTS</td>
                <td><input type="number" name="nilai_uts" value="<?php echo htmlspecialchars($nilai_uts); ?>" required>
                </td>
            </tr>
            <tr>
                <td>Nilai UAS</td>
                <td><input type="number" name="nilai_uas" value="<?php echo htmlspecialchars($nilai_uas); ?>" required>
                </td>
            </tr>
            <tr>
                <td>Semester</td>
                <td><input type="text" name="semester" value="<?php echo htmlspecialchars($semester); ?>" required></td>
            </tr>
            <tr>
                <td>Tahun Ajaran</td>
                <td><input type="text" name="tahun_ajaran" value="<?php echo htmlspecialchars($tahun_ajaran); ?>"
                        required></td>
            </tr>
            <tr>
                <td></td>
                <td class="btn-container">
                    <input type="submit" name="simpan"
                        value="<?php echo isset($_GET['id_nilai']) ? 'Perbarui' : 'Simpan'; ?>">
                </td>
            </tr>
        </table>
    </form>

    <a href="nilai_ramdan.php" class="back-link">← Kembali ke Daftar Nilai</a>

</body>

</html>