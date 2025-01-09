<?php
include "../koneksi.php";
$getNIM = $_GET['nim'];
$getNIP = $_GET['nip'];

$editMhs = "SELECT 
    m.nim, 
    m.nama, 
    n.tugas, 
    n.uts, 
    n.uas, 
    (0.2 * n.tugas) + (0.4 * n.uts) + (0.4 * n.uas) AS nilai_akhir, 
    mk.nama_matkul AS nama_matakuliah, 
    d.nama AS nama_dosen,
    d.nip
FROM 
    nilai n
LEFT JOIN 
    mahasiswa m ON m.nim = n.nim
LEFT JOIN 
    dosen d ON d.nip = n.nip
LEFT JOIN 
    matakuliah mk ON d.kode_matkul = mk.kode_matkul WHERE n.nim = '$getNIM' AND n.nip = '$getNIP'";

$resultMhs = mysqli_query($conn, $editMhs);
$dataMhs = mysqli_fetch_array($resultMhs);

if (!isset($_POST['submit'])) {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Mahasiswa</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </head>

    <body>
        <nav class="navbar bg-body-secondary border-bottom border-light-subtle">
            <div class="container-fluid px-4">
                <a class="navbar-brand" href="index.php">
                    <h4>Dashboard Admin</h4>
                </a>
            </div>
        </nav>

        <div class="container">
            <form class="mt-5 shadow-sm py-4 px-3 mb-5 bg-light rounded" enctype="multipart/form-data" method="post">
                <h4 class="mb-3">Edit Nilai Mahasiswa</h4>

                <div class="mb-3 row align-items-center">
                    <label for="nim" class="col-sm-2 fw-semibold col-form-label">NIM</label>
                    <div class="col-sm-10">
                        <input type="text" name="nim" class="form-control" id="nim" readonly value="<?php echo $dataMhs['nim']; ?>">
                    </div>
                </div>

                <div class="mb-3 row align-items-center">
                    <label for="nama" class="col-sm-2 fw-semibold col-form-label">Nama</label>
                    <div class="col-sm-10">
                        <input type="text" name="nama" class="form-control" id="nama" value="<?php echo $dataMhs['nama']; ?>">
                    </div>
                </div>

                <div class="mb-3 row align-items-center">
                    <label for="tugas" class="col-sm-2 fw-semibold col-form-label">Tugas</label>
                    <div class="col-sm-10">
                        <input type="number" name="tugas" class="form-control" id="tugas" value="<?php echo $dataMhs['tugas']; ?>">
                    </div>
                </div>

                <div class="mb-3 row align-items-center">
                    <label for="uts" class="col-sm-2 fw-semibold col-form-label">UTS</label>
                    <div class="col-sm-10">
                        <input type="number" name="uts" class="form-control" id="uts" value="<?php echo $dataMhs['uts']; ?>">
                    </div>
                </div>

                <div class="mb-3 row align-items-center">
                    <label for="uas" class="col-sm-2 fw-semibold col-form-label">UAS</label>
                    <div class="col-sm-10">
                        <input type="number" name="uas" class="form-control" id="uas" value="<?php echo $dataMhs['uas']; ?>">
                    </div>
                </div>

                <div class="mb-3 row align-items-center">
                    <label for="nip" class="col-sm-2 fw-semibold col-form-label">Dosen</label>
                    <div class="col-sm-10">
                        <input type="text" name="nip" class="form-control" id="nip" readonly value="<?php echo $dataMhs['nip']; ?>">
                    </div>
                </div>

                <div class="d-flex justify-items-right mt-4">
                    <div class="col-sm-10"></div>
                    <button name="submit" type="submit" class="btn btn-primary col-sm-2">Submit</button>
                </div>
            </form>
        </div>
    </body>

    </html>

<?php
} else {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $tugas = filter_var($_POST['tugas'], FILTER_VALIDATE_INT);
    $uts = filter_var($_POST['uts'], FILTER_VALIDATE_INT);
    $uas = filter_var($_POST['uas'], FILTER_VALIDATE_INT);
    $nip = mysqli_real_escape_string($conn, $_POST['nip']);
    $nim = mysqli_real_escape_string($conn, $_POST['nim']);

    $updateMhs = "UPDATE mahasiswa SET nama='$nama' WHERE nim='$nim'";
    $updateNilai = "UPDATE nilai SET tugas='$tugas', uts='$uts', uas='$uas' WHERE nip='$nip' AND nim='$nim'";

    $queryMhs = mysqli_query($conn, $updateMhs);
    $queryNilai = mysqli_query($conn, $updateNilai);

    if ($queryMhs && $queryNilai) {
        echo "<script>
            alert('Data Berhasil Diupdate!');
            window.location = 'index.php';
        </script>";
    } else {
        echo "<script>
            alert('Data Gagal Diupdate: " . mysqli_error($conn) . "');
            window.location = 'index.php';
        </script>";
    }
}
?>