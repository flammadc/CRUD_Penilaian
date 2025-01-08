<?php
include "koneksi.php";
$getNIM = $_GET['nim'];
$deleteMhs = "DELETE FROM mahasiswa WHERE nim = '$getNIM'";
$resultMhs = mysqli_query($conn, $deleteMhs);

if ($resultMhs) {
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
