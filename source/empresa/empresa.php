<?php
include '../../includes/head.php';
include '../../includes/conectar.php';
$conexion = conectar();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['SESSION_USER_ID'])) {
    // Redirigir a la página de inicio de sesión si el usuario no está autenticado
    header('Location: login.php');
    exit();
}

// Obtener el ID del usuario logueado de la sesión
$usuario_id = $_SESSION['SESSION_USER_ID'];

// Consultar la base de datos para obtener los datos actuales del usuario logueado
// $sql = "SELECT * FROM users WHERE id = '$usuario_id'";
$sql = "SELECT * FROM empresas WHERE user_id = '$usuario_id'";
$resultado = mysqli_query($conexion, $sql);

// Verificar si se encontró algún usuario con el ID proporcionado
if (mysqli_num_rows($resultado) > 0) {
    // Extraer los datos actuales del usuario de la consulta
    $usuario = mysqli_fetch_assoc($resultado);
    $id_actual = $usuario['id'];
    $razon_social_actual = $usuario['razon_social'];
    $ruc_actual = $usuario['ruc'];
    $telefono_actual = $usuario['telefono'];
    $direccion_actual = $usuario['direccion'];
    $correo_actual = $usuario['correo'];
} else {
    // No se encontró ningún usuario con el ID proporcionado, puedes manejar esto según tus necesidades
    // Por ejemplo, puedes redirigir a una página de error o mostrar un mensaje de error en la página actual
}

?>

<!-- Formulario de actualización de datos del usuario -->
<div class="container">
    <h2>Editar Empresa</h2>
    <form method="post" action="editar_empresa.php">
        <input type="hidden" name="idEmpresaEditar" value="<?php echo $id_actual; ?>">

        <div class="form-group">
            <label for="razon_social">Razón Social:</label>
            <input type="text" class="form-control" id="razon_social" name="razon_social" value="<?php echo $razon_social_actual; ?>">
        </div>
        <div class="form-group">
            <label for="ruc">RUC:</label>
            <input type="text" class="form-control" id="ruc" name="ruc" value="<?php echo $ruc_actual; ?>">
        </div>
        <div class="form-group">
            <label for="telefono">Teléfono:</label>
            <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $telefono_actual; ?>">
        </div>
        <div class="form-group">
            <label for="direccion">Dirección:</label>
            <input type="text" class="form-control" id="direccion" name="direccion" value="<?php echo $direccion_actual; ?>">
        </div>
        <div class="form-group">
            <label for="correo">Email:</label>
            <input type="email" class="form-control" id="correo" name="correo" value="<?php echo $correo_actual; ?>">
        </div>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
</div>

<?php include '../../includes/food.php'; ?>
