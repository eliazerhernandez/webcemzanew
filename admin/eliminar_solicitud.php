<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $solicitud_id = $_GET['id'];

    // Conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "Marinsa";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Eliminar la solicitud de empleo
    $sql = "DELETE FROM solicitudes_empleo WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $solicitud_id);

    if ($stmt->execute()) {
        // Redireccionar después de eliminar
        header("Location: ../ver_solicitudes.php");
        exit();
    } else {
        echo "Error al eliminar la solicitud: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Acceso no permitido";
}
?>
