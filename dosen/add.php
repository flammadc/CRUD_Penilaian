<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['role_id'])) {
    header("Location: ../index.php");
    exit;
}
$getUsername = $_SESSION['username'];

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
        <title>Tambah Nilai</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </head>

    <body class="bg-body">
        <nav class="navbar border-bottom border-light-subtle bg-light">
            <div class="container-fluid px-4">
                <a class="navbar-brand" href="index.php">
                    <h4>
                        Dashboard Dosen
                    </h4>
                </a>

                <button class="btn  d-flex items-center justify-content-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0" />
                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1" />
                    </svg></button>

                <div class="offcanvas offcanvas-end container-fluid " tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                    <div class="offcanvas-header">
                        <h5 class="offcanvas-title" id="offcanvasRightLabel">Welcome! <?php echo $getUsername ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body d-flex flex-column justify-content-between ">
                        <div class="d-flex flex-column gap-3">
                            <div class="list-group">
                                <a href="profile.php" class="list-group-item list-group-item-action">Profile</a>
                            </div>
                            <div class="list-group">
                                <a href="index.php" class="list-group-item list-group-item-action">Nilai Mahasiswa</a>
                            </div>
                            <div class="list-group">
                                <a href="add.php" class="list-group-item list-group-item-action">Tambah Nilai</a>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <a href="../logout.php" type="button" class="d-flex align-items-center justify-content-center gap-2 btn btn-danger fw-semibold px-3 py-2">Logout
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z" />
                                    <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>



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