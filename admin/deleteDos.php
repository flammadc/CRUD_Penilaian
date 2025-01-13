<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['role_id'])) {
    header("Location: ../index.php");
    exit;
}
$role_id = $_SESSION['role_id'];
$getNIP = $_GET['nip'];
$getMK = $_GET['mk'];
$deleteDos = "DELETE FROM dosen WHERE nip = '$getNIP'";
$deleteMK = "DELETE FROM matakuliah WHERE kode_matkul = '$getMK'";
$resultDos = mysqli_query($conn, $deleteDos);
$resultMK = mysqli_query($conn, $deleteMK);

if ($resultMhs && $resultMK) {
    echo "<script>
    alert('Data Berhasil Didelete!')
    window.location = 'viewDos.php'
</script>";
} else {
    echo "<script>
    alert('Data Gagal Didelete!')
    window.location = 'viewDos.php'
</script>";
}
