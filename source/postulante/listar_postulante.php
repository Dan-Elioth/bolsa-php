<?php
include '../../includes/head.php';
include '../../includes/conectar.php';
$conexion = conectar();
?>

<script src="<?php echo RUTAGENERAL; ?>/templates/vendor/jquery/jquery.min.js"></script>

<script>
    // Función para redirigir a la página de edición con el ID de la postulación
    function f_editar(pid) {
        // Redireccionamos hacia el archivo "modificar_postulacion.php" con el ID de la postulación
        window.location.href = "modificar_postulante.php?pid=" + pid;
    }

    // Función para eliminar una postulación
    function eliminarPostulacion(id) {
        if (confirm("¿Estás seguro de que deseas eliminar esta postulación?")) {
            window.location.href = "eliminar_postulante.php?id=" + id;
        }
    }
</script>

<!-- Begin Page Content -->
<div class="container-fluid" align="center">

    <div class="p-3 shadow-sm mb-4 d-flex align-items-center justify-content-between bg-white"
        style="border-radius: 0.75rem;">
        <div class="text-left align-middle">
            <i class="fas fa-fw fa-list"></i>
            <span class="text-bg-gray-500">Tabla</span>
            / <span class="font-weight-bold">Postulaciones</span>
        </div>
    </div>

    <div class="p-3 shadow-sm bg-white" style="border-radius: 0.75rem;">
        <div class="table-responsive" style="border-radius: 0.75rem;">
            <table class="table table-hover table-bordered mb-0 small">
                <thead>
                    <tr class="bg-primary text-white text-center">
                        <th>Foto</th>
                        <th>Postulante</th>
                        <th>Oferta Laboral</th>
                        <th>Fecha y Hora de Postulación</th>
                        <th>Tipo</th>
                        <th>Seleccionado</th>
                        <th>CV</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    // Determinar el rol del usuario
                    $rol_usuario = $_SESSION['SESSION_ROL'] ?? null;
                    $usuario_id = $_SESSION['SESSION_USER_ID'];

                    // Definir la consulta SQL según el rol del usuario
                    if ($rol_usuario == '1') {
                        // Administrador: listar todas las postulaciones
                        $sql = "SELECT p.*, u.nombres AS nombres_usuario, u.apellidos AS apellidos_usuario, u.profile_photo_path, o.titulo AS nombre_oferta FROM postulacions p 
                        INNER JOIN users u ON p.user_id = u.id 
                        INNER JOIN oferta_laborals o ON p.oferta_laboral_id = o.id";
                    } elseif ($rol_usuario == '2') {
                        $userId = $_SESSION['SESSION_USER_ID'];
                        $sql_empresa = "SELECT * FROM empresas WHERE user_id = '{$userId}'";
                        $resultado_empresa = mysqli_query($conexion, $sql_empresa);
                        $empresa = mysqli_fetch_assoc($resultado_empresa);

                        // Ofrecer postulaciones de las ofertas de la empresa del usuario
                        $sql = "SELECT p.*, u.nombres AS nombres_usuario, u.apellidos AS apellidos_usuario, u.profile_photo_path, o.titulo AS nombre_oferta 
                                FROM postulacions p 
                                INNER JOIN users u ON p.user_id = u.id 
                                INNER JOIN oferta_laborals o ON p.oferta_laboral_id = o.id  
                                WHERE o.empresa_id = '{$empresa['id']}'";
                    } elseif ($rol_usuario == '3') {
                        // Listar las postulaciones del Postulante
                        $sql = "SELECT p.*, u.nombres AS nombres_usuario, u.apellidos AS apellidos_usuario, u.profile_photo_path, o.titulo AS nombre_oferta FROM postulacions p 
                        INNER JOIN users u ON p.user_id = u.id 
                        INNER JOIN oferta_laborals o ON p.oferta_laboral_id = o.id WHERE user_id = '$usuario_id'";
                    }

                    // Ejecutar la consulta
                    $registros = mysqli_query($conexion, $sql);

                    while ($fila = mysqli_fetch_array($registros)) {
                        echo "<tr>";
                        // Mostrar imagen
                        $img_path = '../../archivos/perfil/' . $fila['profile_photo_path'];
                        $img_tag = file_exists($img_path) ? "<img src='$img_path' alt='Foto de perfil' width='50' height='50'>" : "<img src='../../archivos/perfil/default.png' alt='Foto de perfil' width='50' height='50'>";
                        echo "<td class='text-center align-middle'>$img_tag</td>";
                        echo "<td class='align-middle'>" . $fila['nombres_usuario'] . " " . $fila['apellidos_usuario'] . "</td>";
                        echo "<td class='align-middle'>" . $fila['nombre_oferta'] . "</td>";
                        echo "<td class='align-middle'>" . $fila['fecha_hora_postulacion'] . "</td>";
                        echo "<td class='align-middle'>" . $fila['tipo'] . "</td>";
                        echo "<td>";
                        if ($fila['seleccionado'] == 1) {
                            echo "Aceptado";
                        } elseif ($fila['seleccionado'] == 2) {
                            echo "Rechazado";
                        } elseif ($fila['seleccionado'] == NULL) {
                            echo "En Proceso";
                        }
                        echo "</td>";
                        echo "<td><a href='../../archivos/" . $fila['archivo'] . "' target='_blank'>Ver archivo</a></td>";
                        echo "<td>";

                        // Otros botones (Editar y Eliminar) se mantienen igual
                    ?>

                    <button onclick="f_editar('<?php echo $fila['id']; ?>')" type="button" class="btn btn-success"
                        title="Editar"><i class="fas fa-edit fa-xs"></i></button>
                    <button onclick="eliminarPostulacion('<?php echo $fila['id']; ?>')" type="button" class="btn btn-danger"
                        title="Eliminar"><i class="far fa-trash-alt fa-xs"></i></button>
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

<!-- Fin de la lista usuarios -->
<?php
include '../../includes/food.php';
?>