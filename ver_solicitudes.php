<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Solicitudes de Empleo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1 {
            color: #343a40;
            margin-bottom: 30px;
        }
        .table th {
            background-color: #343a40;
            color: #fff;
            text-align: center;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f2f2f2;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center">Solicitudes Recibidas</h1>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Profesión</th>
                    <th>Correo Electrónico</th>
                    <th>Empresa</th>
                    <th>Vacante</th>
                    <th>Documento</th>
                    <th>Ver</th>
                    <th>Estado</th>
                    <th>Accion</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                session_start();

                // Verificar si el administrador ha iniciado sesión
                if (!isset($_SESSION['admin_id'])) {
                    header("Location: ./admin/login_admin.php");
                    exit();
                }

                // Conexión a la base de datos
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "Marinsa";

                // Crear conexión
                $conn = new mysqli($servername, $username, $password, $database);

                // Verificar conexión
                if ($conn->connect_error) {
                    die("Conexión fallida: " . $conn->connect_error);
                }

                // Consulta SQL para obtener todas las solicitudes con el nombre del puesto, nombre de la vacante y nombre de la empresa
                $sql = "SELECT s.id, s.nombre, s.apellido, s.profesion, s.email, s.archivo, v.puesto AS puesto_postulado, e.nombre AS nombre_empresa, s.revisado
                        FROM solicitudes_empleo s
                        LEFT JOIN vacantes v ON s.vacante_id = v.id
                        LEFT JOIN empresas e ON v.empresa_id = e.id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $index = 1;
                    // Mostrar cada solicitud en la tabla
                    while ($row = $result->fetch_assoc()) {
                        $nombre = htmlspecialchars($row['nombre']);
                        $apellido = htmlspecialchars($row['apellido']);
                        $profesion = htmlspecialchars($row['profesion']);
                        $email = htmlspecialchars($row['email']);
                        $archivo = htmlspecialchars($row['archivo']);
                        $puesto_postulado = htmlspecialchars($row['puesto_postulado']);
                        $nombre_empresa = htmlspecialchars($row['nombre_empresa']);
                        $solicitud_id = $row['id'];
                        $revisado = $row['revisado'];

                        echo '
                        <tr>
                            <td>' . $index . '</td>
                            <td>' . $nombre . '</td>
                            <td>' . $apellido . '</td>
                            <td>' . $profesion . '</td>
                            <td>' . $email . '</td>
                            <td>' . $nombre_empresa . '</td>
                            <td>' . $puesto_postulado . '</td>
                            <td><a href="./archivos_solicitud/' . $archivo . '" target="_blank" class="btn btn-link">' . $archivo . '</a></td>
                            <td>
                                <a href="ver_detalle_solicitud.php?id=' . $solicitud_id . '" class="btn btn-primary btn-sm">Ver Detalle</a>                                
                            </td>
                            <td>';
                            
                        if ($revisado == 0) {
                            echo '<a href="./admin/marcar_revisado.php?id=' . $solicitud_id . '" class="btn btn-info btn-sm">Marcar como Revisado</a>';
                        } else {
                            echo '<span class="badge bg-success">Revisado</span>';
                        }

                        echo '</td>
                            <td>
                                <a href="descargar_archivo.php?id=' . $solicitud_id . '" class="btn btn-success btn-sm">Descargar Archivo</a>
                                
                            </td>
                            <td>
                                
                                <a href="./admin/eliminar_solicitud.php?id=' . $solicitud_id . '" class="btn btn-danger btn-sm" onclick="return confirm(\'¿Estás seguro de eliminar esta solicitud?\')">Eliminar</a>
                            </td>
                        </tr>';
                        
                        $index++;
                    }
                } else {
                    echo '<tr><td colspan="12" class="text-center">No hay solicitudes de empleo registradas.</td></tr>';
                }

                // Cerrar conexión
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
