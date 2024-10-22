<?php
include '../../includes/head.php';
include '../../includes/conectar.php';

$conexion = conectar();
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="p-3 shadow-sm mb-4 d-flex align-items-center justify-content-between bg-white"
        style="border-radius: 0.75rem;">
        <div class="text-left align-middle">
            <i class="fas fa-fw fa-folder-open"></i>
            <span class="text-bg-gray-500">Formulario</span>
            / <span class="font-weight-bold">Modificar oferta</span>
        </div>
    </div>

    <?php
    
    // Recibimos el id a modificar
    $pid = $_REQUEST['pid'];
    // Recibimos los datos del formulario
    $sql = "SELECT * FROM oferta_laborals WHERE id='$pid'";
    $registro = mysqli_query($conexion, $sql);
    // En la variable fila tenemos todos los datos que queremos modificar
    $fila = mysqli_fetch_array($registro);
    
    // echo var_dump($fila);
    
    ?>

    <div class="p-3 shadow-sm bg-white" style="border-radius: 0.75rem;">
        <form method="POST" action="editar_oferta.php">
            <input type="hidden" name="idOfertaEditar" value="<?php echo $pid; ?>">
            <div>
                <div class="form-row mb-3">
                    <div class="col">
                        <div class="form-outline mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" name="titulo" value="<?php echo $fila['titulo']; ?>"
                                required>
                            <div class="invalid-feedback">
                                Completa este campo
                            </div>
                        </div>
                        <div class="form-outline">
                            <label for="remuneracion" class="form-label">Remuneración</label>
                            <input type="number" class="form-control" name="remuneracion" value="<?php echo $fila['remuneracion']; ?>"
                                required>
                            <div class="invalid-feedback">
                                Ingresa un número válido
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" name="descripcion" required rows="5"><?php echo $fila['descripcion']; ?></textarea>
                        <div class="invalid-feedback">
                            Completa este campo
                        </div>
                    </div>
                </div>

                <div class="form-row mb-3">
                    <div class="col">

                        <label for="ubicacion" class="form-label">Ubicación</label>
                        <input type="text" class="form-control" name="ubicacion" value="<?php echo $fila['ubicacion']; ?>"
                            required>
                        <div class="invalid-feedback">
                            Completa este campo
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-row">
                            <div class="col">
                                <label for="fecha_publicacion" class="form-label">Fecha de Publicación</label>
                                <input type="date" class="form-control" name="fecha_publicacion"
                                    value="<?php echo $fila['fecha_publicacion']; ?>" id="fecha_publicacion" readonly>
                                <div class="invalid-feedback">
                                    Selecciona una fecha
                                </div>
                            </div>
                            <div class="col">
                                <label for="fecha_cierre" class="form-label">Fecha de Cierre</label>
                                <input type="date" class="form-control" name="fecha_cierre"
                                    value="<?php echo $fila['fecha_cierre']; ?>" id="fecha_cierre" required>
                                <div class="invalid-feedback">
                                    Selecciona una fecha
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-row mb-3">
                    <div class="col">
                        <label for="tipo" class="form-label">Tipo</label>
                        <select class="custom-select" name="tipo" required>
                            <option selected disabled value="">Selecciona...</option>
                            <option value="1" <?php if ($fila['tipo'] == 1) {
                                echo 'selected';
                            } ?>>Presencial</option>
                            <option value="2" <?php if ($fila['tipo'] == 2) {
                                echo 'selected';
                            } ?>>Virtual</option>
                        </select>
                        <div class="invalid-feedback">
                            Selecciona una opción
                        </div>
                    </div>

                    <div class="col">
                        <label for="empresa_id" class="form-label">Empresa</label>
                        <select class="custom-select" name="empresa_id" required>
                            <?php
                            $sql_empresas = 'SELECT * FROM empresas';
                            $empresas = mysqli_query($conexion, $sql_empresas);
                            while ($empresa = mysqli_fetch_array($empresas)) {
                            ?>
                            <option value="<?php echo $empresa['id']; ?>" <?php if ($fila['empresa_id'] == $empresa['id']) {
                                echo 'selected';
                            } ?>><?php echo $empresa['razon_social']; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <div class="invalid-feedback">
                            Selecciona una opción
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <a href="<?php echo RUTAGENERAL; ?>/source/oferta/listar_ofertas.php"
                    class="btn btn-secondary mr-1">Cancelar</a>
                <button type="submit" class="btn btn-primary btn_mostrar">Actualizar Oferta Laboral</button>
                <button type="submit" class="btn btn-primary btn_ocultar">Actualizar</button>
                <style>
                    .btn_ocultar {
                        display: block;
                    }

                    @media screen and (min-width: 410px) {
                        .btn_ocultar {
                            display: none;
                        }
                    }

                    .btn_mostrar {
                        display: none;
                    }

                    @media screen and (min-width: 410px) {
                        .btn_mostrar {
                            display: block;
                        }
                    }
                </style>
            </div>
        </form>
    </div>
</div>

<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
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
    fechaPublicacion.addEventListener('change', function() {
        // Establece la fecha mínima del campo de fecha de cierre como la fecha de publicación
        fechaCierre.min = fechaPublicacion.value;
        // Restablece el valor del campo de fecha de cierre si es anterior a la fecha de publicación
        if (fechaCierre.value < fechaPublicacion.value) {
            fechaCierre.value = fechaPublicacion.value;
        }
    });
</script>

<!-- /.container-fluid -->
<?php
include '../../includes/food.php';
?>
