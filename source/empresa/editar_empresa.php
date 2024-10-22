<?php
include '../../includes/conectar.php';

$conexion = conectar();
session_start();

// Asegúrate de recibir el ID de la empresa a editar
$id = $_POST['idEmpresaEditar'];

$razon_social = $_POST['razon_social'];
$ruc = $_POST['ruc'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];
$direccion = $_POST['direccion']; // Agrega dirección si es necesario

// Actualizar los datos en la base de datos utilizando una consulta UPDATE
$sql = "UPDATE empresas SET razon_social='$razon_social', ruc='$ruc', telefono='$telefono', correo='$correo', direccion='$direccion' WHERE id='$id'";
$resultado = mysqli_query($conexion, $sql);

session_start(); // Inicia la sesión si no lo has hecho ya

// Verifica si existe la variable de sesión del rol del usuario y establece un valor predeterminado si no está definido
$rol_usuario = isset($_SESSION['SESSION_ROL_NAME']); // Cambia 'Usuario' al valor predeterminado adecuado

if ($resultado) {
    // Redirigir a la página correspondiente según el rol del usuario
    if ($rol_usuario === 'Administrador') {
        header('Location: empresa.php');
        $_SESSION['actualizado'] = true;
        $_SESSION['mensaje'] = 'La empresa se actualizó correctamente';
    } else {
        // Redirigir a la página de listado de empresas si la actualización fue exitosa
        header('Location: listar_empresas.php');
        $_SESSION['actualizado'] = true;
        $_SESSION['mensaje'] = 'La empresa se actualizó correctamente';
    }

    exit();
} else {
    // Mostrar un mensaje de error si la actualización falló
    echo 'Error al actualizar la empresa.';
}

