<?php
include '../../includes/conectar.php';

$conexion = conectar();
session_start();
// $_SESSION['SESSION_USER_ID'] = $user_id;
$usuario_id = $_SESSION['SESSION_USER_ID'];

// Consultar la información del usuario
$sql_usuario = "SELECT nombres, apellidos FROM users WHERE id = '$usuario_id'";
$resultado = mysqli_query($conexion, $sql_usuario);

if ($resultado && mysqli_num_rows($resultado) > 0) {
    $fila = mysqli_fetch_assoc($resultado);
    $nombre_usuario = $fila['nombres'];
    $apellido_usuario = $fila['apellidos'];
} else {
    // Manejar el caso en el que no se encuentre al usuario
    $nombre_usuario = 'Nombre no encontrado';
    $apellido_usuario = 'Apellido no encontrado';
}

$razon_social = $_POST['razon_social'];
$ruc = $_POST['ruc'];
$telefono = $_POST['telefono'];
$correo = $_POST['correo'];
$direccion = $_POST['direccion'];

$sql = "INSERT INTO empresas (razon_social, ruc, telefono, correo, direccion) VALUES ('$razon_social', '$ruc', '$telefono', '$correo','$direccion')";
mysqli_query($conexion, $sql) or die('Error al guardar la empresa.');

header('location:listar_empresas.php');

$_SESSION['guardado'] = true;
$_SESSION['mensaje'] = 'La empresa se guardó correctamente';

?>
