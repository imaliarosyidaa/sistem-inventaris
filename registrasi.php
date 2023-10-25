<?php
session_start();
include "config.php";

if (isset($_POST['username'])==true) {
   
    $username = $_POST["username"];
    $password = $_POST["password"];
    $password2 = $_POST["password2"];


//cek user sudah terdaftar atau belum
$result = mysqli_query($conn, "SELECT username FROM users where username ='$username'");

if (mysqli_fetch_assoc($result)) {
    echo "<script>
        alert ('username sudah terdaftar..!!'); window.location.href='registrasi.php'
          </script>";
    return false;
}
  // periksa konfirmasi password baru
    if ( $password !== $password2) {
        
        echo "<script>
                alert ('Konfirmasi Password tidak sama');window.location.href='registrasi.php'
        </script>";
       return false; 
    }
   
   //enkripsi password
   $password2 = hash('sha256', $password);

   // $password = md5($password);
    // var_dump($password);die;  //untuk melihathasil dari md5

    //Tambah user baru

    $sql = mysqli_query($conn, "INSERT INTO users VALUES(NULL,'$username','$password2')");
    // return mysqli_affected_rows($conn);

    if ($sql==true) {
    echo "<script>
        alert ('Berhasil daftar..!!');window.location.href='login.php'
          </script>";
    return false;
}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Registrasi</h1>
        <form method="post" class="mx-auto mt-4" style="max-width: 300px;">
            <?php if (isset($error)) { ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php } ?>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="password2" class="form-label">Konfirmasi Password</label>
                <input type="password" class="form-control" id="konfirmasi_password" name="password2" required>
            </div>
            <button type="submit" class="btn btn-info w-100">Register</button>
            <p style="font-size:15px;margin-top:20px;"class="text-capitalize text-sm text-secondary">Sudah punya akun? <a href="login.php">Login Disini</a></p>
        </form>
    </div>
</body>
</html>