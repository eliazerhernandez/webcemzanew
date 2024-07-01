<?php
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

// Verificar que se haya recibido el parámetro 'id'
if (isset($_GET['id'])) {
    $solicitud_id = intval($_GET['id']);

    // Consulta SQL para obtener los detalles de la solicitud basada en el ID
    $sql = "SELECT s.nombre, s.apellido, s.profesion, s.email, s.archivo, s.fecha_envio, v.puesto, e.nombre AS nombre_empresa
            FROM solicitudes_empleo s
            INNER JOIN vacantes v ON s.vacante_id = v.id
            INNER JOIN empresas e ON v.empresa_id = e.id
            WHERE s.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $solicitud_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $solicitud = $result->fetch_assoc();
        ?>

        <!DOCTYPE html>
        <html lang="es">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <title>Detalle de Solicitud de Empleo</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                }
                .table th {
                    background-color: #343a40;
                    color: #fff;
                }
                .btn-primary {
                    background-color: #343a40;
                    border-color: #343a40;
                }
                .btn-primary:hover {
                    background-color: #495057;
                    border-color: #495057;
                }
                .header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 20px;
                }
            </style>
        </head>
        <body class="m-2">
        <div class="container">
            <div class="header">
                <h1>Detalles de la solicitud</h1>
                <a href="ver_solicitudes.php" class="btn btn-primary">Volver a la lista de solicitudes</a>
            </div>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Nombre</th>
                        <td><?php echo htmlspecialchars($solicitud['nombre']); ?></td>
                    </tr>
                    <tr>
                        <th>Apellido</th>
                        <td><?php echo htmlspecialchars($solicitud['apellido']); ?></td>
                    </tr>
                    <tr>
                        <th>Profesión</th>
                        <td><?php echo htmlspecialchars($solicitud['profesion']); ?></td>
                    </tr>
                    <tr>
                        <th>Correo Electrónico</th>
                        <td><?php echo htmlspecialchars($solicitud['email']); ?></td>
                    </tr>
                    <tr>
                        <th>Puesto</th>
                        <td><?php echo htmlspecialchars($solicitud['puesto']); ?></td>
                    </tr>
                    <tr>
                        <th>Empresa</th>
                        <td><?php echo htmlspecialchars($solicitud['nombre_empresa']); ?></td>
                    </tr>
                    <tr>
                        <th>Fecha de Solicitud</th>
                        <td><?php echo htmlspecialchars($solicitud['fecha_envio']); ?></td>
                    </tr>
                    <tr>
                        <th>Archivo Adjunto</th>
                        <td><a href="descargar_archivo.php?id=<?php echo $solicitud_id; ?>" class="btn btn-outline-secondary">Descargar Archivo</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
        </body>
        </html>

        <?php
    } else {
        echo "<div class='container'><div class='alert alert-danger'>No se encontró la solicitud con el ID proporcionado.</div></div>";
    }

    // Cerrar la conexión y liberar recursos
    $stmt->close();
    $conn->close();
} else {
    echo "<div class='container'><div class='alert alert-danger'>ID de solicitud no proporcionado.</div></div>";
}
?>
