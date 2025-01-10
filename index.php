<?php
session_start();
include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check in admin table
    $queryAdmin = "SELECT * FROM admin WHERE username = '$username' AND password = md5('$password');";
    $resultAdmin = mysqli_query($conn, $queryAdmin);

    if (mysqli_num_rows($resultAdmin) == 1) {
        $admin = mysqli_fetch_assoc($resultAdmin);
        $_SESSION['username'] = $username;
        $_SESSION['role_id'] = 1;
        header("Location: admin/index.php");
        exit;
    }

    // Check in dosen table
    $queryDosen = "SELECT * FROM dosen WHERE nip = '$username' AND password = md5('$password');";
    $resultDosen = mysqli_query($conn, $queryDosen);

    if (mysqli_num_rows($resultDosen) == 1) {
        $dosen = mysqli_fetch_assoc($resultDosen);
        $_SESSION['username'] = $username;
        $_SESSION['role_id'] = 2;
        header("Location: dosen/index.php");
        exit;
    }

    // Check in mahasiswa table
    $queryMhs = "SELECT * FROM mahasiswa WHERE nim = '$username' AND password = md5('$password');";
    $resultMhs = mysqli_query($conn, $queryMhs);

    if (mysqli_num_rows($resultMhs) == 1) {
        $mahasiswa = mysqli_fetch_assoc($resultMhs);
        $_SESSION['username'] = $username;
        $_SESSION['role_id'] = 3;
        header("Location: mahasiswa/index.php");
        exit;
    }

    // If no match found
    echo "<div class='alert alert-danger text-center'>Username atau password salah.</div>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Login</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username / NIP / NIM</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>