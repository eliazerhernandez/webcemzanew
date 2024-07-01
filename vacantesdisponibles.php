<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Vacantes Disponibles</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-AYKcEjRTF6R/S2mYo/n7xZGMEf9FpO1XQ0Be8WQW/Ow5z6g/m0tmdPCh1K6N31A77HLZl0/POUG7EaDdSQ1j7w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Changa+One:ital@0;1&family=Sigmar+One&family=Titan+One&family=Ultra&display=swap" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <link href="css/styles_tablas.css" rel="stylesheet">
    <link href="css/styles_vacdis.css" rel="stylesheet">
</head>
<body class="m-2" id="home">

<style>
    .logo {
        max-height: 150px; /* Ajusta el tamaño máximo del logo según sea necesario */
        width: auto; /* Ajusta automáticamente el ancho según la altura */
    }
</style>

<a href="empresas" onclick="history.back(); return false;">
    <img class="p-3" src="./img/regresar-icon.jpg" alt="Regresar"></img>
</a>

<h1>¡No te quedes sin empleo!</h1>

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

// Establecer juego de caracteres utf8 para la conexión
if (!$conn->set_charset("utf8")) {
    printf("Error cargando el conjunto de caracteres utf8: %s\n", $conn->error);
    exit();
}

// Obtener el nombre de la empresa desde la URL
$nombre_empresa = $_GET['empresa'];

// Consulta SQL para obtener los detalles de la empresa
$sql_empresa = "SELECT nombre, descripcion, logo_url FROM empresas WHERE nombre = ?";
$stmt_empresa = $conn->prepare($sql_empresa);
$stmt_empresa->bind_param("s", $nombre_empresa);
$stmt_empresa->execute();
$result_empresa = $stmt_empresa->get_result();
$empresa = $result_empresa->fetch_assoc();
?>

<div class="container col-lg-5 mt-2">
    <div class="card">
        <div class="row align-items-center">
            <div class="col-md-4 text-center"> <!-- Ajuste de alineación y centrado -->
                <img src="<?php echo htmlspecialchars($empresa['logo_url']); ?>" class="img-fluid logo rounded-start" alt="Logo Empresa">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <p class="card-text"><?php echo htmlspecialchars($empresa['descripcion']); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="pb-lg-3 pt-lg-3 page-section bg-light" id="vacantes">
    <div class="container">
        <h2 class="section-heading text-uppercase">Vacantes Disponibles para <?php echo htmlspecialchars($empresa['nombre']); ?></h2>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Perfil de puestos</th>
                    <th>Requisitos</th>
                    <th>Enviar solicitud</th>
                </tr>
            </thead>
            <tbody>
            <?php
            // Consulta SQL para obtener las vacantes de la empresa específica
            $sql_vacantes = "SELECT v.id, v.puesto, v.descripcion AS vacante_descripcion, GROUP_CONCAT(r.detalle ORDER BY r.orden SEPARATOR '||') AS requisitos
                            FROM vacantes v
                            LEFT JOIN requisitos r ON v.id = r.vacante_id
                            INNER JOIN empresas e ON v.empresa_id = e.id
                            WHERE e.nombre = ?
                            GROUP BY v.id, v.puesto, v.descripcion";

            // Preparar la consulta
            $stmt_vacantes = $conn->prepare($sql_vacantes);
            $stmt_vacantes->bind_param("s", $nombre_empresa);
            $stmt_vacantes->execute();
            $result_vacantes = $stmt_vacantes->get_result();

            // Mostrar las vacantes en una tabla
            $index = 1;
            while ($row = $result_vacantes->fetch_assoc()) {
                $puesto = htmlspecialchars($row['puesto']);
                $vacante_descripcion = htmlspecialchars($row['vacante_descripcion']);
                $requisitos = explode('||', $row['requisitos']); // Usar explode para obtener cada requisito por separado
                $vacante_id = $row['id'];

                echo '
                <tr>
                    <td>' . $index . '</td>
                    <td>' . $puesto . '</td>
                    <td><button class="btn btn-primary ver-btn" data-bs-toggle="modal" data-bs-target="#vacanteModal' . $vacante_id . '" style="background-color: rgb(68, 92, 92);">Ver</button></td>
                    <td><button class="btn btn-primary formulario-btn" data-bs-toggle="modal" data-bs-target="#formularioModal" data-vacante-id="' . $vacante_id . '" data-puesto="' . $puesto . '" style="background-color: rgb(68, 92, 92);">Formulario</button></td>
                </tr>';

                // Modal para la descripción de la vacante
                echo '
                <div class="modal fade" id="vacanteModal' . $vacante_id . '" tabindex="-1" aria-labelledby="vacanteModalLabel' . $vacante_id . '" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="vacanteModalLabel' . $vacante_id . '">' . $puesto . '</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h6>Descripción:</h6>
                                <p>' . $vacante_descripcion . '</p>
                                <h6>Requisitos:</h6>
                                <ul>';
                // Iterar sobre los requisitos y mostrarlos como una lista
                foreach ($requisitos as $requisito) {
                    echo '<li>' . htmlspecialchars($requisito) . '</li>';
                }
                echo '</ul>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>';
                $index++;
            }

            // Cerrar la conexión y liberar recursos
            $stmt_vacantes->close();
            ?>
        </tbody>

        </table>
    </div>
</section>

<!-- Modal para el formulario de solicitud -->
<div class="modal fade" id="formularioModal" tabindex="-1" aria-labelledby="formularioModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formularioModalLabel">Envíanos tu solicitud</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="formulario">
                    <form class="procesar-form" action="procesar_solicitud.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" id="puesto" name="puesto">
                        <div class="form-group">
                            <label class="text" for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label class="text" for="apellido">Apellido</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" required>
                        </div>
                        <div class="form-group">
                            <label class="text" for="profesion">Profesión</label>
                            <input type="text" class="form-control" id="profesion" name="profesion" required>
                        </div>
                        <div class="form-group">
                            <label class="text" for="email">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label class="text" for="archivo">Adjuntar Archivo</label>
                            <input type="file" class="form-control" id="archivo" name="archivo" required>
                        </div>
                        <div class="form-group">
                            <small class="form-text text-muted">* Todos los campos son obligatorios</small>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <input type="hidden" name="vacante_id" value="<?php echo $vacante_id; ?>">
                            <button type="submit" class="btn btn-primary">Enviar Solicitud</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Función para establecer el valor del campo 'puesto' y 'vacante_id' en el formulario modal
    var formularioModal = document.getElementById('formularioModal');
    formularioModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget; // Botón que activó el modal
        var puesto = button.getAttribute('data-puesto'); // Obtener el valor del atributo data-puesto
        var vacanteId = button.getAttribute('data-vacante-id'); // Obtener el valor del atributo data-vacante-id
        var inputPuesto = formularioModal.querySelector('#puesto'); // Seleccionar el campo oculto 'puesto' en el formulario
        var inputVacanteId = formularioModal.querySelector('[name="vacante_id"]'); // Seleccionar el campo oculto 'vacante_id' en el formulario
        inputPuesto.value = puesto; // Asignar el valor del puesto al campo 'puesto' en el formulario
        inputVacanteId.value = vacanteId; // Asignar el valor de vacanteId al campo 'vacante_id' en el formulario
    });
</script>


</body>
</html>
