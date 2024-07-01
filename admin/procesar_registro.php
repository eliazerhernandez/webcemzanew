<?php
// Verificar si se está enviando el formulario por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recuperar datos del formulario
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $_POST['email'];
    $nombre = $_POST['nombre'];
    $access_code = $_POST['access_code'];

    // Verificar que las contraseñas coincidan
    if ($password !== $confirm_password) {
        die("Error: Las contraseñas no coinciden.");
    }

    // Incluir el archivo de configuración con la contraseña de acceso
    require_once('../admin/config.php');

    // Usar la contraseña de acceso
    echo $access_code;

    // Conexión a la base de datos
    $servername = "localhost";
    $db_username = "root"; // Cambiar el nombre de la variable para evitar conflictos
    $db_password = "";
    $database = "Marinsa";

    $conn = new mysqli($servername, $db_username, $db_password, $database);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Hash de la contraseña
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Preparar la consulta SQL para insertar el administrador
    $sql = "INSERT INTO administradores (username, password, email, nombre) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $username, $hashed_password, $email, $nombre);

    // Ejecutar la consulta SQL
    if ($stmt->execute()) {
        echo "Administrador registrado exitosamente.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Cerrar la conexión y liberar recursos
    $stmt->close();
    $conn->close();
}
?>
