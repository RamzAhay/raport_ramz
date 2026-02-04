<?php
$koneksi = mysqli_connect("localhost","root","","db_rapor_ramdan");

// check connection
if (mysqli_connect_errno()) {
    echo "Koneksi ke database gagal". mysqli_connect_error();
}
?>