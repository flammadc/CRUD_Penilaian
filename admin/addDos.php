<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['role_id'])) {
    header("Location: ../index.php");
    exit;
}

if ($_SESSION['role_id'] == 2) {
    header("Location: ../dosen/index.php");
}
if ($_SESSION['role_id'] == 3) {
    header("Location: ../mahasiswa/index.php");
}
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
                        Dashboard Admin
                    </h4>
                </a>


            </div>
        </nav>

        <div class="container ">
            <form class="mt-5 shadow-sm py-4 px-3 mb-5 bg-light rounded" enctype="multipart/form-data" method="post">
                <h4 class="mb-3">Tambah Dosen</h4>
                <div class="mb-3 row align-items-center">
                    <label for="nip" class="col-sm-2 fw-semibold col-form-label">NIP</label>
                    <div class="col-sm-10">
                        <input type="text" name="nip" class="form-control" id="nip">
                    </div>
                </div>
                <div class="mb-3 row align-items-center">
                    <label for="nama" class="col-sm-2 fw-semibold col-form-label">Nama</label>
                    <div class="col-sm-10">
                        <input type="text" name="nama" class="form-control" id="nama">
                    </div>
                </div>
                <div class="mb-3 row align-items-center">
                    <label for="kode_matkul" class="col-sm-2 fw-semibold col-form-label">Kode Mata Kuliah</label>
                    <div class="col-sm-10">
                        <input type="text" name="kode_matkul" class="form-control" id="kode_matkul">
                    </div>
                </div>
                <div class="mb-3 row align-items-center">
                    <label for="nama_matkul" class="col-sm-2 fw-semibold col-form-label">Nama Mata Kuliah</label>
                    <div class="col-sm-10">
                        <input type="text" name="nama_matkul" class="form-control" id="nama_matkul">
                    </div>
                </div>
                <div class="mb-3 row align-items-center">
                    <label for="password" class="col-sm-2 fw-semibold col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" name="password" class="form-control" id="password">
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

            $nip = $_POST["nip"];
            $nama = $_POST["nama"];
            $kode_matkul = $_POST["kode_matkul"];
            $nama_matkul = $_POST["nama_matkul"];
            $role_id = 2;
            $password = md5($_POST["password"]);

            $insertDos = "INSERT INTO dosen VALUE ('$nip','$nama','$kode_matkul','$password','$role_id')";
            $queryDos = mysqli_query($conn, $insertDos);

            $insertMK = "INSERT INTO matakuliah VALUE ('$kode_matkul','$nama_matkul')";
            $queryMK = mysqli_query($conn, $insertMK);
            if ($queryDos && $queryMK) {
                echo "<script>
            alert('Data Berhasil Disimpan!')
            window.location = 'index.php'
        </script>";
            } else {
                throw new Exception(mysqli_error($conn));
            }
        } catch (Exception $e) {
            echo "<script>
                alert('" . addslashes($e->getMessage()) . "');
                window.location = '../admin/index.php';
                </script>";
        }
    }
        ?>


        </div>
    </body>

    </html>