<?php
include '../../includes/head.php';
include '../../includes/conectar.php';

$conexion = conectar();

// Recibimos el id a modificar
$pid = $_REQUEST['pid'];
// Recibimos los datos del formulario
$sql = "SELECT p.*, u.nombres AS nombres_usuario, u.apellidos AS apellidos_usuario, o.titulo AS nombre_oferta FROM postulacions p 
INNER JOIN users u ON p.user_id = u.id 
INNER JOIN oferta_laborals o ON p.oferta_laboral_id = o.id 
WHERE p.id='$pid'";

$registro = mysqli_query($conexion, $sql);
// En la variable fila tenemos todos los datos que queremos modificar
$fila = mysqli_fetch_array($registro);

$ruta_archivos = '../../archivos/';

?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Inicio de la zona central del sistema -->
    <!-- Todo -->
    <h1>Modificación de la Postulación</h1>
    <form method="POST" action="editar_postulante.php" enctype="multipart/form-data">

        <!-- Agrega un campo oculto para pasar el ID de la postulación -->
        <input type="hidden" name="idPostulacionEditar" value="<?php echo $pid; ?>">
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="user_id" class="form-label">Postulante:</label>
                <input type="text" class="form-control" name="user_id" disabled value="<?php echo $fila['nombres_usuario'] . ' ' . $fila['apellidos_usuario']; ?>">
            </div>
            <div class="col-md-6">
                <label for="oferta_laboral_id" class="form-label">Oferta Laboral:</label>
                <input type="text" class="form-control" name="oferta_laboral_id" disabled
                    value="<?php echo $fila['nombre_oferta']; ?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="fecha_hora_postulacion" class="form-label">Fecha y Hora de Postulación</label>
                    <input type="text" class="form-control" name="fecha_hora_postulacion"
                        value="<?php echo $fila['fecha_hora_postulacion']; ?>" disabled>
                </div>
                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo</label>
                    <input type="text" class="form-control" name="tipo" value="<?php echo $fila['tipo']; ?>" disabled>
                </div>
                <?php
                    // Suponiendo que tienes una variable $rol que contiene el rol del usuario
                    $rol = $_SESSION['SESSION_ROL_NAME']; // Por ejemplo, el rol del usuario actual

                    // Definir los roles que pueden ver las opciones
                    $rolesPermitidos = array("Administrador", "Super-Admin");

                    // Verificar si el rol del usuario está permitido para ver las opciones
                    if (in_array($rol, $rolesPermitidos)) {
                        ?>
                                    <div class="mb-3">
                                        <label for="seleccionado" class="form-label">Seleccionado</label>
                                        <select class="form-select" name="seleccionado">
                                            <option value="1" <?php if ($fila['seleccionado'] == 1) {
                                                echo 'selected';
                                            } ?>>Aceptado</option>
                                            <option value="2" <?php if ($fila['seleccionado'] == 2) {
                                                echo 'selected';
                                            } ?>>Rechazado</option>
                                            <?php if ($rol == "Super-Admin") { ?>
                                            <option value="3" <?php if ($fila['seleccionado'] == null) {
                                                echo 'selected';
                                            } ?>>En Proceso</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <?php
                    }
                    ?>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="archivo" class="form-label">Currículum Vitae (CV)</label><br>
                    <?php if (!empty($fila['archivo'])): ?>
                    <div class="row mb-3">
                        <div class="col-md-8">
                            <div id="archivoSeleccionado">
                                <div style="width: 100%;">
                                    <?php
                                    // Obtener la extensión del archivo para decidir cómo mostrarlo
                                    $extension = pathinfo($fila['archivo'], PATHINFO_EXTENSION);
                                    if (in_array($extension, ['pdf'])) {
                                        // Si es un PDF, mostrarlo como un objeto PDF
                                        echo '<embed id="archivoSeleccionado" src="' . $ruta_archivos . $fila['archivo'] . '" type="application/pdf" width="100%" height="200px">';
                                    } else {
                                        // Si es una imagen, mostrarla como tal
                                        echo '<img id="archivoSeleccionado" src="' .
                                            $ruta_archivos .
                                            $fila['archivo'] .
                                            '" class="img-fluid" alt="Archivo Actual"
                                                                                                                                                                                                                                                                                                                                            style="width: 100%; max-width: 300px; max-height: auto; object-fit: cover;">';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <?php echo $fila['archivo']; ?> <br>
                            <button type="button" id="btnAbrirModal" class="btn btn-primary">Ver Archivo</button>
                        </div>
                    </div>

                    <!-- START - Modal de diferentes archivos -->
                    <div id="archivoModal" class="modal">
                        <div class="modal-content">
                            <div id="archivoContenido">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="archivoModalLabel"><?php echo $fila['archivo']; ?></h5>
                                    <span class="close">&times;</span>
                                </div>
                                <div class="modal-body">
                                    <!-- Vista previa del archivo -->
                                    <div id="vistaPreviaArchivo">
                                        <?php
                                        // Obtener la extensión del archivo para decidir cómo mostrarlo
                                        $extension = pathinfo($fila['archivo'], PATHINFO_EXTENSION);
                                        if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                                            // Si es una imagen, mostrarla como tal
                                            echo '<img id="imagenActual" src="' . $ruta_archivos . $fila['archivo'] . '" class="img-fluid">';
                                        } elseif (in_array($extension, ['pdf'])) {
                                            // Si es un PDF, mostrarlo como un objeto PDF
                                            echo '<embed id="pdfActual" src="' . $ruta_archivos . $fila['archivo'] . '#toolbar=0" type="application/pdf" width="100%" height="600px">';
                                        } else {
                                            // Si no es una imagen ni un PDF, mostrar un mensaje de error
                                            echo '<div class="alert alert-danger" role="alert">Formato de archivo no compatible.</div>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END - Modal de diferentes archivos -->

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            // Obtener el input de tipo file
                            var inputArchivo = document.getElementById('nuevo_archivo');

                            // Agregar un evento change para detectar cuando se selecciona un archivo
                            inputArchivo.addEventListener('change', function() {
                                var archivoSeleccionado = inputArchivo.files[0]; // Obtener el archivo seleccionado

                                var modalBody = document.getElementById(
                                    'vistaPreviaArchivo'); // Obtener el cuerpo del modal

                                // Verificar si se ha seleccionado un archivo
                                if (archivoSeleccionado) {
                                    var reader = new FileReader(); // Crear un objeto FileReader

                                    // Evento onload, se ejecuta cuando la lectura del archivo se completa
                                    reader.onload = function() {
                                        var extension = archivoSeleccionado.name.split('.').pop()
                                            .toLowerCase(); // Obtener la extensión del archivo

                                        // Mostrar la vista previa según el tipo de archivo
                                        if (extension === 'pdf') {
                                            modalBody.innerHTML = '<embed src="' + URL.createObjectURL(
                                                    archivoSeleccionado) +
                                                '#toolbar=0" type="application/pdf" width="100%" height="600px">';
                                        } else if (extension === 'jpg' || extension === 'jpeg' || extension === 'png' ||
                                            extension === 'gif') {
                                            modalBody.innerHTML = '<img src="' + URL.createObjectURL(
                                                archivoSeleccionado) + '" class="img-fluid">';
                                        } else {
                                            modalBody.innerHTML =
                                                '<div class="alert alert-danger" role="alert">Formato de archivo no compatible.</div>';
                                        }
                                    };

                                    // Leer el contenido del archivo como una URL de datos
                                    reader.readAsDataURL(archivoSeleccionado);
                                }
                            });
                        });
                    </script>

                    <?php else: ?>
                    <span>No hay archivo asociado</span>
                    <?php endif; ?>
                </div>
                <!-- Input para seleccionar un nuevo archivo -->
                <div class="mb-3">
                    <label for="nuevo_archivo" class="form-label">Editar CV</label>
                    <div style="position: relative; overflow: hidden;">
                        <input type="file" class="form-control" id="nuevo_archivo" name="nuevo_archivo"
                            style="color: white; cursor: pointer;" accept="image/*, application/pdf"
                            placeholder="Seleccionar otro archivo" value="">

                        <div id="textoSeleccionarArchivo"
                            style="position: absolute; top: 9px; left: 9rem; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            Seleccionar otro archivo</div>
                        <script>
                            document.getElementById('nuevo_archivo').addEventListener('change', function() {
                                var archivo = this.files[0];
                                if (archivo) {
                                    var nombreArchivo = archivo.name;
                                    var maxLength = 15; // Cambiar a la longitud máxima deseada
                                    if (nombreArchivo.length > maxLength) {
                                        nombreArchivo = nombreArchivo.substring(0, maxLength - 3) + '...';
                                    }
                                    document.getElementById('textoSeleccionarArchivo').textContent = nombreArchivo;
                                } else {
                                    document.getElementById('textoSeleccionarArchivo').textContent = 'Seleccionar otro archivo';
                                }
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Postulación</button>
    </form>

    <!-- Fin de la zona central del sistema -->
</div>

<!-- Script para cambiar la imagen o PDF al seleccionar un nuevo archivo -->
<script>
    document.getElementById('nuevo_archivo').addEventListener('change', function() {
        var file = this.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(event) {
                var archivoSeleccionado = event.target.result;
                var archivoExtension = file.name.split('.').pop().toLowerCase();
                if (archivoExtension === 'pdf') {
                    document.getElementById('archivoSeleccionado').innerHTML =
                        '<embed id="pdfActual" src="' + archivoSeleccionado +
                        '#toolbar=0" type="application/pdf" width="100%" height="200px" style="width: 100%; max-width: 400px; max-height: auto; object-fit: cover;">';
                } else {
                    document.getElementById('archivoSeleccionado').innerHTML =
                        '<img id="imagenActual" src="' + archivoSeleccionado +
                        '" class="img-fluid" alt="Archivo Actual" style="width: 100%; max-width: 300px; max-height: auto; object-fit: cover;">';
                }
            };
            reader.readAsDataURL(file);
        }
    });
</script>

<script>
    // Obtener el modal y el botón para abrirlo
    var modal = document.getElementById('archivoModal');
    var btnAbrirModal = document.getElementById('btnAbrirModal');

    // Obtener el botón de cierre
    var closeBtn = document.getElementsByClassName("close")[0];

    // Función para abrir el modal
    function abrirModal() {
        modal.style.display = "block";
    }

    // Función para cerrar el modal
    function cerrarModal() {
        modal.style.display = "none";
    }

    // Abrir el modal cuando se hace clic en el botón
    btnAbrirModal.onclick = function() {
        abrirModal();
    }

    // Cerrar el modal cuando se hace clic en el botón de cierre
    closeBtn.onclick = function() {
        cerrarModal();
    }

    // Cerrar el modal cuando se hace clic fuera de él
    window.onclick = function(event) {
        if (event.target == modal) {
            cerrarModal();
        }
    }
</script>

<style>
    /* Estilos para el modal */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.8);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
</style>

<!-- /.container-fluid -->
<?php
include '../../includes/food.php';
?>
