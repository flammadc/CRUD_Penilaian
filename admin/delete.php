<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['role_id'])) {
    header("Location: ../index.php");
    exit;
}
$role_id = $_SESSION['role_id'];
$username = $_SESSION['username'];
$getNIM = $_GET['nim'];
$deleteMhs = "DELETE FROM mahasiswa WHERE nim = '$getNIM'";
$deleteNilai = "DELETE FROM nilai WHERE nim = '$getNIM'";
$resultMhs = mysqli_query($conn, $deleteMhs);
$resultNilai = mysqli_query($conn, $deleteNilai);

if ($resultMhs && $resultNilai) {
    echo "<script>
    alert('Data Berhasil Didelete!')
    window.location = 'index.php'
</script>";
} else {
    echo "<script>
    alert('Data Gagal Didelete!')
    window.location = 'index.php'
</script>";
}
