<?php
include "koneksi.php";
$getNIM = $_GET['nim'];
$editMhs = "SELECT * FROM mahasiswa WHERE nim = '$getNIM'";
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
        <nav class="navbar bg-body-tertiary border-bottom border-light-subtle">
            <div class="container-fluid px-4">
                <a class="navbar-brand" href="index.php">
                    <h4>
                        Dashboard Penilaian Mahasiswa
                    </h4>
                </a>


            </div>
        </nav>

        <div class="container ">
            <form class="mt-5 " enctype="multipart/form-data" method="post">
                <h4 class="mb-3">Tambah Mahasiswa</h4>
                <div class="mb-3 row align-items-center">
                    <label for="nim" class="col-sm-2 col-form-label">NIM</label>
                    <div class="col-sm-10">
                        <input type="text" name="nim" class="form-control" id="nim" readonly value="<?php echo $dataMhs[0] ?>">
                    </div>
                </div>
                <div class="mb-3 row align-items-center">
                    <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                        <input type="text" name="nama" class="form-control" id="nama" value="<?php echo $dataMhs[1] ?>">
                    </div>
                </div>
                <div class="mb-3 row align-items-center">
                    <label for="jk" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jk" id="lk" value="Laki-laki" <?= ($dataMhs[2] == 'Laki-laki') ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="lk">
                                Laki-laki
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jk" id="pr" value="Perempuan" <?= ($dataMhs[2] == 'Perempuan') ? 'checked' : ''; ?>>
                            <label class="form-check-label" for="pr">
                                Perempuan
                            </label>
                        </div>
                    </div>

                </div>
                <div class="mb-3 row align-items-center">
                    <label for="jurusan" class="col-sm-2 col-form-label">Jurusan</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="jurusan" name="jurusan" aria-label="Default select example">
                            <option class="bg-secondary text-white" value="<?php echo $dataMhs[3] ?>"><?php echo $dataMhs[3] ?></option>
                            <option value="Sistem Informasi">Sistem Informasi</option>
                            <option value="Teknik Informatika">Teknik Informatika</option>
                            <option value="Hubungan Internasional">Hubungan Internasional</option>
                            <option value="Ilmu Komunikasi">Ilmu Komunikasi</option>
                            <option value="Ilmu Hukum">Ilmu Hukum</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3 row align-items-center">
                    <label for="password" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="password" name="password" class="form-control" id="password" value="<?php echo $dataMhs[4] ?>">
                    </div>
                </div>
                <div class="row justify-items-right mt-4">
                    <div class="col-sm-9"></div>
                    <button name="submit" type="submit" class="btn btn-primary col-sm-3 ">Submit</button>
                </div>
            </form>
        <?php
    } else {
        $nim = $_POST["nim"];
        $nama = $_POST["nama"];
        $jk = $_POST["jk"];
        $jurusan = $_POST["jurusan"];
        $password = md5($_POST["password"]);

        $updateMhs = "UPDATE mahasiswa SET nama='$nama',jk='$jk',jurusan='$jurusan',password='$password' WHERE nim='$nim'";
        $queryMhs = mysqli_query($conn, $updateMhs);
        if ($queryMhs) {
            echo "<script>
            alert('Data Berhasil Diupdate!')
            window.location = 'index.php'
        </script>";
        } else {
            echo "<script>
            alert('Data Gagal Diupdate!')
            window.location = 'index.php'
        </script>";
        }
    }
        ?>


        </div>
    </body>

    </html>