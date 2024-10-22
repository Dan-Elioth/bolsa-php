<?php
include("../../includes/conectar.php");
$conexion = conectar();

$id = $_GET['id'];

// Obtener el nombre del archivo asociado a la postulación
$sql = "SELECT archivo FROM postulacions WHERE id='$id'";
$resultado = mysqli_query($conexion, $sql);
$fila = mysqli_fetch_assoc($resultado);
$nombreArchivo = $fila['archivo'];

// Eliminar la entrada en la tabla postulacions
$sql_delete = "DELETE FROM postulacions WHERE id='$id'";
mysqli_query($conexion, $sql_delete) or die("Error al eliminar la postulación.");

// Eliminar el archivo físico del servidor
$ruta_archivo = "../../archivos/" . $nombreArchivo;
if (file_exists($ruta_archivo)) {
    unlink($ruta_archivo); // Eliminar el archivo
}

header("Location: listar_postulante.php");
?>
