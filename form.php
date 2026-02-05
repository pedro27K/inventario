<?php
include "conexion.php";

$id = $_GET['id'] ?? null;
$nombre = $stock = $imagen = "";

if ($id) {
    $stmt = $conexion->prepare("SELECT * FROM articulos WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $art = $stmt->get_result()->fetch_assoc();

    $nombre = $art['nombre'];
    $stock = $art['stock'];
    $imagen = $art['imagen'];
}
?>

<html>
    <form action="guardar.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $id ?>">
    <input type="hidden" name="imagen_actual" value="<?= $imagen ?>">

    <label>Nombre:</label>
    <input type="text" name="nombre" required value="<?= $nombre ?>">

    <label>Stock:</label>
    <input type="number" name="stock" required value="<?= $stock ?>">

    <label>Imagen:</label>
    <input type="file" name="imagen">

    <button type="submit">Guardar</button>
    <a href="index.php">Volver</a>
</form>


</html>