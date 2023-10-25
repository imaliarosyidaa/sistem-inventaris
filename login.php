<?php
session_start();
include "config.php";

if (isset($_POST['username'])==true) {
    # code...

    $username = $_POST["username"];
    $password = $_POST["password"];
    $hashed_password = hash("sha256", $password);

    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$hashed_password'";
    $result = $conn->query($query);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $_SESSION["pass"] = $user["password"];
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["loggedin"] = true;
        header("Location: index.php");
        exit();
    } else {
        $error = "Username atau password salah";
       
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Login</h1>
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
            <button type="submit" class="btn btn-info w-100">Login</button>
        </form>
    </div>
</body>
</html>
