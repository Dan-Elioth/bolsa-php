<?php
include 'config.php';
session_start();
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="shortcut icon" href="<?php echo RUTAGENERAL; ?>/templates/img/logo_bolsa.png">

    <title>SISTEMA DE BOLSA LABORAL</title>

    <!-- Custom fonts for this template-->
    <link href="<?php echo RUTAGENERAL; ?>/templates/vendor/fontawesome-free/css/all.min.css" rel="stylesheet"
        type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link href="<?php echo RUTAGENERAL; ?>/templates/css/perfect-scrollbar.css" rel="stylesheet">
    <link href="<?php echo RUTAGENERAL; ?>/templates/css/tooltip.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?php echo RUTAGENERAL; ?>/templates/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Estulos par usar jquery ui -->
    <link href="<?php echo RUTAGENERAL; ?>/js/jquery-ui.structure.min.css" rel="stylesheet">
    <link href="<?php echo RUTAGENERAL; ?>/js/jquery-ui.theme.css" rel="stylesheet">

</head>

<body id="page-top">

    <?php
    $current_page = basename($_SERVER['PHP_SELF']);

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    ?>

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Inicio - Sidebar (Menú Izquierdo) -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <div class="d-flex justify-content-center align-items-center py-3">
                <a href="<?php echo RUTAGENERAL; ?>/index.php" title="home" class="text-decoration-none">
                    <div class="d-flex align-items-center text-white" style="gap: 1rem">
                        <i class="fas fa-briefcase" style="font-size: 1.875rem"></i>
                        <div class="d-md-flex flex-column d-sm-none">
                            <span class="fw-semibold" style="font-size: 1rem">Bienvenido a la</span>
                            <span class="italic mt-n1" style="font-size: 0.875rem">BOLSA LABORAL</span>
                        </div>
                    </div>
                </a>
            </div>

            <!-- ROL DEL USUARIO LOGUEADO -->
            <?php
            if (isset($_SESSION['SESSION_ROL'])) {
            ?>
            <div class="mx-3 mt-2">
                <div class="text-white text-center rounded-pill"
                    style="background: linear-gradient(to right, #f59e0b, #f97316); font-size: 0.875rem">
                    <?php
                        echo 'Rol: ', $_SESSION['SESSION_ROL_NAME'];
                        ?>
                </div>
            </div>
            <?php
            } else {
            }
            ?>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <?php
            if (isset($_SESSION['SESSION_NOMBRES'])) {
            ?>
            <li class="nav-item <?php echo ($current_page == 'index.php') ? 'active' : ''; ?>">
                <a class="nav-link" href="<?php echo RUTAGENERAL; ?>/index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <?php
            }
            ?>

            <?php
            if (isset($_SESSION['SESSION_NOMBRES'])) {
            ?>
            <li class="nav-item <?php echo ($current_page == 'perfil.php') ? 'active' : ''; ?>">
                <a class="nav-link" href="<?php echo RUTAGENERAL; ?>/source/perfil/perfil.php">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Mi Perfil</span></a>
            </li>
            <?php
            }
            ?>



            <?php
            if (!isset($_SESSION['SESSION_NOMBRES'])) {
            ?>
            <li class="nav-item <?php echo ($current_page == 'form_register.php') ? 'active' : ''; ?>">
                <a class="nav-link" href="<?php echo RUTAGENERAL; ?>/source/form_register.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Registrarse</span></a>
            </li>
            <?php
            }
            ?>

            <?php
            if (isset($_SESSION['SESSION_ROL']) && ($_SESSION['SESSION_ROL'] == '1')) {
            ?>
            <li
                class="nav-item <?php echo ($current_page == 'listar_usuarios.php' || $current_page == 'registro_usuarios.php') ? 'active' : ''; ?>">
                <a class="nav-link <?php echo ($current_page != 'listar_usuarios.php' && $current_page != 'registro_usuarios.php') ? 'collapsed' : ''; ?>"
                    href="#" data-toggle="collapse" data-target="#collapseUsuario" aria-expanded="true"
                    aria-controls="collapseUsuario">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Usuarios</span>
                </a>
                <div id="collapseUsuario"
                    class="collapse <?php echo ($current_page == 'listar_usuarios.php' || $current_page == 'registro_usuarios.php') ? 'show' : ''; ?>"
                    aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Gestionar oferta:</h6>
                        <a class="collapse-item <?php echo ($current_page == 'listar_usuarios.php') ? 'active' : ''; ?>"
                            href="<?php echo RUTAGENERAL; ?>/source/usuario/listar_usuarios.php">Listar usuarios</a>
                        <a class="collapse-item <?php echo ($current_page == 'registro_usuarios.php') ? 'active' : ''; ?>"
                            href="<?php echo RUTAGENERAL; ?>/source/usuario/registro_usuarios.php">Registrar usuario</a>
                    </div>
                </div>
            </li>
            <?php
            } else {
            ?>

            <?php
            }
            ?>

            <?php
            if (isset($_SESSION['SESSION_ROL']) && $_SESSION['SESSION_ROL'] == '1') {
            ?>
            <li
                class="nav-item <?php echo ($current_page == 'listar_empresas.php' || $current_page == 'registrar_empresa.php') ? 'active' : ''; ?>">
                <a class="nav-link <?php echo ($current_page != 'listar_empresas.php' && $current_page != 'registrar_empresa.php') ? 'collapsed' : ''; ?>"
                    href="#" data-toggle="collapse" data-target="#collapseEmpresa" aria-expanded="true"
                    aria-controls="collapseEmpresa">
                    <i class="fas fa-fw fa-building"></i>
                    <span>Empresas</span>
                </a>
                <div id="collapseEmpresa"
                    class="collapse <?php echo ($current_page == 'listar_empresas.php' || $current_page == 'registrar_empresa.php') ? 'show' : ''; ?>"
                    aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Gestionar empresa:</h6>
                        <a class="collapse-item <?php echo ($current_page == 'listar_empresas.php') ? 'active' : ''; ?>"
                            href="<?php echo RUTAGENERAL; ?>/source/empresa/listar_empresas.php">Listar empresas</a>
                        <a class="collapse-item <?php echo ($current_page == 'registrar_empresa.php') ? 'active' : ''; ?>"
                            href="<?php echo RUTAGENERAL; ?>/source/empresa/registrar_empresa.php">Registrar empresa</a>
                    </div>
                </div>
            </li>
            <?php
            } else {
            }
            ?>

            <?php
            if (isset($_SESSION['SESSION_ROL']) && ($_SESSION['SESSION_ROL'] == '1' || $_SESSION['SESSION_ROL'] == '2')) {
            ?>
            <li
                class="nav-item <?php echo ($current_page == 'listar_ofertas.php' || $current_page == 'registro_ofertas.php') ? 'active' : ''; ?>">
                <a class="nav-link <?php echo ($current_page != 'listar_ofertas.php' && $current_page != 'registro_ofertas.php') ? 'collapsed' : ''; ?>"
                    href="#" data-toggle="collapse" data-target="#collapseOferta" aria-expanded="true"
                    aria-controls="collapseOferta">
                    <i class="fas fa-fw fa-folder-open"></i>
                    <span>Ofertas</span>
                </a>
                <div id="collapseOferta"
                    class="collapse <?php echo ($current_page == 'listar_ofertas.php' || $current_page == 'registro_ofertas.php') ? 'show' : ''; ?>"
                    aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Gestionar oferta:</h6>
                        <a class="collapse-item <?php echo ($current_page == 'listar_ofertas.php') ? 'active' : ''; ?>"
                            href="<?php echo RUTAGENERAL; ?>/source/oferta/listar_ofertas.php">Listar ofertas</a>
                        <a class="collapse-item <?php echo ($current_page == 'registro_ofertas.php') ? 'active' : ''; ?>"
                            href="<?php echo RUTAGENERAL; ?>/source/oferta/registro_ofertas.php">Registrar oferta</a>
                    </div>
                </div>
            </li>
            <?php
            } elseif (isset($_SESSION['SESSION_ROL']) && $_SESSION['SESSION_ROL'] == '3') {
            ?>
            <li class="nav-item <?php echo ($current_page == 'listar_ofertas.php') ? 'active' : ''; ?>">
                <a class="nav-link" href="<?php echo RUTAGENERAL; ?>/source/oferta/listar_ofertas.php">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Ofertas Laborales</span></a>
            </li>
            <?php
            }
            ?>

            <?php
            if (isset($_SESSION['SESSION_ROL']) && ($_SESSION['SESSION_ROL'] == '1' || $_SESSION['SESSION_ROL'] == '2')) {
            ?>
            <li class="nav-item <?php echo ($current_page == 'listar_postulante.php') ? 'active' : ''; ?>">
                <a class="nav-link" href="<?php echo RUTAGENERAL; ?>/source/postulante/listar_postulante.php">
                    <i class="fas fa-fw fa-list"></i>
                    <span>Listar Postulaciones</span>
                </a>
            </li>
            <?php
            } elseif (isset($_SESSION['SESSION_ROL']) && $_SESSION['SESSION_ROL'] == '3') {
            ?>
            <li class="nav-item <?php echo ($current_page == 'listar_postulante.php') ? 'active' : ''; ?>">
                <a class="nav-link" href="<?php echo RUTAGENERAL; ?>/source/postulante/listar_postulante.php">
                    <i class="fas fa-fw fa-list"></i>
                    <span>Mis Postulaciones</span>
                </a>
            </li>
            <?php
            } else {
                // Otros casos o roles no requeridos, aquí puedes agregar más lógica si es necesario
            }
            ?>

            <!-- LOGIN - LOGOUT  -->
            <?php
            if (!isset($_SESSION['SESSION_NOMBRES'])) {
            ?>
            <!-- Nav Item - Iniciar Sesion -->
            <li class="nav-item <?php echo ($current_page == 'form_login.php') ? 'active' : ''; ?>">
                <a class="nav-link" href="<?php echo RUTAGENERAL; ?>/source/form_login.php">
                    <i class="fas fa-fw fa-sign-in-alt"></i>
                    <span>Iniciar Sesion</span></a>
            </li>

            <?php
            } else {
            ?>

            <!-- Nav Item - Iniciar Sesion -->
            <li class="nav-item">
                <a class="nav-link" href="<?php echo RUTAGENERAL; ?>/source/logout.php">
                    <i class="fas fa-fw fa-power-off"></i>
                    <span>Cerrar Sesion</span></a>
            </li>
            <?php
            }
            ?>
        </ul>
        <!-- Fin - Sidebar (Menú Izquierdo) -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content" class="bg-gray-100">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow-sm">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <?php

                    if (isset($_SESSION['SESSION_NOMBRES'])) {
                        echo 'BIENVENIDO: ', $_SESSION['SESSION_NOMBRES'], ' ', $_SESSION['SESSION_APELLIDOS'];

                        // Verificar si el usuario está asignado a una empresa
                        if (isset($_SESSION['SESSION_EMPRESA'])) {
                            echo ' - Empresa: ', $_SESSION['SESSION_EMPRESA']; 
                        } else {
                            echo '';
                        }
                    } else {
                        echo 'INICIAR SESION';
                    }
                    ?>
                </nav>
                <!-- End of Topbar -->