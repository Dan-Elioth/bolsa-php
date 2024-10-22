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
$sql = "SELECT * FROM users WHERE id = '$usuario_id'";
$resultado = mysqli_query($conexion, $sql);

// Verificar si se encontró algún usuario con el ID proporcionado
if (mysqli_num_rows($resultado) > 0) {
    // Extraer los datos actuales del usuario de la consulta
    $usuario = mysqli_fetch_assoc($resultado);
    $nombre_usuario_actual = $usuario['name'];
    $dni_actual = $usuario['dni'];
    $nombres_actual = $usuario['nombres'];
    $apellidos_actual = $usuario['apellidos'];
    $telefono_actual = $usuario['telefono'];
    $direccion_actual = $usuario['direccion'];
    $email_actual = $usuario['email'];
    $password_actual = $usuario['password'];
    $profile_photo_path_actual = $usuario['profile_photo_path'];
} else {
    // No se encontró ningún usuario con el ID proporcionado, puedes manejar esto según tus necesidades
    // Por ejemplo, puedes redirigir a una página de error o mostrar un mensaje de error en la página actual
}

?>

<!-- Formulario de actualización de datos del usuario -->
<div class="container">
    <h2>Editar Perfil</h2>
    <form method="post" action="editar_perfil.php" enctype="multipart/form-data">
        <div class="col">
            <div class="form-outline mb-3">
                <label for="profile_photo_path" class="form-label">Imagen</label>
                <div style="border: 1px solid #d1d3e2; border-radius: 0.35rem;" required>
                    <input type="file" class="form-control" id="profile_photo_path" name="profile_photo_path"
                        onchange="mostrarImagen()" style="border: 1px solid #d1d3e2; border-radius: 0.35rem;">
                    <!-- Botón "Ver Archivo" -->
                    <div class="preview-container"
                        style="display: flex; justify-content: center; position: relative; padding-top: 5px; padding-bottom: 5px;">
                        <img id="imagenPrevia" src="<?php echo $profile_photo_path_actual ? '../../archivos/perfil/' .$profile_photo_path_actual : '../../img/no_image.png'; ?>" alt="Vista previa de la imagen"
                            style="display: block; max-width: 100%; max-height: 180px;" required>
                    </div>
                </div>
                <div class="invalid-feedback">
                    Completa este campo
                </div>
            </div>
            <script>
                function mostrarImagen() {
                    var archivoSeleccionado = document.getElementById('profile_photo_path').files[0];
                    var botonVerArchivo = document.getElementById('botonVerArchivo');
                    var imagenPrevia = document.getElementById('imagenPrevia');

                    if (archivoSeleccionado) {
                        var lector = new FileReader();

                        lector.onload = function (evento) {
                            var resultado = evento.target.result;
                            imagenPrevia.src = resultado;
                            archivoModal.src = resultado; // Mostrar la imagen en el modal
                            imagenPrevia.style.display = 'block'; // Mostrar la imagen previa
                        }

                        lector.readAsDataURL(archivoSeleccionado);
                        botonVerArchivo.style.display = 'block';
                    } else {
                        imagenPrevia.src = '../../img/no_image.png';
                        archivoModal.src = '#'; // Limpiar la imagen en el modal si no hay archivo seleccionado
                        imagenPrevia.style.display = 'block'; // Ocultar la imagen previa si no hay ninguna seleccionada
                        botonVerArchivo.style.display = 'none';
                    }
                }
            </script>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name">Nombre de Usuario:</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="<?php echo $nombre_usuario_actual; ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="nombres">Nombres:</label>
                        <input type="text" class="form-control" id="nombres" name="nombres"
                            value="<?php echo $nombres_actual; ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="apellidos">Apellidos:</label>
                        <input type="text" class="form-control" id="apellidos" name="apellidos"
                            value="<?php echo $apellidos_actual; ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="direccion">Dirección:</label>
                        <input type="text" class="form-control" id="direccion" name="direccion"
                            value="<?php echo $direccion_actual; ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="dni">DNI:</label>
                        <input type="text" class="form-control" id="dni" name="dni" value="<?php echo $dni_actual; ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="telefono">Teléfono:</label>
                        <input type="text" class="form-control" id="telefono" name="telefono"
                            value="<?php echo $telefono_actual; ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $email_actual; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password">Contraseña:</label>
                        <input type="text" class="form-control" id="password" name="password" value="<?php echo $password_actual; ?>">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
</div>

<?php include '../../includes/food.php'; ?>