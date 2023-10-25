<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: registrasi.php");
    exit();
}
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Inventaris</title>
</head>

<body >


<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Sistem Inventaris</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            <?php include 'menu.php'; ?>
                
            </div>
        </div>
    </nav>
    

       <div class="container mt-5">
        <div class="jumbotron">
            <h1 class="display-4">Selamat Datang di Sistem Inventaris It</h1>
            <p class="lead">Sistem ini digunakan untuk mengelola data inventaris barang, jenis, dan lokasi.</p>
            <hr class="my-4">
            <p>Silakan navigasi ke bagian Data Barang, Jenis, atau Lokasi untuk memulai.</p>
        </div>
    </div>

    


</html>