<?php
include '../../includes/conectar.php';

$conexion = conectar();
session_start();

$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$fecha_publicacion = $_POST['fecha_publicacion'];
$fecha_cierre = $_POST['fecha_cierre'];
$remuneracion = $_POST['remuneracion'];
$ubicacion = $_POST['ubicacion'];
$tipo = $_POST['tipo'];
$empresa_id = $_POST['empresa_id'];

// Procesamiento de la imagen
$imagen_nombre = $_FILES['imagen']['name']; // Nombre original del archivo
$imagen_tmp = $_FILES['imagen']['tmp_name']; // Ubicación temporal del archivo
$carpeta_destino = '../../archivos/oferta/'; // Ruta donde quieres guardar las imágenes

// Mueve la imagen de la ubicación temporal a la carpeta destino
if (move_uploaded_file($imagen_tmp, $carpeta_destino . $imagen_nombre)) {
    // Si la imagen se cargó correctamente, procede a insertar la oferta laboral en la base de datos
    $sql = "INSERT INTO oferta_laborals (titulo, descripcion, fecha_publicacion, fecha_cierre, remuneracion, ubicacion, tipo, empresa_id, imagen) VALUES ('$titulo', '$descripcion', '$fecha_publicacion', '$fecha_cierre', '$remuneracion', '$ubicacion', '$tipo', '$empresa_id', '$imagen_nombre')";

    if (mysqli_query($conexion, $sql)) {
        $_SESSION['guardado'] = true;
        $_SESSION['mensaje'] = 'La oferta se guardó correctamente';
        header('location:listar_ofertas.php');
    } else {
        die('Error al guardar la oferta laboral: ' . mysqli_error($conexion));
    }
} else {
    die('Error al subir la imagen.');
}
?>
