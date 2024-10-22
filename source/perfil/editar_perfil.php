<?php
include '../../includes/conectar.php';
$conexion = conectar();

// Verificar si la sesión del usuario está iniciada
session_start();
if (!isset($_SESSION['SESSION_USER_ID'])) {
    // Redirigir al usuario a la página de inicio de sesión si no está autenticado
    header("Location: login.php");
    exit;
}

// Obtener el ID del usuario logueado de la sesión
$usuario_id = $_SESSION['SESSION_USER_ID'];

// Verificar si se ha enviado el formulario de actualización
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los nuevos valores del formulario
    $nombre_usuario_nuevo = $_POST['name'];
    $dni_nuevo = $_POST['dni'];
    $nombres_nuevo = $_POST['nombres'];
    $apellidos_nuevo = $_POST['apellidos'];
    $telefono_nuevo = $_POST['telefono'];
    $direccion_nuevo = $_POST['direccion'];
    $password_nuevo = $_POST['password'];
    $email_nuevo = $_POST['email'];

    // Procesamiento de la imagen
    $imagen_nombre = $_FILES['profile_photo_path']['name']; // Nombre original del archivo
    $imagen_tmp = $_FILES['profile_photo_path']['tmp_name']; // Ubicación temporal del archivo
    $carpeta_destino = '../../archivos/perfil/'; // Ruta donde quieres guardar las imágenes
    $ruta_imagen = $carpeta_destino . $imagen_nombre;

    // Obtener la imagen actual del usuario
    $query_imagen_actual = "SELECT profile_photo_path FROM users WHERE id = '$usuario_id'";
    $resultado_imagen_actual = mysqli_query($conexion, $query_imagen_actual);
    $fila = mysqli_fetch_assoc($resultado_imagen_actual);
    $imagen_actual = $fila['profile_photo_path'];

    // Verificar si se ha seleccionado un archivo
    if ($imagen_nombre) {
        // Si el archivo actual existe, eliminarlo
        if ($imagen_actual && file_exists($carpeta_destino . $imagen_actual)) {
            unlink($carpeta_destino . $imagen_actual);
        }

        // Mover el archivo subido a la carpeta de destino
        if (move_uploaded_file($imagen_tmp, $ruta_imagen)) {
            // El archivo se movió correctamente, actualizar la base de datos
            $sql_actualizar = "UPDATE users SET 
                name = '$nombre_usuario_nuevo', 
                dni = '$dni_nuevo', 
                nombres = '$nombres_nuevo', 
                apellidos = '$apellidos_nuevo', 
                telefono = '$telefono_nuevo', 
                password = '$password_nuevo', 
                direccion = '$direccion_nuevo', 
                email = '$email_nuevo', 
                profile_photo_path = '$imagen_nombre' 
                WHERE id = '$usuario_id'";

            $resultado_actualizar = mysqli_query($conexion, $sql_actualizar);

            if ($resultado_actualizar) {
                // Actualización exitosa, redirigir a la página de perfil con un mensaje de éxito
                header('Location: perfil.php');
                exit();
            } else {
                // Error al actualizar, redirigir a la página de perfil con un mensaje de error
                header('Location: perfil.php?error=1');
                exit();
            }
        } else {
            // Error al mover el archivo, redirigir con un mensaje de error
            header('Location: perfil.php?error=upload');
            exit();
        }
    } else {
        // No se seleccionó ningún archivo, solo actualizar otros campos
        $sql_actualizar = "UPDATE users SET 
            name = '$nombre_usuario_nuevo', 
            dni = '$dni_nuevo', 
            nombres = '$nombres_nuevo', 
            apellidos = '$apellidos_nuevo', 
            telefono = '$telefono_nuevo', 
            password = '$password_nuevo', 
            direccion = '$direccion_nuevo', 
            email = '$email_nuevo' 
            WHERE id = '$usuario_id'";

        $resultado_actualizar = mysqli_query($conexion, $sql_actualizar);

        if ($resultado_actualizar) {
            // Actualización exitosa, redirigir a la página de perfil con un mensaje de éxito
            header('Location: perfil.php');
            exit();
        } else {
            // Error al actualizar, redirigir a la página de perfil con un mensaje de error
            header('Location: perfil.php?error=1');
            exit();
        }
    }
}
?>