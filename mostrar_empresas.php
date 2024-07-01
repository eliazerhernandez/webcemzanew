<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Listado de Empresas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Changa+One:ital@0;1&family=Sigmar+One&family=Titan+One&family=Ultra&display=swap" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="img/Logo.jpg">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css">
    <link href="css/styles.css" rel="stylesheet">
</head>
<body id="home">

<style>
        /* Estilos personalizados para el modal */
        .modal-header {
            background-color: #343a40;
            color: #fff;
            border-bottom: 1px solid #dee2e6;
        }
        .modal-title {
            font-size: 1.5rem;
            
        }
        .modal-title h5 {
            text-align: center;

        }
        .modal-body {
            padding: 2rem;
            text-align: center;
        }
        .modal-body img {
            max-width: 300px; /* Ajustamos el tamaño máximo de la imagen */
            width: 100%; /* Hacemos que la imagen ocupe el 100% de su contenedor */
            margin-bottom: 1rem;
        }
        .modal-body p {
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
            
        }
        .modal-footer {
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
        }
        .empresa-link:hover .empresa-hover-content {
            opacity: 1;
        }
        .empresa-item .empresa-hover-content {
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }
</style>

<section class="pb-lg-3 pt-lg-3 page-section bg-light" id="empresas">
    <div class="container">
        <div class="text-center">
            <h2 class="section-heading text-uppercase">Nuestras empresas</h2>
        </div>
        <div class="row row-cols-1 row-cols-md-4 g-4">

        <?php
        // Conexión a la base de datos
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "Marinsa";

        // Crear conexión
        $conexion = new mysqli($servername, $username, $password, $database);

        // Verificar conexión
        if ($conexion->connect_error) {
            die("Conexión fallida: " . $conexion->connect_error);
        }

        // Establecer juego de caracteres utf8 para la conexión
        if (!$conexion->set_charset("utf8")) {
            printf("Error cargando el conjunto de caracteres utf8: %s\n", $conexion->error);
            exit();
        }

        // Consultar las empresas con sus detalles desde ambas tablas
        $query = "SELECT e.id, e.nombre, e.descripcion, e.logo_url, d.servicios, d.ubicacion, d.otros_detalles 
                  FROM empresas e
                  LEFT JOIN detalles_empresas d ON e.id = d.empresa_id";

        // Ejecutar la consulta
        $result = mysqli_query($conexion, $query);

        // Verificar si hay resultados
        if (mysqli_num_rows($result) > 0) {
            // Iterar sobre los resultados y mostrar cada tarjeta de empresa
            while ($row = mysqli_fetch_assoc($result)) {
                $id_empresa = $row['id'];
                $nombre_empresa = htmlspecialchars($row['nombre']);
                $descripcion_empresa = htmlspecialchars($row['descripcion']);
                $logo_empresa = htmlspecialchars($row['logo_url']);
                $servicios_empresa = htmlspecialchars($row['servicios']);
                $ubicacion_empresa = htmlspecialchars($row['ubicacion']);
                $otros_detalles = htmlspecialchars($row['otros_detalles']);

                echo '
                <div class="col">
                    <div class="card h-100">
                        <div class="empresa-item">
                            <a class="empresa-link" data-bs-toggle="modal" href="#modal_' . $id_empresa . '">
                                <div class="empresa-hover">
                                    <div class="empresa-hover-content"><i class="fas fa-plus fa-3x"></i></div>
                                </div>
                                <img class="card-img-top img-fluid" src="' . $logo_empresa . '" alt="Logo de ' . $nombre_empresa . '" />
                            </a>
                            <div class="card-body">
                                <h5 class="card-title">' . $nombre_empresa . '</h5>
                                <p class="card-text">' . $descripcion_empresa . '</p>
                                <a href="./vacantesdisponibles.php?empresa=' . urlencode($nombre_empresa) . '" class="btn btn-outline-primary">Vacantes disponibles</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Modal -->
                <div class="modal fade" id="modal_' . $id_empresa . '" tabindex="-1" aria-labelledby="modal_' . $id_empresa . '_label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">' . $nombre_empresa . '</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <img src="' . $logo_empresa . '" class="img-fluid mb-3" alt="Logo de ' . $nombre_empresa . '" />
                                <p><strong></strong> ' . $servicios_empresa . '</p>
                                <p><strong>Ubicación:</strong></p>
                                <p>' . $ubicacion_empresa . '</p>
                                <p><strong>Otros Detalles:</strong></p>
                                <p>' . $otros_detalles . '</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
                ';
            }
        } else {
            echo '<p>No se encontraron empresas.</p>';
        }

        // Liberar el resultado
        mysqli_free_result($result);

        // Cerrar la conexión
        mysqli_close($conexion);
        ?>

        </div>
    </div>
</section>

<!-- Scripts Bootstrap y otros -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Script para inicializar modales -->
<script>
    $(document).ready(function() {
        // Inicializar todos los modales
        var modals = document.querySelectorAll('.modal');
        modals.forEach(function(modal) {
            new bootstrap.Modal(modal);
        });
    });
</script>

</body>
</html>
