<?php
include "conexion.php";

$id = $_GET['id'];

$stmt = $conexion->prepare("DELETE FROM articulos WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: index.php");
