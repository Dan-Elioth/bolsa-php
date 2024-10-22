<?php
include("../../includes/conectar.php");
$conexion = conectar();
session_start();

$id = $_GET['id'];

$sql = "DELETE FROM empresas WHERE id='$id'";

mysqli_query($conexion, $sql) or die("Error al eliminar la empresa.");

header("Location: listar_empresas.php");

$_SESSION['eliminado'] = true;
$_SESSION['mensaje'] = 'La empresa se eliminó correctamente';

?>