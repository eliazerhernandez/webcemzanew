<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $solicitud_id = $_GET['id'];

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

    // Actualizar revisado a 1
    $sql = "UPDATE solicitudes_empleo SET revisado = 1 WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $solicitud_id);

    if ($stmt->execute()) {
        // Redireccionar después de marcar como revisado
        header("Location: ../ver_solicitudes.php");
        exit();
    } else {
        echo "Error al marcar como revisado: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Acceso no permitido";
}
?>
