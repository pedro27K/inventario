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

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $id ? "Editar artículo" : "Nuevo artículo"; ?></title>
    <link rel="stylesheet" href="style-form.css">
</head>
<body>

<div class="contenedor">

    <h2><?php echo $id ? "Editar artículo" : "Añadir artículo"; ?></h2>

    <form action="guardar.php" method="post" enctype="multipart/form-data">

        <input type="hidden" name="id" value="<?= $id ?>">
        <input type="hidden" name="imagen_actual" value="<?= $imagen ?>">

        <div class="campo">
            <label>Nombre:</label>
            <input type="text" name="nombre" required value="<?= $nombre ?>">
        </div>

        <div class="campo">
            <label>Stock:</label>
            <input type="number" name="stock" required value="<?= $stock ?>">
        </div>

        <div class="campo">
            <label>Imagen:</label>
            <input type="file" name="imagen">
        </div>

        <div class="botones">
            <button type="submit">Guardar</button>
            <a href="index.php" class="btn-volver">Volver</a>
        </div>

    </form>

</div>

</body>
</html>
