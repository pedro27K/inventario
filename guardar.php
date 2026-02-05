<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include "conexion.php";

$id = $_POST['id'] ?? null;
$nombre = $_POST['nombre'];
$stock = $_POST['stock'];

if (isset($_FILES['imagen']) && $_FILES['imagen']['name'] != '') {
    $imagen = $_FILES['imagen']['name'];
    move_uploaded_file($_FILES['imagen']['tmp_name'], "imagenes/$imagen");
} else {
    $imagen = $_POST['imagen_actual'];
}


if ($id) {
    $stmt = $conexion->prepare(
        "UPDATE articulos SET nombre=?, stock=?, imagen=? WHERE id=?"
    );
    $stmt->bind_param("sisi", $nombre, $stock, $imagen, $id);
} else {
    $stmt = $conexion->prepare(
        "INSERT INTO articulos (nombre, stock, imagen) VALUES (?, ?, ?)"
    );
    $stmt->bind_param("sis", $nombre, $stock, $imagen);
}

$stmt->execute();
header("Location: index.php");
