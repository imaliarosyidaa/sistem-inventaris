<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}
?>
<?php
include "config.php";

// Fungsi untuk menghindari XSS (Cross-Site Scripting)
function sanitize($data) {
    return htmlspecialchars($data);
}

function getJenisByID($conn, $id) {
    $result = $conn->query("SELECT * FROM jenis_barang WHERE id = '$id'");
    return $result->fetch_assoc();
}

// Operasi CRUD

    if (isset($_POST["create"])) {
        $nama_jenis = sanitize($_POST["nama_jenis"]);
        $id = rand(100,900);
        $query = "INSERT INTO jenis_barang (id,nama_jenis) VALUES ('$id','$nama_jenis')";
        $conn->query($query);
    } elseif (isset($_POST["update"])) {
        $id = $_POST["id"];
        $nama_jenis = sanitize($_POST["nama_jenis"]);
        $query = "UPDATE jenis_barang SET nama_jenis = '$nama_jenis' WHERE id = $id";
        $conn->query($query);
    } elseif (isset($_POST["delete"])) {
        $id = $_POST["id"];
        $query = "DELETE FROM jenis_barang WHERE id = $id";
        $conn->query($query);
    }elseif (isset($_GET["edit"])) {
        $edit_id = $_GET["edit"];
        $edit_data = getJenisByID($conn, $edit_id);
        $edit_nama_jenis = $edit_data["nama_jenis"];
    } elseif (isset($_GET["delete"])) {
        $delete_id = $_GET["delete"];
        $query = "DELETE FROM jenis_barang WHERE id = '$delete_id'";
        $conn->query($query);
    }


$result = $conn->query("SELECT * FROM jenis_barang");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jenis Barang</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Sistem Inventaris</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
            <?php include 'menu.php'; ?>
                
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h1>"Jenis Barang"</h1>

        <!-- Form Tambah/Edit -->
        <form method="post">
            <input type="hidden" name="id" value="<?php echo isset($edit_id) ? $edit_id : ''; ?>">
            <div class="mb-3">
                <label for="nama_jenis" class="form-label">Nama Jenis</label>
                <input type="text" class="form-control" id="nama_jenis" name="nama_jenis" value="<?php echo isset($edit_nama_jenis) ? $edit_nama_jenis : ''; ?>" required>
            </div>
            <?php if (isset($edit_id)) { ?>
                <button type="submit" class="btn btn-primary" name="update">Update</button>
                <a href="?cancel" class="btn btn-secondary">Batal</a>
            <?php } else { ?>
                <button type="submit" class="btn btn-info" name="create">Tambah</button>
            <?php } ?>
        </form>

        <!-- Tabel Data Jenis -->
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Jenis</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row["id"]; ?></td>
                        <td><?php echo sanitize($row["nama_jenis"]); ?></td>
                        <td>
                            <a href="?edit=<?php echo $row["id"]; ?>" class="btn btn-info btn-sm">Edit</a>
                            <a href="?delete=<?php echo $row["id"]; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">Hapus</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>

</html>
