<?php
include ('koneksi_ramdan.php');

if (isset($_GET['id_nilai'])) {
    $id_nilai = $_GET['id_nilai'];
    $sql_delete = "DELETE FROM nilai_ramdan WHERE id_nilai='$id_nilai'";
    $query_delete = mysqli_query($koneksi, $sql_delete);

if ($query_delete) {
        echo "<script> alert ('Data berhasil dihapus!');
            window.location = 'nilai_ramdan.php';</script>";
    } else {
       echo "<script> alert ('Gagal menghapus data: ')" . $koneksi->error;
    }
}
?>