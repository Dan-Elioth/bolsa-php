<?php
include("../../includes/conectar.php");
$conexion = conectar();
session_start();

$id = $_GET['id'];

$sql = "DELETE FROM oferta_laborals WHERE id='$id'";

mysqli_query($conexion, $sql) or die("Error al eliminar la empresa.");

header("Location:listar_ofertas.php");

$_SESSION['eliminado'] = true;
$_SESSION['mensaje'] = 'La oferta se eliminó correctamente';

?>