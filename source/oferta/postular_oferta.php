<?php
include '../../includes/head.php';
include '../../includes/conectar.php';

$conexion = conectar();
$oferta_id = $_GET['id']; // ID de la oferta obtenido de la URL
$usuario_id = $_SESSION['SESSION_USER_ID']; // ID del usuario logueado obtenido de la sesión

// Obtener el título de la oferta laboral
$sql_oferta = "SELECT titulo FROM oferta_laborals WHERE id = '$oferta_id'";
$resultado_oferta = mysqli_query($conexion, $sql_oferta);
$titulo_oferta = '';
if ($fila_oferta = mysqli_fetch_array($resultado_oferta)) {
    $titulo_oferta = $fila_oferta['titulo'];
}

// Obtener el nombre y apellido del usuario
$sql_usuario = "SELECT nombres, apellidos FROM users WHERE id = '$usuario_id'";
$resultado_usuario = mysqli_query($conexion, $sql_usuario);
$nombre_usuario = '';
$apellido_usuario = '';
if ($fila_usuario = mysqli_fetch_array($resultado_usuario)) {
    $nombre_usuario = $fila_usuario['nombres'];
    $apellido_usuario = $fila_usuario['apellidos'];
}
?>

<div class="container-fluid">
    <h1>Postular a la oferta "<?php echo $titulo_oferta; ?>"</h1>
    <p>Por favor, complete el siguiente formulario para postularse a esta oferta.</p>
    <form method="POST" action="guardar_postular_oferta.php" enctype="multipart/form-data">
        <div class="form-row">
            <div class="col mb-3">
                <!-- Input oculto para pasar el ID de la oferta -->
                <label for="oferta_id" class="form-label">Oferta Laboral</label>
                <input type="hidden" class="form-control" name="oferta_id" value="<?php echo $oferta_id; ?>">
                <input type="text" class="form-control" value="<?php echo $titulo_oferta; ?>" disabled>
            </div>
            <div class="col mb-3">
                <!-- Input oculto para pasar el ID del usuario -->
                <label for="usuario_id" class="form-label">Postulante</label>
                <input type="text" class="form-control" name="usuario_id"
                    value="<?php echo $nombre_usuario . ' ' . $apellido_usuario; ?>" disabled>
            </div>
        </div>


        <!-- Otros campos del formulario -->
        <div class="form-row">
            <div class="col mb-3">
                <label for="fecha_hora_postulacion" class="form-label">Fecha y Hora de Postulación</label>
                <input type="datetime-local" class="form-control" name="fecha_hora_postulacion"
                    id="fecha_hora_postulacion" readonly>
            </div>
            <div class="col mb-3">
                <label for="tipo" class="form-label">Tipo</label>
                <input type="text" class="form-control" name="tipo" required>
            </div>
        </div>
        <!-- Campo de archivo -->
        <div class="form-row">
            <div class="col mb-3">
                <label for="archivo" class="form-label">Currículum Vitae (CV)</label>
                <input type="file" class="form-control" name="archivo" required>
            </div>
        </div>
        <div class="form-row" style="display: none;">
            <div class="col mb-3">
                <label for="seleccionado" class="form-label">Seleccionado</label>
                <input type="text" class="form-control" name="seleccionado">
            </div>
        </div>
        <!-- Botón de envío -->
        <button type="submit" name="submit" class="btn btn-primary">Postularse</button>
    </form>

    <script>
        // Esperar a que el DOM esté completamente cargado
        document.addEventListener('DOMContentLoaded', function () {
            // Obtener el elemento del campo de entrada
            var fechaHoraInput = document.getElementById('fecha_hora_postulacion');

            // Obtener la fecha y hora actual
            var fechaHoraActual = new Date();

            // Formatear la fecha y hora actual en un formato que acepta el campo de entrada datetime-local
            var fechaHoraFormateada = fechaHoraActual.getFullYear() + '-' +
                ('0' + (fechaHoraActual.getMonth() + 1)).slice(-2) + '-' +
                ('0' + fechaHoraActual.getDate()).slice(-2) + ' ' +
                ('0' + fechaHoraActual.getHours()).slice(-2) + ':' +
                ('0' + fechaHoraActual.getMinutes()).slice(-2);

            // Establecer el valor del campo de entrada con la fecha y hora actual formateada
            fechaHoraInput.value = fechaHoraFormateada;
        });
    </script>

</div>

<!-- Fin de la lista usuarios -->
<?php
include '../../includes/food.php';
?>