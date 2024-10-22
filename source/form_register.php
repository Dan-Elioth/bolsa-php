<?php
include '../includes/head.php';
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Section: Design Block -->
    <section class="">
        <!-- Background image -->
        <div class="p-5 shadow"
            style="
        background-image: url('https://www.migesa.com.mx/wp-content/uploads/2013/10/Bolsa-de-trabajo-Fondo.png');
        height: 250px;
        position: relative;
        overflow: hidden;
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center center;
        border-radius: 0.75rem;
        ">
            <h4 class="text-white ">Registrarse en el sistema</h4>
            <h7 class="text-gray-400">Ingrese todos los datos</h7>
        </div>
        <!-- Background image -->

        <div class="card mx-4 mx-md-5 shadow bg-body-tertiary"
            style="
        margin-top: -100px;
        backdrop-filter: blur(30px);
        border-radius: 0.75rem;
        ">
            <div class="card-body py-4 px-md-4">

                <div class="row d-flex justify-content-center">
                    <div class="col-lg-8">
                        <form method="POST" action="<?php echo RUTAGENERAL; ?>/source/usuario/guardar_usuario.php"
                            id="registrationForm">

                            <div class="form-row mb-3">
                                <div class="col">
                                    <label for="name" class="form-label">Nombre de Usuario</label>
                                    <input type="text" class="form-control" name="name" maxlength="20">
                                </div>
                                <div class="col">
                                    <label for="email" class="form-label">Correo Electrónico</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                            </div>

                            <div class="form-row mb-3">
                                <label for="direccion" class="form-label">Dirección</label>
                                <input type="text" class="form-control" name="direccion" maxlength="20" required>
                                <div class="invalid-feedback">
                                    Completa este campo
                                </div>
                            </div>

                            <div class="form-row mb-3">
                                <div class="col">
                                    <label for="nombres" class="form-label">Nombres </label>
                                    <input type="text" class="form-control" name="nombres" maxlength="20">
                                </div>
                                <div class="col">
                                    <label for="apellidos" class="form-label">Apellidos</label>
                                    <input type="text" class="form-control" name="apellidos" maxlength="20">
                                </div>
                            </div>
                            <div class="form-row mb-3">
                                <div class="col">
                                    <label for="dni" class="form-label">DNI</label>
                                    <input type="tel" pattern="[0-9]*" class="form-control" name="dni"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="8">
                                </div>
                                <div class="col">
                                    <label for="telefono" class="form-label">Teléfono</label>
                                    <input type="tel" pattern="[0-9]*" class="form-control" name="telefono"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="9">
                                </div>
                            </div>
                            <div class="form-row mb-3">
                                <div class="col">
                                    <label for="password" class="form-label">Contraseña</label>
                                    <input type="password" class="form-control" name="password" id="password" required>
                                </div>
                                <div class="col">
                                    <label for="confirm_password" class="form-label">Vuelva a escribir la
                                        contraseña</label>
                                    <input type="password" class="form-control" name="confirm_password"
                                        id="confirm_password" required>
                                </div>
                                <div id="passwordError" class="text-danger" style="display: none;"></div>
                            </div>
                            
                            <!-- Submit button -->
                            <button type="submit" class="btn btn-primary btn-block" id="submitButton">
                                Registrarme
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section: Design Block -->

</div>
<!-- /.container-fluid -->
<?php
include '../includes/food.php';
?>

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
        password.addEventListener("change", validatePassword);
        confirm_password.addEventListener("keyup", validatePassword);
        submitButton.addEventListener("click", validateForm);
        registrationForm.addEventListener("submit", validateEmail);
    });
</script>
