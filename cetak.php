<?php
require('fpdf.php');
include "koneksi_ramdan.php";

if (!isset($_GET['nis']) || !isset($_GET['semester'])) {
    die('Data tidak lengkap');
}

$nis = mysqli_real_escape_string($koneksi, $_GET['nis']);
$semester = mysqli_real_escape_string($koneksi, $_GET['semester']);

$siswa = mysqli_fetch_assoc(mysqli_query($koneksi, "
    SELECT siswa_ramdan.*, kelas_ramdan.nama_kelas
    FROM siswa_ramdan
    JOIN kelas_ramdan ON siswa_ramdan.id_kelas = kelas_ramdan.id_kelas
    WHERE siswa_ramdan.nis='$nis'
"));
if (!$siswa) die('Data siswa tidak ditemukan');

$nilai = mysqli_query($koneksi, "
    SELECT m.nama_mapel, n.nilai_tugas, n.nilai_uts, n.nilai_uas, n.nilai_akhir, n.deskripsi
    FROM nilai_ramdan n
    JOIN mapel_ramdan m ON n.id_mapel = m.id_mapel
    WHERE n.nis='$nis' AND n.semester='$semester'
");

$absensi = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT sakit, izin, alfa FROM absensi_ramdan WHERE nis='$nis'"));

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetAutoPageBreak(true, 10);


$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,7,'LAPORAN HASIL BELAJAR SISWA',0,1,'C');
$pdf->SetFont('Arial','',12);
$pdf->Cell(0,7,'SMK NEGERI 2 CIMAHI',0,1,'C');
$pdf->Cell(0,7,'Tahun Ajaran 2025/2026 - Semester '.ucfirst($semester),0,1,'C');
$pdf->Ln(10);


$pdf->SetFont('Arial','',11);
$pdf->Cell(35,7,'Nama',0,0);      $pdf->Cell(60,7,': '.$siswa['nama'],0,0);
$pdf->Cell(30,7,'NIS',0,0);       $pdf->Cell(0,7,': '.$siswa['nis'],0,1);

$pdf->Cell(35,7,'Tempat, Tgl Lahir',0,0);
$pdf->Cell(60,7,': '.$siswa['tempat_lahir'].', '.$siswa['tgl_lahir'],0,0);
$pdf->Cell(30,7,'Kelas',0,0);
$pdf->Cell(0,7,': '.$siswa['nama_kelas'],0,1);

$pdf->Cell(35,7,'Alamat',0,0);
$pdf->MultiCell(0,7,': '.$siswa['alamat'],0,1);
$pdf->Cell(35,7,'Semester',0,0);
$pdf->Cell(0,7,': '.ucfirst($semester),0,1);

$pdf->Ln(3);


$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,7,'Nilai Akademik',0,1);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(60,8,'Mata Pelajaran',1);
$pdf->Cell(15,8,'Tugas',1,0,'C');
$pdf->Cell(15,8,'UTS',1,0,'C');
$pdf->Cell(15,8,'UAS',1,0,'C');
$pdf->Cell(20,8,'Akhir',1,0,'C');
$pdf->Cell(65,8,'Deskripsi',1,1,'C');

$pdf->SetFont('Arial','',10);

if (mysqli_num_rows($nilai) > 0) {
    while ($n = mysqli_fetch_assoc($nilai)) {
        $yStart = $pdf->GetY();

        $pdf->Cell(60,8,$n['nama_mapel'],1);
        $pdf->Cell(15,8,$n['nilai_tugas'],1,0,'C');
        $pdf->Cell(15,8,$n['nilai_uts'],1,0,'C');
        $pdf->Cell(15,8,$n['nilai_uas'],1,0,'C');
        $pdf->Cell(20,8,$n['nilai_akhir'],1,0,'C');

        $xDesc = $pdf->GetX();
        $yDesc = $pdf->GetY();
        $pdf->MultiCell(65,8,$n['deskripsi'],1);

        $rowHeight = $pdf->GetY() - $yStart;
        $pdf->SetXY(10, $yStart + $rowHeight);
    }
} else {
    $pdf->Cell(190,8,'Belum ada nilai',1,1,'C');
}

$pdf->Ln(5);


$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,7,'Data Kehadiran',0,1);

$pdf->SetFont('Arial','',11);
$pdf->Cell(40,8,'Sakit',1);  $pdf->Cell(30,8,$absensi['sakit'].' hari',1,1);
$pdf->Cell(40,8,'Izin',1);   $pdf->Cell(30,8,$absensi['izin'].' hari',1,1);
$pdf->Cell(40,8,'Alfa',1);   $pdf->Cell(30,8,$absensi['alfa'].' hari',1,1);

$pdf->Ln(15);


$pdf->Cell(95,7,'Orang Tua/Wali',0,0,'C');
$pdf->Cell(95,7,'Wali Kelas',0,1,'C');

$pdf->Ln(20);

$pdf->Cell(95,7,'(____________________)',0,0,'C');
$pdf->Cell(95,7,'(____________________)',0,1,'C');

$pdf->Output('I', 'Rapor_'.$siswa['nama'].'_'.$semester.'.pdf');
?>
