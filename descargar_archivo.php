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

    // Consulta SQL para obtener el nombre del archivo basado en el ID de la solicitud
    $sql = "SELECT archivo FROM solicitudes_empleo WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $solicitud_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $archivo = $row['archivo'];
        $ruta_archivo = './archivos_solicitud/' . $archivo;

        // Verificar que el archivo existe en el servidor
        if (file_exists($ruta_archivo)) {
            // Forzar la descarga del archivo
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($ruta_archivo) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($ruta_archivo));
            readfile($ruta_archivo);
            exit;
        } else {
            echo "El archivo no existe.";
        }
    } else {
        echo "No se encontró la solicitud con el ID proporcionado.";
    }

    // Cerrar la conexión y liberar recursos
    $stmt->close();
    $conn->close();
} else {
    echo "ID de solicitud no proporcionado.";
}
?>
