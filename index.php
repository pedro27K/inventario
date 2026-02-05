<?php
include "conexion.php";

$busqueda = $_GET['buscar'] ?? '';
$orden = $_GET['orden'] ?? 'ASC';

/* Consulta con buscador y ordenación */
$sql = "SELECT * FROM articulos WHERE nombre LIKE ? ORDER BY nombre $orden";
$stmt = $conexion->prepare($sql);
$param = "%" . $busqueda . "%";
$stmt->bind_param("s", $param);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Inventario de artículos</h1>

<!-- 🔍 BUSCADOR Y ORDENACIÓN -->
<form method="get">
    <input
        type="text"
        name="buscar"
        placeholder="Buscar artículo"
        value="<?= htmlspecialchars($busqueda) ?>"
    >

    <select name="orden">
        <option value="ASC" <?= $orden === 'ASC' ? 'selected' : '' ?>>A - Z</option>
        <option value="DESC" <?= $orden === 'DESC' ? 'selected' : '' ?>>Z - A</option>
    </select>

    <button type="submit">Buscar</button>
</form>

<!-- ➕ AÑADIR ARTÍCULO -->
<a href="form.php" class="boton-add">➕ Añadir artículo</a>

<hr>

<!-- 📦 LISTADO DE ARTÍCULOS -->
<?php if ($resultado->num_rows > 0): ?>
    <?php while ($art = $resultado->fetch_assoc()): ?>
        <div class="articulo">

            <img src="imagenes/<?= htmlspecialchars($art['imagen']) ?>" alt="Imagen artículo">

            <div class="articulo-info">
                <strong><?= htmlspecialchars($art['nombre']) ?></strong><br>
                Stock: <?= htmlspecialchars($art['stock']) ?>
            </div>

            <div class="articulo-acciones">
                <a href="form.php?id=<?= $art['id'] ?>">✏️ Editar</a>
                <a href="eliminar.php?id=<?= $art['id'] ?>"
                   onclick="return confirm('¿Seguro que quieres eliminar este artículo?')">
                   🗑️ Eliminar
                </a>
            </div>

        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>No se han encontrado artículos.</p>
<?php endif; ?>

</body>
</html>
