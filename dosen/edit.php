<?php
include "../koneksi.php";
$getNIM = $_GET['nim'];
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
                <h4 class="mb-3">Edit Nilai</h4>
                <div class="mb-3 row align-items-center">
                    <label for="nim" class="col-sm-2 fw-semibold col-form-label">NIM</label>
                    <div class="col-sm-10">
                        <input type="text" name="nim" class="form-control" id="nim" readonly value="<?php echo $dataMhs[0] ?>">
                    </div>
                </div>

                <div class="mb-3 row align-items-center">
                    <label for="nama" class="col-sm-2 fw-semibold col-form-label">Nama</label>
                    <div class="col-sm-10">
                        <input type="text" name="nama" class="form-control" id="nama" readonly value="<?php echo $dataMhs[1] ?>">
                    </div>
                </div>

                <div class="mb-3 row align-items-center">
                    <label for="tugas" class="col-sm-2 fw-semibold col-form-label">Tugas</label>
                    <div class="col-sm-10">
                        <input type="number" name="tugas" class="form-control" id="tugas" value="<?php echo $dataMhs[2] ?>">
                    </div>
                </div>
                <div class="mb-3 row align-items-center">
                    <label for="uts" class="col-sm-2 fw-semibold col-form-label">UTS</label>
                    <div class="col-sm-10">
                        <input type="number" name="uts" class="form-control" id="uts" value="<?php echo $dataMhs[3] ?>">
                    </div>
                </div>
                <div class="mb-3 row align-items-center">
                    <label for="uas" class="col-sm-2 fw-semibold col-form-label">UAS</label>
                    <div class="col-sm-10">
                        <input type="number" name="uas" class="form-control" id="uas" value="<?php echo $dataMhs[4] ?>">
                    </div>
                </div>

                <div class="mb-3 row align-items-center">
                    <label for="nip" class="col-sm-2 fw-semibold col-form-label">Dosen</label>
                    <div class="col-sm-10">
                        <option type="text" name="nip" class="form-control" id="nip" readonly value="<?php echo $dataMhs[8] ?>"><?php echo $dataMhs[7] ?></option>
                    </div>
                </div>



                <div class="d-flex justify-items-right mt-4">
                    <div class="col-sm-10"></div>
                    <button name="submit" type="submit" class="btn btn-primary col-sm-2 ">Submit</button>
                </div>
            </form>
        <?php
    } else {
        $nama = $_POST["nama"];
        $tugas = $_POST["tugas"];
        $uts = $_POST["uts"];
        $uas = $_POST["uas"];
        $nim = $_POST["nim"];
        $nip = $_POST["nip"];


        $updateNilai = "UPDATE nilai SET tugas='$tugas',uts='$uts',uas='$uas'WHERE nip='$nip' AND nim = '$nim'";
        $queryNilai = mysqli_query($conn, $updateNilai);
        if ($queryNilai) {
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