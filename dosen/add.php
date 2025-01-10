<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['role_id'])) {
    header("Location: ../index.php");
    exit;
}

if ($_SESSION['role_id'] == 1) {
    header("Location: ../admin/index.php");
}
if ($_SESSION['role_id'] == 3) {
    header("Location: ../mahasiswa/index.php");
}
$sNIP = $_SESSION['username'];

$editMhs = "SELECT 
    m.nim, 
    m.nama, 
    n.tugas, 
    n.uts, 
    n.uas, 
    (0.2 * n.tugas) + (0.4 * n.uts) + (0.4 * n.uas) AS nilai_akhir, 
    mk.nama_matkul AS nama_matakuliah, 
    d.nama AS nama_dosen
FROM 
    mahasiswa m
LEFT JOIN 
    nilai n ON m.nim = n.nim
LEFT JOIN 
    dosen d ON d.nip = n.nip
LEFT JOIN 
    matakuliah mk ON d.kode_matkul = mk.kode_matkul;";
$resultMhs = mysqli_query($conn, $editMhs);
$dataMhs = mysqli_fetch_array($resultMhs);
if (!isset($_POST['submit'])) {

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </head>

    <body>
        <nav class="navbar bg-body-secondary border-bottom border-light-subtle">
            <div class="container-fluid px-4">
                <a class="navbar-brand" href="index.php">
                    <h4>
                        Dashboard Dosen
                    </h4>
                </a>


            </div>
        </nav>

        <div class="container ">
            <form class="mt-5 shadow-sm py-4 px-3 mb-5 bg-light rounded" enctype="multipart/form-data" method="post">
                <h4 class="mb-3">Tambah Nilai</h4>
                <div class="mb-3 row align-items-center">
                    <label for="nim" class="col-sm-2 fw-semibold col-form-label">NIM</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="nim" name="nim" aria-label="Default select example" required>
                            <option class="bg-secondary text-white " disabled>Pilih:</option>

                            <?php
                            $queryMhs = "SELECT nim, nama from mahasiswa";
                            $resultMhs = mysqli_query($conn, $queryMhs);
                            while ($mahasiswa = mysqli_fetch_array($resultMhs, MYSQLI_NUM)) {
                                echo "<option value='$mahasiswa[0]'>$mahasiswa[0]</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>



                <div class="mb-3 row align-items-center">
                    <label for="tugas" class="col-sm-2 fw-semibold col-form-label">Tugas</label>
                    <div class="col-sm-10">
                        <input type="number" name="tugas" class="form-control" id="tugas">
                    </div>
                </div>
                <div class="mb-3 row align-items-center">
                    <label for="uts" class="col-sm-2 fw-semibold col-form-label">UTS</label>
                    <div class="col-sm-10">
                        <input type="number" name="uts" class="form-control" id="uts">
                    </div>
                </div>
                <div class="mb-3 row align-items-center">
                    <label for="uas" class="col-sm-2 fw-semibold col-form-label">UAS</label>
                    <div class="col-sm-10">
                        <input type="number" name="uas" class="form-control" id="uas">
                    </div>
                </div>






                <div class="d-flex justify-items-right mt-4">
                    <div class="col-sm-10"></div>
                    <button name="submit" type="submit" class="btn btn-primary col-sm-2 ">Submit</button>
                </div>
            </form>
        <?php
    } else {
        try {

            $nim = $_POST["nim"];
            $nip = $sNIP;
            $tugas = $_POST["tugas"];
            $uts = $_POST["uts"];
            $uas = $_POST["uas"];


            $addNilai = "INSERT INTO nilai VALUES ('$tugas','$uts','$uas','$nim','$nip')";
            $queryNilai = mysqli_query($conn, $addNilai);
            if ($queryNilai) {
                echo "<script>
                alert('Data Berhasil Diupdate!');
                window.location = '../dosen/index.php';
                </script>";
            } else {
                $error = mysqli_error($conn); // Tangkap pesan error
                echo "<script>
                alert('Data Gagal Diupdate! " . addslashes($error) . "');
                window.location = '../dosen/index.php';
                </script>";
            }
        } catch (Exception $e) {
            echo "<script>
            alert('" . addslashes($e->getMessage()) . "');
            window.location = '../dosen/index.php';
            </script>";
        }
    }


        ?>


        </div>
    </body>

    </html>