<?php
include '../../includes/head.php';
?>
<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="p-3 shadow-sm mb-4 d-flex align-items-center justify-content-between bg-white"
        style="border-radius: 0.75rem;">
        <div class="text-left align-middle">
            <i class="fas fa-fw fa-building"></i>
            <span class="text-bg-gray-500">Formulario</span>
            / <span class="font-weight-bold">Registrar nueva empresa</span>
        </div>
    </div>


    <div class="p-3 shadow-sm bg-white" style="border-radius: 0.75rem;">
        <form class="needs-validation" novalidate method="POST" action="guardar_empresa.php" autocomplete="off">
            <div>
                <div class="form-row mb-3">
                    <div class="col">
                        <label for="razon_social" class="form-label">Nombre de Empresa</label>
                        <input type="text" class="form-control" name="razon_social" required>
                        <div class="invalid-feedback">
                            Completa este campo
                        </div>
                    </div>
                    <div class="col">
                        <label for="correo" class="form-label">Correo Electrónico</label>
                        <input type="text" class="form-control" name="correo" required>
                        <div class="invalid-feedback">
                            Completa este campo
                        </div>
                    </div>
                </div>

                <div class="form-row mb-3">
                    <div class="col">
                        <label for="ruc" class="form-label">RUC</label>
                        <input type="text" class="form-control" name="ruc"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                        <div class="invalid-feedback">
                            Completa este campo
                        </div>
                    </div>
                    <div class="col">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="tel" class="form-control" name="telefono"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="9" required>
                        <div class="invalid-feedback">
                            Completa este campo
                        </div>
                    </div>
                </div>

                <div class="form-outline mb-3">
                    <label for="direccion" class="form-label">Direccion</label>
                    <input type="text" class="form-control" name="direccion" required>
                    <div class="invalid-feedback">
                        Completa este campo
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <a href="<?php echo RUTAGENERAL; ?>/source/empresa/listar_empresas.php"
                    class="btn btn-secondary mr-1">Cancelar</a>
                <button type="submit" class="btn btn-primary">Registrar Empresa</button>
            </div>
        </form>
    </div>
</div>
<div class="form-container">
    <form class="needs-validation" novalidate method="POST" autocomplete="off" action="guardar_empresa.php">
        <div>
            <div class="form-row mb-3">
                <div class="col">
                    <label for="razon_social" class="label form-label">
                        <input type="text" name="razon_social" id="razon_social" placeholder=" "
                            class="input form-control" required>
                        <span class="label-name">Nombre de empresa</span>
                    </label>
                    <div class="invalid-feedback">
                        Completa este campo
                    </div>
                </div>
                <div class="col">
                    <label for="correo" class="label form-label">
                        <input type="email" name="correo" id="correo" placeholder=" " class="input form-control"
                            required>
                        <span class="label-name">Correo Electrónico</span>
                    </label>
                    <div class="invalid-feedback">
                        Completa este campo
                    </div>
                </div>
            </div>

            <div class="form-row mb-3">
                <div class="col">
                    <label for="ruc" class="label form-label">
                        <input type="tel" name="ruc" id="ruc" placeholder=" " class="input form-control"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                        <span class="label-name">RUC</span>
                    </label>
                    <div class="invalid-feedback">
                        Completa este campo
                    </div>
                </div>
                <div class="col">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="tel" class="form-control" name="telefono"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="9" required>
                    <div class="invalid-feedback">
                        Completa este campo
                    </div>
                </div>
            </div>

            <div class="form-outline mb-3">
                <label for="direccion" class="form-label">Direccion</label>
                <input type="text" class="form-control" name="direccion" required>
                <div class="invalid-feedback">
                    Completa este campo
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <a href="<?php echo RUTAGENERAL; ?>/source/empresa/listar_empresas.php"
                class="btn btn-secondary mr-1">Cancelar</a>
            <button type="submit" class="btn btn-primary">Registrar Empresa</button>
        </div>

    </form>

    <style>
        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f7f9fc;
        }

        .form-group {
            position: relative;
            width: 100%;
            max-width: 320px;
        }

        .label {
            position: relative;
            width: 100%;
        }

        .input {
            width: 100%;
            padding: 1rem 1.2rem;
            font-size: 1rem;
            border: 2px solid transparent;
            border-radius: 8px;
            background: #f0f0f0;
            transition: background 0.3s, border-color 0.3s, box-shadow 0.3s;
        }

        .input:focus {
            background: #fff;
            border-color: #007BFF;
            outline: none;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.5);
        }

        .label-name {
            position: absolute;
            top: 50%;
            left: 1.2rem;
            transform: translateY(-50%);
            background: #f0f0f0;
            padding: 0 0.5rem;
            color: #999;
            font-size: 1rem;
            transition: transform 0.3s, color 0.3s, top 0.3s, font-size 0.3s;
            pointer-events: none;
        }

        .input:focus+.label-name,
        .input:not(:placeholder-shown)+.label-name {
            top: 0.05rem;
            transform: translateY(-100%) scale(0.85);
            color: #007BFF;
            font-size: 0.85rem;
            background: #fff;
            padding: 0 0.3rem;
        }

        .label-name::after {
            content: "";
            position: absolute;
            bottom: -0.15rem;
            left: 0.5rem;
            right: 0.5rem;
            height: 2px;
            background: #007BFF;
            transform: scaleX(0);
            transition: transform 0.3s ease-in-out;
        }

        .input:focus+.label-name::after,
        .input:not(:placeholder-shown)+.label-name::after {
            transform: scaleX(1);
        }
    </style>
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

<!-- Fin  de la zona central del sistema -->
<!-- /.container-fluid -->
<?php
include '../../includes/food.php';
?>
