<?php
include "conexion.php";

$textoBuscar = $_GET['buscar'] ?? '';
$tipoOrden = $_GET['orden'] ?? 'ASC';

$sql = "SELECT * FROM articulos WHERE nombre LIKE ? ORDER BY nombre $tipoOrden";
$consulta = $conexion->prepare($sql);

$buscarcomo = "%".$textoBuscar."%";
$consulta->bind_param("s", $buscarcomo);
$consulta->execute();
$datos = $consulta->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de inventario</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Inventario</h1>

<form method="GET" action="">
    <input type="text" name="buscar" placeholder="Escribe para buscar..."
           value="<?php echo htmlspecialchars($textoBuscar); ?>">

    <select name="orden">
    <option value="ASC" <?= $tipoOrden === 'ASC' ? 'selected' : '' ?>>A - Z</option> 
    <option value="DESC" <?= $tipoOrden === 'DESC' ? 'selected' : '' ?>>Z - A</option>
    </select>

    <button type="submit">Buscar</button>
</form>

<p>
    <a href="form.php">+ Nuevo artículo</a>
</p>

<hr>

<?php
if($datos->num_rows > 0){
    while($fila = $datos->fetch_assoc()){
?>
        <div class="articulo">

            <img src="imagenes/<?php echo htmlspecialchars($fila['imagen']); ?>" width="100">

            <div>
                <b><?php echo htmlspecialchars($fila['nombre']); ?></b><br>
                Stock disponible: <?php echo $fila['stock']; ?>
            </div>

            <div>
                <a href="form.php?id=<?php echo $fila['id']; ?>">Editar</a> |
                <a href="eliminar.php?id=<?php echo $fila['id']; ?>"
                   onclick="return confirm('¿Eliminar este artículo?');">
                   Eliminar
                </a>
            </div>

        </div>
        <hr>
<?php
    }
}else{
    echo "<p>No hay artículos registrados.</p>";
}
?>

</body>
</html>
