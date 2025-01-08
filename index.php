<?php
include "koneksi.php";
$queryMhs = "SELECT * FROM mahasiswa";
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

<body>
    <nav class="navbar bg-body-tertiary border-bottom border-light-subtle">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="index.php">
                <h4>
                    Dashboard Penilaian Mahasiswa
                </h4>
            </a>
            <a href="add.php" type="button" class="btn btn-success d-flex justify-content-evenly align-items-center gap-1">Add <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                </svg></a>

        </div>
    </nav>

    <div class="container d-flex justify-content-center align-items-center pt-5">

        <?php
        if ($countMhs > 0) {

        ?>
            <table class="table table-striped table-bordered  ">
                <thead>
                    <tr>
                        <th scope="col">NIM</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Jenis Kelamin</th>
                        <th scope="col">Jurusan</th>
                        <th scope="col">Password</th>
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
                            <td>
                                <a href="edit.php?nim=<?php echo "$dataMhs[0]" ?>" type="button" class="btn btn-warning">Edit</a>
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
            echo '<div class="alert alert-primary" role="alert">
  Data Masih Kosong <a href="add.php" class="alert-link">Isi Data Sekarang</a>
</div>';
        }
        ?>

    </div>

</body>

</html>