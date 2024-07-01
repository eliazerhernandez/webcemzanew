<?php
// Archivo: guardar_empresa_vacantes.php
session_start();


// Verificar si el administrador ha iniciado sesión
if (!isset($_SESSION['admin_id'])) {
    header("Location: ./admin/login_admin.php");
    exit();
}

// Conexión a la base de datos (revisa los datos de conexión en tu caso específico)
$servername = "localhost";
$username = "root";  // Usuario de MySQL en XAMPP
$password = "";      // Contraseña de MySQL en XAMPP (usualmente vacía o "root")
$database = "Marinsa";  // Nombre de la base de datos

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

// Variables del formulario
$nombre_empresa = $_POST['nombre_empresa'];
$descripcion_empresa = $_POST['descripcion_empresa'];
$servicios_empresa = $_POST['servicios_empresa'];
$ubicacion_empresa = $_POST['ubicacion_empresa'];
$otros_detalles = $_POST['otros_detalles'];

// Procesamiento del logo de la empresa (guardarlo en una carpeta y obtener la ruta)
$target_dir = "img/logos/"; // Carpeta donde se guardarán los logos
$target_file = $target_dir . basename($_FILES["logo_empresa"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Verificar si es una imagen real o un archivo falso
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["logo_empresa"]["tmp_name"]);
    if($check !== false) {
        echo "El archivo es una imagen - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "El archivo no es una imagen.";
        $uploadOk = 0;
    }
}

// Verificar el tamaño del archivo
if ($_FILES["logo_empresa"]["size"] > 500000) {
    echo "Lo siento, tu archivo es demasiado grande.";
    $uploadOk = 0;
}

// Permitir ciertos formatos de archivo
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Lo siento, solo se permiten archivos JPG, JPEG, PNG y GIF.";
    $uploadOk = 0;
}

// Verificar si $uploadOk está configurado a 0 por un error
if ($uploadOk == 0) {
    echo "Lo siento, tu archivo no se subió.";
// Si todo está bien, intenta subir el archivo
} else {
    if (move_uploaded_file($_FILES["logo_empresa"]["tmp_name"], $target_file)) {
        echo "El archivo ". htmlspecialchars( basename( $_FILES["logo_empresa"]["name"])). " ha sido subido correctamente.";
        $logo_empresa = $target_file; // Guardar la ruta del logo para insertar en la base de datos

        // Ahora puedes continuar con la inserción en la base de datos usando $logo_empresa
    } else {
        echo "Lo siento, hubo un error al subir tu archivo.";
    }
}

// Insertar datos de la empresa en la tabla 'empresas'
$sql_empresa = "INSERT INTO empresas (nombre, descripcion, logo_url) VALUES (?, ?, ?)";
$stmt_empresa = $conn->prepare($sql_empresa);
$stmt_empresa->bind_param("sss", $nombre_empresa, $descripcion_empresa, $logo_empresa);

if ($stmt_empresa->execute()) {
    $empresa_id = $stmt_empresa->insert_id; // Obtener el ID de la empresa recién insertada

    // Insertar detalles adicionales de la empresa en la tabla 'detalles_empresas'
    $sql_detalles = "INSERT INTO detalles_empresas (empresa_id, servicios, ubicacion, otros_detalles) VALUES (?, ?, ?, ?)";
    $stmt_detalles = $conn->prepare($sql_detalles);
    $stmt_detalles->bind_param("isss", $empresa_id, $servicios_empresa, $ubicacion_empresa, $otros_detalles);
    
    if ($stmt_detalles->execute()) {
        // Insertar vacantes y requisitos asociados
        if (isset($_POST['vacantes']) && isset($_POST['descripciones_vacantes']) && isset($_POST['requisitos_vacantes'])) {
            $vacantes = $_POST['vacantes'];
            $descripciones_vacantes = $_POST['descripciones_vacantes'];
            $requisitos_vacantes = $_POST['requisitos_vacantes'];

            // Insertar cada vacante y sus requisitos asociados
            for ($i = 0; $i < count($vacantes); $i++) {
                $vacante = $vacantes[$i];
                $descripcion_vacante = $descripciones_vacantes[$i];

                // Insertar vacante en la tabla 'vacantes'
                $sql_vacante = "INSERT INTO vacantes (empresa_id, puesto, descripcion) VALUES (?, ?, ?)";
                $stmt_vacante = $conn->prepare($sql_vacante);
                $stmt_vacante->bind_param("iss", $empresa_id, $vacante, $descripcion_vacante);
                $stmt_vacante->execute();
                $vacante_id = $stmt_vacante->insert_id; // Obtener el ID de la vacante recién insertada

                // Insertar requisitos de la vacante en la tabla 'requisitos'
                if (isset($requisitos_vacantes[$i]) && is_array($requisitos_vacantes[$i])) {
                    foreach ($requisitos_vacantes[$i] as $requisito) {
                        $sql_requisitos = "INSERT INTO requisitos (vacante_id, tipo, detalle, orden) VALUES (?, 'requisito', ?, 1)";
                        $stmt_requisitos = $conn->prepare($sql_requisitos);
                        $stmt_requisitos->bind_param("is", $vacante_id, $requisito);
                        $stmt_requisitos->execute();
                    }
                }
            }

            // Mostrar mensaje de éxito
            echo "Los datos se guardaron correctamente.";
        } else {
            echo "Error: No se recibieron los datos esperados del formulario.";
        }
    } else {
        echo "Error al insertar detalles adicionales de la empresa: " . $stmt_detalles->error;
    }
} else {
    echo "Error al insertar la empresa: " . $stmt_empresa->error;
}

// Cerrar conexiones y liberar recursos
$stmt_empresa->close();
$stmt_detalles->close();
if (isset($stmt_vacante)) $stmt_vacante->close();
if (isset($stmt_requisitos)) $stmt_requisitos->close();
$conn->close();
?>
