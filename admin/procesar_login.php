<?php
session_start();

// Conexión a la base de datos (misma configuración)
$servername = "localhost";
$db_username = "root"; // Cambiar el nombre de la variable para evitar conflictos
$db_password = "";
$database = "Marinsa";

$conn = new mysqli($servername, $db_username, $db_password, $database);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username_login = $_POST['username']; // Cambiar el nombre de la variable para evitar conflictos
    $password_login = $_POST['password'];

    // Consulta para obtener la contraseña almacenada
    $sql = "SELECT id, password FROM administradores WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username_login); // Cambiar el nombre de la variable para evitar conflictos
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password_login, $row['password'])) {
            // Inicio de sesión exitoso, establecer sesión
            $_SESSION['admin_id'] = $row['id'];
            header("Location: admin_dashboard.php"); // Redireccionar al dashboard del administrador
            exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }

    $stmt->close();
    $conn->close();
}
?>
