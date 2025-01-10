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


$queryMhs = "SELECT 
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
    matakuliah mk ON d.kode_matkul = mk.kode_matkul";
$resultMhs = mysqli_query($conn, $queryMhs);
$countMhs = mysqli_num_rows($resultMhs);

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

<body class="bg-transparent">
    <nav class="navbar bg-body-secondary border-bottom border-light-subtle">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="index.php">
                <h4>
                    Dashboard Admin
                </h4>
            </a>
            <ul class="nav justify-content-center gap-5">
                <li class="nav-item">
                    <a href="../logout.php" type="button" class="btn btn-danger d-flex justify-content-evenly align-items-center gap-1">Logout <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                        </svg>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="addDos.php" type="button" class="btn btn-success d-flex justify-content-evenly align-items-center gap-1">Tambah Dosen <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                        </svg>
                    </a>
                </li>
                <div class="nav-item">
                    <a href="add.php" type="button" class="btn btn-success d-flex justify-content-evenly align-items-center gap-1">Tambah Mahasiswa <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                        </svg>
                    </a>
                </div>


            </ul>




        </div>
    </nav>

    <div class="container  d-flex justify-content-center align-items-center pt-5 ">

        <?php
        if ($countMhs > 0) {

        ?>
            <table class="table  shadow-sm p-3 mb-5 rounded">
                <thead class="table-light">
                    <tr>
                        <th scope="col">NIM</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Tugas</th>
                        <th scope="col">UTS</th>
                        <th scope="col">UAS</th>
                        <th scope="col">Akhir</th>
                        <th scope="col">Matakuliah</th>
                        <th scope="col">Dosen</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($dataMhs = mysqli_fetch_array($resultMhs, MYSQLI_NUM)) {
                    ?>
                        <tr>
                            <th scope="row"><?php echo "$dataMhs[0]" ?></th>
                            <td><?php echo "$dataMhs[1]" ?></td>
                            <td><?php echo "$dataMhs[2]" ?></td>
                            <td><?php echo "$dataMhs[3]" ?></td>
                            <td><?php echo "$dataMhs[4]" ?></td>
                            <td><?php echo "$dataMhs[5]" ?></td>
                            <td><?php echo "$dataMhs[6]" ?></td>
                            <td><?php echo "$dataMhs[7]" ?></td>
                            <td>
                                <a href="edit.php?nim=<?php echo "$dataMhs[0]" ?>&nip=<?php echo "$dataMhs[8]" ?>" type="button" class="btn btn-warning">Edit</a>
                                |
                                <a href="delete.php?nim=<?php echo "$dataMhs[0]" ?>" type="button" class="btn btn-danger">Delete</a>

                            </td>
                        </tr>
                    <?php
                    }

                    ?>
                </tbody>
            </table>
        <?php
        } else {
            echo '<div class="alert alert-primary shadow-sm p-3 mb-5 rounded" role="alert">
                Data Masih Kosong <a href="add.php" class="alert-link">Isi Data Sekarang</a>
                </div>';
        }
        ?>

    </div>

</body>

</html>