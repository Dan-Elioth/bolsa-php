<?php
include("../../includes/head.php");
include("../../includes/conectar.php");

$conexion = conectar();
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="p-3 shadow-sm mb-4 d-flex align-items-center justify-content-between bg-white" style="border-radius: 0.75rem;">
        <div class="text-left align-middle">
            <i class="fas fa-fw fa-user"></i>
            <span class="text-bg-gray-500">Formulario</span>
            / <span class="font-weight-bold">Modificar usuario</span>
        </div>
    </div>

    <?php

    //recibimos el id a modificar
    $pid = $_REQUEST['pid'];
    //recibimos los datos del formulario    
    $sql = "SELECT * FROM users WHERE id='$pid'";
    $registro = mysqli_query($conexion, $sql);
    //en la variable fila tenemos todos los datos que queremos modificar
    $fila = mysqli_fetch_array($registro);

    // echo var_dump($fila);
    ?>

    <div class="p-3 shadow-sm bg-white" style="border-radius: 0.75rem;">
        <form class="needs-validation" novalidate method="POST" action="editar_usuario.php" autocomplete="off">
            <!-- Agrega un campo oculto para pasar el ID del usuario -->
            <input type="hidden" name="idUsuarioEditar" value="<?php echo $pid; ?>">

            <div>
                <div class="form-row mb-3">
                    <div class="col">
                        <label for="name" class="form-label">Nombre de Usuario</label>
                        <input type="text" class="form-control" name="name" value="<?php echo $fila['name'] ?>" maxlength="20" required>
                        <div class="invalid-feedback">
                            Completa este campo
                        </div>
                    </div>
                    <div class="col">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" name="email" value="<?php echo $fila['email'] ?>" required>
                        <div class="invalid-feedback">
                            Completa este campo
                        </div>
                    </div>
                </div>
                <div class="form-row mb-3">
                    <div class="col">
                        <label for="nombres" class="form-label">Nombres </label>
                        <input type="text" class="form-control" name="nombres" value="<?php echo $fila['nombres'] ?>" maxlength="20" required>
                        <div class="invalid-feedback">
                            Completa este campo
                        </div>
                    </div>
                    <div class="col">
                        <label for="apellidos" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" name="apellidos" value="<?php echo $fila['apellidos'] ?>" maxlength="20" required>
                        <div class="invalid-feedback">
                            Completa este campo
                        </div>
                    </div>
                </div>
                <div class="form-row mb-3">
                    <div class="col">
                        <label for="dni" class="form-label">DNI</label>
                        <input type="tel" pattern="[0-9]*" class="form-control" name="dni" value="<?php echo $fila['dni'] ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="8" required>
                        <div class="invalid-feedback">
                            Completa este campo
                        </div>
                    </div>
                    <div class="col">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="tel" pattern="[0-9]*" class="form-control" name="telefono" value="<?php echo $fila['telefono'] ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="9" required>
                        <div class="invalid-feedback">
                            Completa este campo
                        </div>
                    </div>
                </div>
                <div class="form-row mb-3">
                    <div class="col">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" name="password" value="<?php echo $fila['password'] ?>" id="password" required>
                        <div class="invalid-feedback">
                            Completa este campo
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <a href="<?php echo RUTAGENERAL; ?>/source/usuario/listar_usuarios.php" class="btn btn-secondary mr-1">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
            </div>
        </form>
    </div>

    <!-- Fin  de la zona central del sistema -->
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

<!-- /.container-fluid -->
<?php
include("../../includes/food.php");
?>