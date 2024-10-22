<?php
    include '../../includes/conectar.php';

    $conexion = conectar();
    session_start();

    $name = $_POST['name'];
    $dni = $_POST['dni'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Comprobar si el correo electrónico ya está registrado
    $sql_check_email = "SELECT * FROM users WHERE email = '$email'";
    $result_check_email = mysqli_query($conexion, $sql_check_email);

    if (mysqli_num_rows($result_check_email) > 0) {
        // Si el correo ya está registrado, redirigir al formulario de registro con un mensaje de error
        header('location: ../form_register.php?error=email_exists');
        $_SESSION['mensaje'] = 'Ha iniciado sesión correctamente';
    } else {
        // Si el correo no está registrado, insertar el nuevo usuario
        $sql = "INSERT INTO users(name, dni, nombres, apellidos, telefono, direccion, email, password, id_rol) VALUES('$name','$dni','$nombres','$apellidos','$telefono', '$direccion', '$email', '$password', '4')";
        mysqli_query($conexion, $sql) or die('Error al guardar.');

        if (isset($_SESSION['SESSION_NOMBRES']) && $_SESSION['SESSION_NOMBRES']) {
            header('location:listar_usuarios.php');
        } else {
            header('location: ../form_login.php');
        }
    }
?>