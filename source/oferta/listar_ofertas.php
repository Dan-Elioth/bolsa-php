<?php
include("../../includes/head.php");
include("../../includes/conectar.php");
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

        $('#buscar').on('input', function() {
            var searchTerm = $(this).val().toLowerCase();
            $('table tbody tr').each(function() {
                var title = $(this).find('td:eq(0)').text().toLowerCase();
                if (title.includes(searchTerm)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    }); // fin de jQuery

    // Función para redirigir a la página de edición con el ID de la empresa
    function f_editar(pid) {
        // Redireccionamos hacia el archivo "modificar_empresa.php" con el ID de la empresa
        window.location.href = "modificar_oferta.php?pid=" + pid;
    }

    // Función para eliminar una empresa
    function eliminarOferta(id) {
        if (confirm("¿Estás seguro de que deseas eliminar esta oferta?")) {
            window.location.href = "eliminar_oferta.php?id=" + id;
        }
    }

    function f_postular(id) {
        if (confirm("Se va postular esta oferta, desea continuar?")) {
            window.location.href = "postular_oferta.php?id=" + id;
        }
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
<div class="container-fluid" align="center">

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
            <i class="fas fa-fw fa-folder-open"></i>
            <span class="text-bg-gray-500">Tabla</span>
            / <span class="font-weight-bold">Ofertas</span>
        </div>
        <?php
        if ($_SESSION['SESSION_ROL'] == '1' || $_SESSION['SESSION_ROL'] == '2') {
        ?>
            <a href="<?php echo RUTAGENERAL; ?>/source/oferta/registro_ofertas.php" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Nueva Oferta
            </a>
        <?php
        }
        ?>
    </div>

    <div class="p-3 shadow-sm bg-white" style="border-radius: 0.75rem;">

        <div class="form-group">
            <label for="buscar">Buscar por nombre:</label>
            <input type="text" class="form-control" id="buscar" placeholder="Ingrese el nombre">
        </div>

        <div class="table-responsive" style="border-radius: 0.75rem;">
            <table class="table table-hover table-bordered mb-0 small">
                <thead>
                    <tr class="bg-primary text-white text-center">
                        <th>Título</th>
                        <th>Descripción</th>
                        <th>Fecha Publicación</th>
                        <th>Fecha Cierre</th>
                        <th>Remuneracion</th>
                        <th>Ubicacion</th>
                        <th>Tipo</th>
                        <th>Empresa</th>
                        <th>Seleccionado</th>
                        <th>Acciones</th>
                </thead>
                <tbody>
                    <?php
                    // $sql = "SELECT * FROM oferta_laborals";
                    $rol_usuario = $_SESSION['SESSION_ROL'] ?? null;
                    $usuario_id = $_SESSION['SESSION_USER_ID'];

                    if ($rol_usuario == '1' || $rol_usuario == '3') {
                        $sql = "SELECT o.*, e.razon_social AS empresa FROM oferta_laborals o LEFT JOIN empresas e ON o.empresa_id = e.id";
                    } elseif ($rol_usuario == '2') {
                        $sql = "SELECT o.*, e.razon_social AS empresa FROM oferta_laborals o LEFT JOIN empresas e ON o.empresa_id = e.id WHERE e.user_id = '{$usuario_id}'";
                    }
                    $registros = mysqli_query($conexion, $sql);

                    while ($fila = mysqli_fetch_array($registros)) {
                        $oferta_id = $fila['id'];
                        // Verificar si el usuario ya ha postulado a esta oferta
                        $sql_postulado = "SELECT COUNT(*) as total FROM postulacions WHERE oferta_laboral_id = '{$oferta_id}' AND user_id = '{$usuario_id}'";
                        $resultado_postulado = mysqli_query($conexion, $sql_postulado);
                        $postulado = mysqli_fetch_assoc($resultado_postulado)['total'] > 0;

                        $sql_seleccionado = "SELECT u.* 
                            FROM users u 
                            JOIN postulacions p ON u.id = p.user_id 
                            WHERE p.oferta_laboral_id = '{$oferta_id}' AND p.seleccionado = 1";
                        $resultado_seleccionado = mysqli_query($conexion, $sql_seleccionado);
                        $seleccionado = mysqli_fetch_array($resultado_seleccionado);

                        // Verificar si la fecha de cierre es menor que la fecha actual
                        $fecha_cierre = strtotime($fila['fecha_cierre']);
                        $fecha_actual = time();
                        $fecha_cerrada = $fecha_cierre < $fecha_actual;

                        echo "<tr>";
                        echo "<td>" . $fila['titulo'] . "</td>";
                        echo "<td>" . $fila['descripcion'] . "</td>";
                        echo "<td>" . date('d-m-Y', strtotime($fila['fecha_publicacion'])) . "</td>";
                        echo "<td>" . date('d-m-Y', strtotime($fila['fecha_cierre'])) . "</td>";
                        echo "<td>" . $fila['remuneracion'] . "</td>";
                        echo "<td>" . $fila['ubicacion'] . "</td>";
                        echo "<td>" . ($fila['tipo'] == 1 ? 'Presencial' : 'Virtual') . "</td>";
                        echo "<td>" . $fila['empresa'] . "</td>";
                        echo "<td>" . ($seleccionado ? $seleccionado['nombres'] . ' ' . $seleccionado['apellidos'] : '') . "</td>";
                        echo "<td>";
                    ?>
                        <div class="d-flex">
                            <?php
                            if ($_SESSION['SESSION_ROL'] == '1' || $_SESSION['SESSION_ROL'] == '2') {
                            ?>
                                <button onclick="f_editar('<?php echo $fila['id']; ?>')" type="button" class="btn btn-success mx-1" title="Editar"><i class="fas fa-edit fa-xs"></i></button>
                                <button onclick="eliminarOferta('<?php echo $fila['id']; ?>')" type="button" class="btn btn-danger mx-1" title="Eliminar"><i class="far fa-trash-alt fa-xs"></i></button>
                            <?php
                            } else {
                            ?>
                                <button onclick="f_postular('<?php echo $fila['id']; ?>')" type="button" class="btn btn-primary mx-1" title="Postular" <?php echo $postulado || $fecha_cerrada ? 'disabled style="background-color: gray;"' : ''; ?>><i class="fas fa-user-plus fa-xs"></i></button>
                            <?php
                            }
                            ?>
                        </div>
                    <?php
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>

            </table>
        </div>
    </div>
</div>

<!-- Lista de usuarios -->
<div id="div_usuarios" style="display: none;">
    <h1>Lista de usuarios</h1>

    <?php
    // Consulta para obtener la lista de usuarios que no son responsables de ninguna empresa
    $sql_usuarios = "SELECT * FROM users WHERE id NOT IN (SELECT DISTINCT user_id FROM empresas WHERE user_id IS NOT NULL)";
    $registros_usuarios = mysqli_query($conexion, $sql_usuarios);

    // Verificar si hay algún error en la consulta
    if (!$registros_usuarios) {
        echo "Error al obtener la lista de usuarios: " . mysqli_error($conexion);
    } else {
        // Verificar si se encontraron usuarios
        if (mysqli_num_rows($registros_usuarios) > 0) {
            // Mostrar la lista de usuarios
            while ($fila_user = mysqli_fetch_array($registros_usuarios)) {
                echo '<a href="#" onclick="f_asignar(' . $fila_user['id'] . ')">';
                echo $fila_user['dni'] . ' --- ' . $fila_user['nombres'] . ' ---- ' . $fila_user['apellidos'] . '<br>';
                echo '</a>';
            }
        } else {
            echo "No se encontraron usuarios disponibles.";
        }
    }
    ?>

    <button type="button" class="btn btn-primary" onclick="f_limpiar_usuario(ID_EMPRESA)">Limpiar
        usuario</button>
</div>

<!-- Fin de la lista usuarios -->
<?php
include("../../includes/food.php");
?>