<?php
include "../koneksi.php";


$queryMhs = "SELECT 
    m.nim, 
    m.nama, 
    m.jurusan,
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
                    Dashboard Mahasiswa
                </h4>
            </a>
            <ul class="nav justify-content-center">
                <li class="nav-item">
                    <a class="nav-link text-black" aria-current="page" href="../admin/index.php">Admin</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-black" href="../dosen/index.php">Dosen</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-black" href="../mahasiswa/index.php">Mahasiswa</a>
                </li>

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
                        <th scope="col">Nama</th>
                        <th scope="col">Jurusan</th>
                        <th scope="col">Mata Kuliah</th>
                        <th scope="col">Nilai Akhir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($dataMhs = mysqli_fetch_array($resultMhs, MYSQLI_NUM)) {
                    ?>
                        <tr>
                            <td><?php echo "$dataMhs[1]" ?></td>
                            <td><?php echo "$dataMhs[2]" ?></td>
                            <td><?php echo "$dataMhs[4]" ?></td>
                            <td><?php echo "$dataMhs[3]" ?></td>
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