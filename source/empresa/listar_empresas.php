<?php
include '../../includes/head.php';
include '../../includes/conectar.php';
$conexion = conectar();
?>

<script src="<?php echo RUTAGENERAL; ?>/templates/vendor/jquery/jquery.min.js"></script>

<script>
    var ID_EMPRESA; // esta es una variable global 

    $(document).ready(function() { // inicio de jQuery
        $('#div_usuarios').dialog({
            width: 600,
            height: 400,
            title: "Lista usuarios"
        });
        $('#div_usuarios').dialog("close");
    }); // fin de jQuery

    // Función para redirigir a la página de edición con el ID de la empresa
    function f_editar(pid) {
        // Redireccionamos hacia el archivo "modificar_empresa.php" con el ID de la empresa
        window.location.href = "modificar_empresa.php?pid=" + pid;
    }

    // Función para eliminar una empresa
    function eliminarEmpresa(id) {
        if (confirm("¿Estás seguro de que deseas eliminar esta empresa?")) {
            window.location.href = "eliminar_empresa.php?id=" + id;
        }
    }

    // Función para mostrar los usuarios y asignar uno a una empresa
    function f_mostrar_usuarios(id) {
        ID_EMPRESA = id;
    }

    // Función para asignar un usuario a una empresa
    function f_asignar(id_usuario) {
        $.ajax({
            type: "POST",
            url: "asignar_usuario_empresa.php",
            data: {
                id_empresa: ID_EMPRESA,
                id_usuario: id_usuario
            },
            success: function(response) {
                alert(response); // Muestra el mensaje de respuesta del servidor
                location.reload(); // Recarga la página después de la asignación exitosa
            },
            error: function(xhr, status, error) {
                alert("Error al asignar usuario a la empresa: " +
                    error); // Muestra un mensaje de error si la asignación falla
            }
        });
    }


    function f_limpiar_usuario(id_empresa) {
        $.ajax({
            type: "POST",
            url: "limpiar_usuario_empresa.php",
            data: {
                id_empresa: id_empresa
            },
            success: function(response) {
                alert(response); // Muestra el mensaje de respuesta del servidor
                location.reload(); // Recarga la página después de la limpieza exitosa
            },
            error: function(xhr, status, error) {
                alert("Error al limpiar usuario de la empresa: " +
                    error); // Muestra un mensaje de error si la limpieza falla
            }
        });
    }

    function f_mensaje() {
        $('.toast').toast('show');
    }

    $(document).ready(function() {
        <?php
        if (isset($_SESSION['guardado']) && $_SESSION['guardado']  || isset($_SESSION['eliminado']) && $_SESSION['eliminado'] || isset($_SESSION['actualizado']) && $_SESSION['actualizado']) {
        ?>
            f_mensaje();
            <?php unset($_SESSION['guardado']); ?>
            <?php unset($_SESSION['actualizado']); ?>
            <?php unset($_SESSION['eliminado']); ?>
        <?php
        }
        ?>
    });
</script>

