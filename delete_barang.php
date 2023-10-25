<?php
include "config.php";

$id = $_GET["id"];

$query = "DELETE FROM barang WHERE id = $id";
$conn->query($query);

header("Location: index_barang.php");
exit();
?>
