<?php
include '../../includes/conectar.php';
$conexion = conectar();
session_start();

// Verificar si se ha enviado el formulario
if(isset($_POST['submit'])) {
    // Obtener los datos del formulario
    $oferta_id = $_POST['oferta_id'];
    session_start(); // Iniciar la sesión si aún no está iniciada
    if(isset($_SESSION['SESSION_USER_ID'])) {
        $usuario_id = $_SESSION['SESSION_USER_ID']; // ID del usuario logueado obtenido de la sesión
    } else {
        echo "ID de usuario no encontrado en la sesión.";
        exit(); // Salir del script si el ID de usuario no está presente en la sesión
    }
    $fecha_hora_postulacion = $_POST['fecha_hora_postulacion'];
    $tipo = $_POST['tipo'];

    // Guardar el archivo
    $archivo_nombre = $_FILES['archivo']['name'];
    $archivo_tmp = $_FILES['archivo']['tmp_name'];
    $archivo_destino = '../../archivos/' . $archivo_nombre; // Ruta donde se guardará el archivo

    // Mover el archivo a la carpeta de destino
    if(move_uploaded_file($archivo_tmp, $archivo_destino)) {
        // Insertar la postulación en la base de datos
        $sql = "INSERT INTO postulacions (user_id, oferta_laboral_id, fecha_hora_postulacion, tipo, archivo) VALUES ('$usuario_id', '$oferta_id', '$fecha_hora_postulacion', '$tipo', '$archivo_nombre')";
        $resultado = mysqli_query($conexion, $sql);

        if($resultado) {
            // Redirigir a una página de éxito si la postulación se crea correctamente
            header('Location: ../postulante/listar_postulante.php');
            exit();
        } else {
            // Manejar cualquier error en la inserción de la postulación
            echo "Error al crear la postulación.";
        }
    } else {
        // Si ocurrió un error al subir el archivo, mostrar un mensaje de error
        echo "Error al subir el archivo.";
    }
} else {
    // Si no se recibió el formulario, redirigir a una página de error o manejar el error de alguna otra manera
    header('Location: error.php');
    exit();
}
?>
