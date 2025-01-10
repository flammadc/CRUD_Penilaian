<?php
session_start();
session_unset(); // Menghapus semua variabel session
session_destroy(); // Menghancurkan sesi

// Redirect ke halaman login setelah logout
header("Location: index.php");
exit;