<!-- Begin Page Content -->
<div class="container-fluid">

    <div class="position-fixed top-0 right-0 p-3" style="z-index: 5; right: 0; top: 0;">
        <div id="liveToast" class="toast hide overflow-hidden" style="border-radius: 0.5rem;" role="alert" aria-live="assertive" aria-atomic="true" data-delay="3000">
            <div class="toast-header">
                <strong class="mr-auto">Mensaje del sistema:</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body bg-success text-white">
                <i class="fas fa-check-circle"></i> <?php echo $_SESSION['mensaje']; ?>
            </div>
        </div>
    </div>

    <div class="p-3 shadow-sm mb-4 d-flex align-items-center justify-content-between bg-white" style="border-radius: 0.75rem;">
        <div class="text-left align-middle">
            <i class="fas fa-fw fa-building"></i>
            <span class="text-bg-gray-500">Tabla</span>
            / <span class="font-weight-bold">Empresas</span>
        </div>
        <a href="<?php echo RUTAGENERAL; ?>/source/empresa/registrar_empresa.php" class="btn btn-primary">
            <i class="fas fa-plus"></i>
            Nueva Empresa
        </a>
    </div>

    <div class="p-3 shadow-sm bg-white" style="border-radius: 0.75rem;">
        <div class="table-responsive" style="border-radius: 0.75rem; ">
            <table class="table table-hover table-bordered mb-0 small">
                <thead>
                    <tr class="bg-primary text-white text-center">
                        <th>RUC</th>
                        <th>Razón Social</th>
                        <th>Teléfono</th>
                        <th>Correo Electrónico</th>
                        <th>Dirección</th>
                        <th>Usuario Asignado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT e.*, u.nombres AS nombre_usuario, u.apellidos AS apellido_usuario FROM empresas e LEFT JOIN users u ON e.user_id = u.id";
                    $registros = mysqli_query($conexion, $sql);

                    while ($fila = mysqli_fetch_array($registros)) {
                        echo "<tr>";
                        echo "<td class='align-middle'>" . $fila['ruc'] . "</td>";
                        echo "<td class='align-middle'>" . $fila['razon_social'] . "</td>";
                        echo "<td class='align-middle'>" . $fila['telefono'] . "</td>";
                        echo "<td class='align-middle'>" . $fila['correo'] . "</td>";
                        echo "<td class='align-middle'>" . $fila['direccion'] . "</td>";
                        echo "<td class='align-middle'>" . $fila['nombre_usuario'] . " " . $fila['apellido_usuario'] . "</td>"; // Mostrar nombre y apellido del usuario
                        echo "<td class='d-flex'>";

                        // Verificar si el usuario está asignado o no
                        if ($fila['user_id'] != null) {
                            // Usuario asignado, mostrar botón para quitar usuario
                    ?>
                            <button onclick="f_limpiar_usuario('<?php echo $fila['id']; ?>')" type="button" class="tooltip-container btn btn-secondary mx-1">
                                <i class="fas fa-user-slash fa-xs"></i>
                                <span class="tooltips tooltip-left">Quitar usuario</span>
                            </button>
                        <?php
                        } else {
                            // Usuario no asignado, mostrar botón para asignar usuario
                        ?>
                            <button onclick="f_mostrar_usuarios('<?php echo $fila['id']; ?>')" type="button" class="tooltip-container btn btn-primary mx-1" data-toggle="modal" data-target="#modalUsuarios">
                                <i class="fas fa-user-plus fa-xs"></i>
                                <span class="tooltips tooltip-left">Agregar usuario</span>
                            </button>
                        <?php
                        }
                        ?>
                        <button onclick="f_editar('<?php echo $fila['id']; ?>')" type="button" class="tooltip-container btn btn-success mx-1">
                            <i class="fas fa-edit fa-xs"></i>
                            <span class="tooltips tooltip-top">Editar</span>
                        </button>
                        <button onclick="eliminarEmpresa('<?php echo $fila['id']; ?>')" type="button" class="tooltip-container btn btn-danger mx-1">
                            <i class="far fa-trash-alt fa-xs"></i>
                            <span class="tooltips tooltip-top">Eliminar</span>
                        </button>
                        </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalUsuarios" tabindex="-1" aria-labelledby="modalUsuariosLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalUsuariosLabel">Lista de usuarios</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive shadow" style="max-height: 17rem; border-radius: 0.75rem;">
                    <table class="table table-hover table-bordered mb-0 small">
                        <thead>
                            <tr class="bg-primary text-white text-center">
                                <th>DNI</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Consulta para obtener la lista de usuarios que no son responsables de ninguna empresa
                            $sql_usuarios = 'SELECT * FROM users WHERE id NOT IN (SELECT DISTINCT user_id FROM empresas WHERE user_id IS NOT NULL)';
                            $registros_usuarios = mysqli_query($conexion, $sql_usuarios);

                            // Verificar si hay algún error en la consulta
                            if (!$registros_usuarios) {
                                echo 'Error al obtener la lista de usuarios: ' . mysqli_error($conexion);
                            } else {
                                // Verificar si se encontraron usuarios
                                if (mysqli_num_rows($registros_usuarios) > 0) {
                                    // Mostrar la lista de usuarios
                                    while ($fila_user = mysqli_fetch_array($registros_usuarios)) {
                                        echo '<tr style="cursor: pointer;" onclick="f_asignar(' . $fila_user['id'] . ')">';
                                        echo "<td class='align-middle'>" . $fila_user['dni'] . "</td>";
                                        echo "<td class='align-middle'>" . $fila_user['nombres'] . "</td>";
                                        echo "<td class='align-middle'>" . $fila_user['apellidos'] . "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo '<tr>';
                                    echo "<td colspan='3' class='align-middle text-center'>" . 'No se encontraron usuarios disponibles.' . "</td>";
                                    echo "</tr>";
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- Fin de la lista usuarios -->
<?php
include '../../includes/food.php';
?>