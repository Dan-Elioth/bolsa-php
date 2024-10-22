<?php
include("../includes/head.php");
?>
<!-- Begin Page Content -->
<div class="container-fluid">

  <!-- Section: Design Block -->
  <section class="">
    <!-- Background image -->
    <div class="p-5 shadow" style="
        background-image: url('https://www.migesa.com.mx/wp-content/uploads/2013/10/Bolsa-de-trabajo-Fondo.png');
        height: 250px;
        position: relative;
        overflow: hidden;
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center center;
        border-radius: 0.75rem;
        ">
      <h4 class="text-white ">Acceder al sistema</h4>
      <h7 class="text-gray-400">Ingrese sus credenciales</h7>
    </div>
    <!-- Background image -->

    <div class="card mx-4 mx-md-5 shadow bg-body-tertiary" style="
        margin-top: -100px;
        backdrop-filter: blur(30px);
        border-radius: 0.75rem;
        ">
      <div class="card-body py-4 px-md-4">

        <div class="row d-flex justify-content-center">
          <div class="col-lg-8">
            <form method="POST" action="login.php">

              <?php
              if (isset($_REQUEST['error_login'])) {
              ?>

                <div class="form-group">
                  <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Error</h4>
                    <p>Usuario o contraseña incorrectos</p>
                  </div>
                </div>
              <?php
              }
              ?>

              <div class="form-outline mb-3">
                <label>Correo electrónico</label>
                <input name="txt_usuario" type="email" class="form-control" required />
              </div>

              <!-- Password input -->
              <div class="form-outline mb-3">
                <label>Contraseña</label>
                <input name="txt_password" type="password" class="form-control" required />
              </div>

              <!-- Submit button -->
              <button type="submit" class="btn btn-primary btn-block">
                Iniciar sesión
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
include("../includes/food.php");
?>