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

// Fungsi untuk mendapatkan data lokasi berdasarkan ID
function getLokasiByID($conn, $id) {
    $result = $conn->query("SELECT * FROM lokasi WHERE id = '$id'");
    return $result->fetch_assoc();
}

// Operasi CRUD

    if (isset($_POST["create"])) {
    	 $id = rand(100,900);
        $nama_lokasi = sanitize($_POST["nama_lokasi"]);
        $query = "INSERT INTO lokasi (id,nama_lokasi) VALUES ('$id','$nama_lokasi')";
        $conn->query($query);
    } elseif (isset($_POST["update"])) {
        $id = $_POST["id"];
        $nama_lokasi = sanitize($_POST["nama_lokasi"]);
        $query = "UPDATE lokasi SET nama_lokasi = '$nama_lokasi' WHERE id = '$id'";
        $conn->query($query);
    } elseif (isset($_GET["edit"])) {
        $edit_id = $_GET["edit"];
        $edit_data = getLokasiByID($conn, $edit_id);
        $edit_nama_lokasi = $edit_data["nama_lokasi"];
    } elseif (isset($_GET["delete"])) {
        $delete_id = $_GET["delete"];
        $query = "DELETE FROM lokasi WHERE id = '$delete_id'";
        $conn->query($query);
    }


$result = $conn->query("SELECT * FROM lokasi");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Lokasi</title>
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
        <h1>"Lokasi"</h1>

        <!-- Form Tambah/Edit -->
        <form method="post">
            <input type="hidden" name="id" value="<?php echo isset($edit_id) ? $edit_id : ''; ?>">
            <div class="mb-3">
                <label for="nama_lokasi" class="form-label">Nama Lokasi</label>
                <input type="text" class="form-control" id="nama_lokasi" name="nama_lokasi" value="<?php echo isset($edit_nama_lokasi) ? $edit_nama_lokasi : ''; ?>" required>
            </div>
            <?php if (isset($edit_id)) { ?>
                <button type="submit" class="btn btn-primary" name="update">Update</button>
                <a href="?cancel" class="btn btn-secondary">Batal</a>
            <?php } else { ?>
                <button type="submit" class="btn btn-info" name="create">Tambah</button>
            <?php } ?>
        </form>

        <!-- Tabel Data Lokasi -->
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Lokasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row["id"]; ?></td>
                        <td><?php echo sanitize($row["nama_lokasi"]); ?></td>
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
