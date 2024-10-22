<?php
include '../../includes/head.php';
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="p-3 shadow-sm mb-4 d-flex align-items-center justify-content-between bg-white"
        style="border-radius: 0.75rem;">
        <div class="text-left align-middle">
            <i class="fas fa-fw fa-user"></i>
            <span class="text-bg-gray-500">Formulario</span>
            / <span class="font-weight-bold">Registrar nuevo usuario</span>
        </div>
    </div>

    <div class="p-3 shadow-sm bg-white" style="border-radius: 0.75rem;">
        <form class="needs-validation" novalidate method="POST" action="guardar_usuario.php" id="registrationForm"
            autocomplete="off">
            <div>
                <div class="form-row mb-3">
                    <div class="col">
                        <label for="name" class="form-label">Nombre de Usuario</label>
                        <input type="text" class="form-control" name="name" maxlength="20" required>
                        <div class="invalid-feedback">
                            Completa este campo
                        </div>
                    </div>
                    <div class="col">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" name="email" required>
                        <div class="invalid-feedback">
                            Completa este campo
                        </div>
                    </div>
                </div>
                <div class="form-row mb-3">
                    <div class="col">
                        <label for="nombres" class="form-label">Nombres </label>
                        <input type="text" class="form-control" name="nombres" maxlength="20" required>
                        <div class="invalid-feedback">
                            Completa este campo
                        </div>
                    </div>
                    <div class="col">
                        <label for="apellidos" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" name="apellidos" maxlength="20" required>
                        <div class="invalid-feedback">
                            Completa este campo
                        </div>
                    </div>
                </div>
                <div class="form-row mb-3">
                    <div class="col">
                        <label for="dni" class="form-label">DNI</label>
                        <input type="tel" pattern="[0-9]*" class="form-control" name="dni"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="8" required>
                        <div class="invalid-feedback">
                            Completa este campo
                        </div>
                    </div>
                    <div class="col">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="tel" pattern="[0-9]*" class="form-control" name="telefono"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="9" required>
                        <div class="invalid-feedback">
                            Completa este campo
                        </div>
                    </div>
                </div>
                <div class="form-row mb-3">
                    <div class="col">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                        <div class="invalid-feedback">
                            Completa este campo
                        </div>
                    </div>
                    <div class="col">
                        <label for="confirm_password" class="form-label">Vuelva a escribir la contraseña</label>
                        <input type="password" class="form-control" name="confirm_password" id="confirm_password"
                            required>
                        <div class="invalid-feedback">
                            Completa este campo o las contraseñas no coinciden
                        </div>
                    </div>
                    <div id="passwordError" class="text-danger" style="display: none;"></div>
                </div>
            </div>
            
            <div class="d-flex justify-content-end">
                <a href="<?php echo RUTAGENERAL; ?>/source/usuario/listar_usuarios.php"
                    class="btn btn-secondary mr-1">Cancelar</a>
                <button type="submit" class="btn btn-primary">Registrar Usuario</button>
            </div>
        </form>
    </div>

    <!-- Fin  de la zona central del sistema -->
</div>
<!-- /.container-fluid -->
<?php
include '../../includes/food.php';
?>

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
    document.addEventListener("DOMContentLoaded", function() {
        var password = document.getElementById("password");
        var confirm_password = document.getElementById("confirm_password");
        var passwordError = document.getElementById("passwordError");
        var submitButton = document.getElementById("submitButton");
        var registrationForm = document.getElementById("registrationForm");

        function validatePassword() {
            if (password.value != confirm_password.value) {
                passwordError.textContent = "Las contraseñas no coinciden";
                confirm_password.setCustomValidity("Las contraseñas no coinciden");
            } else {
                passwordError.textContent = "";
                confirm_password.setCustomValidity("");
            }
        }

        function validateForm(event) {
            if (password.value != confirm_password.value) {
                event.preventDefault(); // Evitar que el formulario se envíe si las contraseñas no coinciden
            }
        }

        function validateEmail() {
            var email = document.getElementById("email");
            var emailRegex = /\S+@\S+\.\S+/;
            if (!emailRegex.test(email.value)) {
                email.setCustomValidity("Ingrese una dirección de correo electrónico válida");
            } else {
                email.setCustomValidity("");
            }

        }

        // Add event listeners
        // password.addEventListener("change", validatePassword);
        // confirm_password.addEventListener("keyup", validatePassword);
        // submitButton.addEventListener("click", validateForm);
        // registrationForm.addEventListener("submit", validateEmail);
    });
</script>
