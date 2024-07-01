<?php
// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar los datos del formulario
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $profesion = $_POST['profesion'];
    $email = $_POST['email'];
    $vacante_id = $_POST['vacante_id']; // Capturar el ID de la vacante

    // Validar que se haya subido un archivo
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
        $archivo_nombre = $_FILES['archivo']['name'];
        $archivo_tmp = $_FILES['archivo']['tmp_name'];

        // Procesar y almacenar el archivo (ejemplo de moverlo a una carpeta específica)
        $ruta_destino = './archivos_solicitud/' . basename($archivo_nombre);

        if (move_uploaded_file($archivo_tmp, $ruta_destino)) {
            // Guardar los datos en la base de datos
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

            // Establecer juego de caracteres utf8 para la conexión
            if (!$conn->set_charset("utf8")) {
                printf("Error cargando el conjunto de caracteres utf8: %s\n", $conn->error);
                exit();
            }

            // Preparar la sentencia SQL para insertar datos en la tabla
            $sql = "INSERT INTO solicitudes_empleo (nombre, apellido, profesion, email, archivo, vacante_id) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssi", $nombre, $apellido, $profesion, $email, $archivo_nombre, $vacante_id);
            
            // Ejecutar la sentencia preparada
            if ($stmt->execute()) {
                echo "Datos almacenados correctamente en la base de datos.";
            } else {
                echo "Error al almacenar los datos: " . $stmt->error;
            }

            // Cerrar la conexión y liberar recursos    
            $stmt->close(); 
            $conn->close();

            // Mostrar mensaje de éxito o fallo en el envío del archivo
            echo "El archivo " . htmlspecialchars(basename($archivo_nombre)) . " ha sido subido correctamente.";
        } else {
            echo "Error al subir el archivo.";
        }
    } else {
        echo "Error al subir el archivo.";
    }

    
}
?>
