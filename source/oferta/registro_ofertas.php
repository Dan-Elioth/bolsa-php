<?php
include '../../includes/head.php';
include '../../includes/conectar.php';
$conexion = conectar();
?>

<div class="container-fluid">

    <div class="p-3 shadow-sm mb-4 d-flex align-items-center justify-content-between bg-white"
        style="border-radius: 0.75rem;">
        <div class="text-left align-middle">
            <i class="fas fa-fw fa-folder-open"></i>
            <span class="text-bg-gray-500">Formulario</span>
            / <span class="font-weight-bold">Registrar nueva oferta</span>
        </div>
    </div>

    <div class="p-3 shadow-sm bg-white" style="border-radius: 0.75rem;">
        <form enctype="multipart/form-data" method="POST" class="needs-validation" novalidate
            action="guardar_oferta.php" autocomplete="off">
            <div>
                <div class="form-row mb-3">
                    <div class="col">
                        <div class="form-outline mb-3">
                            <label for="empresa_id" class="form-label">Empresa</label>
                            <?php
                            // Verificar si la sesión está configurada y tiene un valor válido
                            if (isset($_SESSION['SESSION_EMPRESA_ID']) && $_SESSION['SESSION_EMPRESA_ID']) {
                                $empresa_id = $_SESSION['SESSION_EMPRESA_ID'];
                            
                                // Consulta preparada para obtener el nombre de la empresa
                                $sql_empresa = 'SELECT razon_social FROM empresas WHERE id = ?';
                                $stmt = mysqli_prepare($conexion, $sql_empresa);
                                mysqli_stmt_bind_param($stmt, 'i', $empresa_id);
                                mysqli_stmt_execute($stmt);
                                mysqli_stmt_bind_result($stmt, $nombre_empresa);
                                mysqli_stmt_fetch($stmt);
                                mysqli_stmt_close($stmt);
                            } else {
                                // Manejar el caso en que la sesión no esté configurada o no tenga un valor válido
                                $nombre_empresa = 'Nombre de empresa no disponible';
                            }
                            ?>
                            <input type="hidden" class="form-control" name="empresa_id"
                                value="<?php echo $empresa_id; ?>">
                            <input type="text" class="form-control" value="<?php echo $nombre_empresa; ?>" disabled>
                        </div>

                        <div class="form-outline mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" name="titulo" required>
                            <div class="invalid-feedback">
                                Completa este campo
                            </div>
                        </div>
                        <div class="col pr-0 pl-0">
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    <label for="remuneracion" class="form-label">Remuneración</label>
                                    <input type="number" class="form-control" name="remuneracion" required>
                                    <div class="invalid-feedback">
                                        Ingresa un número válido
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="tipo" class="form-label">Tipo</label>
                                    <select class="custom-select" name="tipo" required>
                                        <option selected disabled value="">Selecciona...</option>
                                        <option value="1">Presencial</option>
                                        <option value="2">Virtual</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Selecciona una opción
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-outline mb-3">
                            <label for="ubicacion" class="form-label">Ubicación</label>
                            <input type="text" class="form-control" name="ubicacion" required>
                            <div class="invalid-feedback">
                                Completa este campo
                            </div>
                        </div>
                        <div class="form-outline mb-3">
                            <div class="form-row">
                                <div class="col">
                                    <label for="fecha_publicacion" class="form-label">Fecha de Publicación</label>
                                    <input type="date" class="form-control" name="fecha_publicacion"
                                        id="fecha_publicacion" readonly>
                                    <div class="invalid-feedback">
                                        Selecciona una fecha
                                    </div>
                                </div>
                                <div class="col">
                                    <label for="fecha_cierre" class="form-label">Fecha de Cierre</label>
                                    <input type="date" class="form-control" name="fecha_cierre" id="fecha_cierre"
                                        required>
                                    <div class="invalid-feedback">
                                        Selecciona una fecha
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline mb-3">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <textarea class="form-control" name="descripcion" required rows="5"></textarea>
                            <div class="invalid-feedback">
                                Completa este campo
                            </div>
                        </div>

                        <style>
                            @mediascreenand(min-width: 1024px) {

                            /* Estilos para pantallas menores que 1024px */
                            textarea[name="descripcion"] {
                                height: 100px;
                                /* Ajusta la altura del textarea para acomodar 3 filas */
                            }
                            }
                        </style>

                        <div class="form-outline mb-3">
                            <label for="imagen" class="form-label">Imagen</label>
                            <div style="border: 1px solid #d1d3e2; border-radius: 0.35rem;" required>
                                <input type="file" class="form-control" id="imagen" name="imagen"
                                    onchange="mostrarImagen()" required
                                    style="border: 1px solid #d1d3e2; border-radius: 0.35rem;">
                                <!-- Botón "Ver Archivo" -->
                                <div class="preview-container"
                                    style="display: flex; justify-content: center; position: relative; padding-top: 5px; padding-bottom: 5px;">
                                    <img id="imagenPrevia" src="../../img/no_image.png" alt="Vista previa de la imagen"
                                        style="display: block; max-width: 100%; max-height: 180px;" required>
                                    <div id="botonVerArchivo"
                                        style="position: absolute; top: 10px; right: 10px; display: none;">
                                        <button type="button" id="btnAbrirModal" class="btn btn-primary"
                                            onclick="abrirModal()">Ver Archivo</button>
                                    </div>
                                </div>
                            </div>
                            <div class="invalid-feedback">
                                Completa este campo
                            </div>

                            <!-- Modal -->
                            <div class="modal" id="exampleModal">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Archivo</h5>
                                            <button type="button" class="btn-close" onclick="cerrarModal()"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Contenido del archivo se mostrará aquí -->
                                            <img id="archivoModal" src="#" alt="Vista previa de la imagen"
                                                style="max-width: 100%; max-height: 500px;">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                onclick="cerrarModal()">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

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
                                padding: 10px;
                                border: 1px solid #888;
                                width: 100%;
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

                        <script>
                            function mostrarImagen() {
                                var archivoSeleccionado = document.getElementById('imagen').files[0];
                                var botonVerArchivo = document.getElementById('botonVerArchivo');
                                var imagenPrevia = document.getElementById('imagenPrevia');
                                var archivoModal = document.getElementById('archivoModal');

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
                                    archivoModal.src =
                                        '#'; // Limpiar la imagen en el modal si no hay archivo seleccionado
                                    imagenPrevia.style.display =
                                        'block'; // Ocultar la imagen previa si no hay ninguna seleccionada
                                    botonVerArchivo.style.display = 'none';
                                }
                            }

                            function abrirModal() {
                                var modal = document.getElementById('exampleModal');
                                modal.style.display = 'block';
                            }

                            function cerrarModal() {
                                var modal = document.getElementById('exampleModal');
                                modal.style.display = 'none';
                            }
                            var modal = document.getElementById('exampleModal');

                            // Cerrar el modal cuando se hace clic fuera de él
                            window.onclick = function (event) {
                                if (event.target == modal) {
                                    cerrarModal();
                                }
                            }
                        </script>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <a href="<?php echo RUTAGENERAL; ?>/source/oferta/listar_ofertas.php"
                    class="btn btn-secondary mr-1">Cancelar</a>
                <button type="submit" class="btn btn-primary">Registrar Oferta Laboral</button>
            </div>
        </form>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var fechaInput = document.getElementById("fecha_publicacion");
            var fechaActual = new Date().toISOString().split("T")[0];
            fechaInput.value = fechaActual; // Asigna la fecha actual al campo de entrada
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var fechaPublicacionInput = document.getElementById("fecha_publicacion");
            var fechaCierreInput = document.getElementById("fecha_cierre");

            fechaCierreInput.min = fechaPublicacionInput
            .value; // Establece la fecha mínima como la fecha de publicación

            fechaPublicacionInput.addEventListener("change", function () {
                fechaCierreInput.min = fechaPublicacionInput
                .value; // Actualiza la fecha mínima cuando cambia la fecha de publicación
                if (fechaCierreInput.value < fechaPublicacionInput.value) {
                    fechaCierreInput.value = fechaPublicacionInput
                    .value; // Si la fecha de cierre es anterior a la fecha de publicación, establece la fecha de cierre igual a la fecha de publicación
                }
            });
        });
    </script>
</div>

<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
        'use strict';
        window.addEventListener('load', function () {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>

<script>
    var fechaPublicacion = document.getElementById('fecha_publicacion');
    var fechaCierre = document.getElementById('fecha_cierre');

    // Agrega un event listener para detectar cambios en la fecha de publicación
    fechaPublicacion.addEventListener('change', function () {
        // Establece la fecha mínima del campo de fecha de cierre como la fecha de publicación
        fechaCierre.min = fechaPublicacion.value;
        // Restablece el valor del campo de fecha de cierre si es anterior a la fecha de publicación
        if (fechaCierre.value < fechaPublicacion.value) {
            fechaCierre.value = fechaPublicacion.value;
        }
    });
</script>


<?php
include '../../includes/food.php';
?>