<?php
include("../../includes/head.php");
include("../../includes/conectar.php");

$conexion = conectar();
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="p-3 shadow-sm mb-4 d-flex align-items-center justify-content-between bg-white" style="border-radius: 0.75rem;">
        <div class="text-left align-middle">
            <i class="fas fa-fw fa-building"></i>
            <span class="text-bg-gray-500">Formulario</span>
            / <span class="font-weight-bold">Modificar empresa</span>
        </div>
    </div>

    <?php

    // Recibimos el id a modificar
    $pid = $_REQUEST['pid'];
    // Recibimos los datos del formulario    
    $sql = "SELECT * FROM empresas WHERE id='$pid'";
    $registro = mysqli_query($conexion, $sql);
    // En la variable fila tenemos todos los datos que queremos modificar
    $fila = mysqli_fetch_array($registro);

    // echo var_dump($fila);
    ?>

    <div class="p-3 shadow-sm bg-white" style="border-radius: 0.75rem;">
        <form class="needs-validation" novalidate method="POST" action="editar_empresa.php" autocomplete="off">
            <!-- Agrega un campo oculto para pasar el ID de la empresa -->
            <input type="hidden" name="idEmpresaEditar" value="<?php echo $pid; ?>">

            <div>
                <div class="form-row mb-3">
                    <div class="col">
                        <label for="razon_social" class="form-label">Nombre de Empresa</label>
                        <input type="text" class="form-control" name="razon_social" value="<?php echo $fila['razon_social'] ?>" required>
                        <div class="invalid-feedback">
                            Completa este campo
                        </div>
                    </div>
                    <div class="col">
                        <label for="correo" class="form-label">Correo Electrónico</label>
                        <input type="text" class="form-control" name="correo" value="<?php echo $fila['correo'] ?>" required>
                        <div class="invalid-feedback">
                            Completa este campo
                        </div>
                    </div>
                </div>

                <div class="form-row mb-3">
                    <div class="col">
                        <label for="ruc" class="form-label">RUC</label>
                        <input type="text" class="form-control" name="ruc" value="<?php echo $fila['ruc'] ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                        <div class="invalid-feedback">
                            Completa este campo
                        </div>
                    </div>
                    <div class="col">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="tel" class="form-control" name="telefono" value="<?php echo $fila['telefono'] ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="9" required>
                        <div class="invalid-feedback">
                            Completa este campo
                        </div>
                    </div>
                </div>

                <div class="form-outline mb-3">
                    <label for="direccion" class="form-label">Direccion</label>
                    <input type="text" class="form-control" name="direccion" value="<?php echo $fila['direccion'] ?>" required>
                    <div class="invalid-feedback">
                        Completa este campo
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <a href="<?php echo RUTAGENERAL; ?>/source/empresa/listar_empresas.php" class="btn btn-secondary mr-1">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar Empresa</button>
            </div>
        </form>
    </div>
</div>

<script>
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

<!-- /.container-fluid -->
<?php
include("../../includes/food.php");
?>