<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <title>Cemza</title>

    <!--Favicon-->
    <link rel="icon" type="image/x-icon" href="img/Logo.jpg">
    <!--Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"/>
    <!--Font Awesome icons-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!--Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
    <!--Estilos-->
    <link href="css/styles.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com"/>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Changa+One:ital@0;1&family=Sigmar+One&family=Titan+One&family=Ultra&display=swap" rel="stylesheet"/>

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

    <!--Estructura de Navbar de navegación-->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
        <div class="container">
            <!--Codigo de logo y nombre de la empresa-->
                <a class="navbar-brand" href="#home">
                    <img src="./img/Logo.jpg" alt="Logo" class="d-inline-block align-text-top">
                    CEMZA
                </a>
            <!--Codigo del Botton Menu-->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars ms-1"></i>
            </button>
            <!--Estructura de Navbar/Modulos-->
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav text-uppercase ms-auto ">
                    <li class="nav-item"><a class="nav-link" href="#inicio">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#empresas">Nuestras empresas</a></li>
                    <li class="nav-item"><a class="nav-link" href="#quienes_somos">Quienes somos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#información_ubicación">Información</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contactanos">Contactanos</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!--Cabecera-->
    <header class="masthead" id="inicio">
        <div class="container">
            <div class="masthead-subheading">¡Bienvenido a Cemza!</div>
            <div class="masthead-heading text-uppercase">Encuentra el trabajo que quieres ahora</div>
             <!--Buscador-->
              <!--form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Busca el puesto que deseas" aria-label="Search">
                <button class="btn btn-outline-dark" type="submit">Buscar</button>
              </form--><br>
            <a class="btn btn-warning btn-xl text-uppercase" href="#empresas">Nuestras empresas</a>
        </div>
    </header>

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

   
    <!--Quienes somos-->
    <section class="page-section" id="quienes_somos">
        <div class="container mx-auto p-1">
            <div class="text2 text-center">
                <h2 class="section-heading text-uppercase">Quienes somos</h2>                
            </div>
            <div class="card row g-0 bg-body-secondary position-relative">
                <div class="row g-0">
                  <div class="col-md-3 p-md-2">
                  <div class="position-relative">
                    <img src="img/quienesomos.jpg" class="img-thumbnail" alt="...">
                  </div>
                  </div>
                  <div class="col-md-8">
                    <div class="card-body">
                      <p class="text-center">Somos un grupo de empresas que provee servicios, suministros y soluciones integrales para la industria offshore en las etapas de exploración, perforación, producción y comercialización de la industria petrolera.</p>
                      <p class="text-center">Nuestra historia comienza hace más de 50 años cuando nuestro fundador José Luis Zavala Navarrete, tuvo la inquietud de innovar al construir el primer barco de acero en Ciudad del Carmen para la pesca de camarón, el negocio evolucionó y en la transición de la industria camaronera a la industria petrolera, se establecieron nuevas líneas y oportunidades de negocio que nos han transformado en las empresas que hoy conforman el corporativo CEMZA.</p>
                    </div>                                                                                                                                                                                                                                                                                                                                                  
                  </div>
                </div>
            </div>
        </div>
    </section>
    <!--Información y ubicación-->
    <section class="page-section bg-light" id="información_ubicación">
        <div class="container p-4">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Informacion y Ubicacion</h2>                
            </div>
            <h5 class="text-center">Proveedor de equipos industriales en la Ciudad del Carmen.</h5>
            <div class="card w-50 text-center mx-auto p-2">
                <div class="card-body">
                  <p class="card-text">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                      <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.58a32 32 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10" />
                      <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                    </svg>
                    Av. Adolfo, Av López Mateos 179,
                    Puerto Pesquero, 24129 Ciudad
                    del Carmen, Campeche.
                  </p>
                  <p class="card-text bi-clock">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock" viewBox="0 0 16 16">
                      <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z" />
                      <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0" />
                    </svg>
                    Horarios: De lunes a viernes de 8:00 am - 19:00 pm.
                  </p>
                  <p class="card-text">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone-forward" viewBox="0 0 16 16">
                      <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.6 17.6 0 0 0 4.168 6.608 17.6 17.6 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.68.68 0 0 0-.58-.122l-2.19.547a1.75 1.75 0 0 1-1.657-.459L5.482 8.062a1.75 1.75 0 0 1-.46-1.657l.548-2.19a.68.68 0 0 0-.122-.58zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877zm10.762.135a.5.5 0 0 1 .708 0l2.5 2.5a.5.5 0 0 1 0 .708l-2.5 2.5a.5.5 0 0 1-.708-.708L14.293 4H9.5a.5.5 0 0 1 0-1h4.793l-1.647-1.646a.5.5 0 0 1 0-.708" />
                    </svg>
                    938-382-7181
                  </p>
                </div>
            </div>
        </div>
    </section>
    <!--Contactanos-->
    <section class="page-section" id="contactanos">
        <div class="container u-desaparecer aparecerSlideUp slideUp">
            <div class="text text-center">
                <h2 class="section-heading text-uppercase">Contactanos</h2>
            </div>
            <h5 class="text text-center">Si desea más información no dude en contactarnos.</h5>
            <div class="formulario w-50 text-center mx-auto p-2">
                <form class="procesar-form">
                    <div class="form-group">
                        <label class="text" for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label class="text" for="email">Correo electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label class="text" for="telefono">Telefono</label>
                        <input type="telefono" class="form-control" id="telefono" name="telefono" required>
                    </div>
                    <div class="form-group">
                        <label class="text" for="mensaje">Mensaje</label>
                        <textarea class="form-control" id="mensaje" name="mensaje" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-outline-secondary">Enviar</button>
                </form>
            </div>   
        </div>
    </section>
    <!-- Footer-->
    <footer class="footer">
        <img  src="img/footer.jpg">
        <span class="aviso">
            <a href="https://appscemza.com:3095/Denuncias/">Denuncias</a>
        </span>
        <span class="aviso">
            <a href="http://www.cemza.com/CGI-BIN/CemzaAvisoPrivacidad.html">Polotica de Privacidad</a>
        </span>
        <span class="Copyright">
            &copy; 2024. Todos los derechos reservados. Diseño y desarrollo por
            <a href="" target="_blank">el Corporativo</a>
        </span>
    </footer>
    <!--Empresas Modals-->
        <!-- Empresa marinsa 1 -->
        <div class="empresas-modal modal fade" id="empresa1_marinsa" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="close-modal" data-bs-dismiss="modal"><img src="img/close-icon.jpg" width="30rem" height="30rem" alt="Close modal"/></div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="modal-body">
                                    <img class="img-fluid d-block mx-auto" src="img/empresas/marinsa.png" alt="..." />
                                    <p>Marinsa provee embarcaciones especializadas para la industria offshore. Contamos con embarcaciones tipo: DP1 y DP2, AHTS, Remolcadores, Abastecedores, Utilitarios y FSV, así como barcos para estudios sísmicos, geofísicos, geotécnicos, loderos, de inspección, entre otros.</p>
                                    <!-- Servicios -->
                                    <h5 class="text-uppercase">Servicios</h5>
                                    <p class="item-intro text-muted"><strong>Realizamos movimientos de plataformas:</strong> Jack Up’s, modulares y semi sumergibles. Transportamos personal, materiales, equipos, agua y diésel offshore. Nuestra base se encuentra en Ciudad del Carmen y operamos en todo el Golfo de México. Contamos con oficinas en Houston, Bogotá y Singapore.</p>
                                    <div class="row">
                                        <div class="row row-cols-2 row-cols-md-4 g-4">
                                            <div class="icon" >
                                                <img src="img/servicios/icon_marinsa_01.png" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                  <p class="card-text">Fletamento de Embarcaciones</p>
                                                </div>
                                            </div>
                                            <div class="icon" >
                                                <img src="img/servicios/icon_marinsa_02.png" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                  <p class="card-text">Geofísica y Geotecnia</p>
                                                </div>
                                            </div>
                                            <div class="icon" >
                                                <img src="img/servicios/icon_marinsa_03.png" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                  <p class="card-text">Proyectos Subsea</p>
                                                </div>
                                            </div>
                                            <div class="icon" >
                                                <img src="img/servicios/icon_marinsa_04.png" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                  <p class="card-text">Ductos y Tendido de Líneas</p>
                                                </div>
                                            </div>
                                            <div class="icon" >
                                                <img src="img/servicios/icon_marinsa_05.png" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                  <p class="card-text">Movimiento de Plataformas</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Enlace para ir al sitio web -->
                                    <div >
                                        <a href="http://marinsa.com.mx" class="u-block u-textCenter link-empresa" target="_blank">Ir al sitio web</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Empresa maren 2 -->
        <div class="empresas-modal modal fade" id="empresa2_maren" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="close-modal" data-bs-dismiss="modal"><img src="img/close-icon.jpg" width="30rem" height="30rem" alt="Close modal" /></div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="modal-body">
                                    <img class="img-fluid d-block mx-auto m-3" width="40%" src="img/empresas/maren.png" alt="..." />
                                    <p>Brindamos servicios de perforación, mantenimiento, terminación y reparación de pozos marinos. Nos especializamos en: perforación direccional, fluídos de perforación y terminación, cementaciones, registros con cable, equipos y herramientas de perforación.</p>
                                    <!-- Servicios -->
                                    <h5 class="text-uppercase">Servicios</h5>
                                    <p class="item-intro text-muted">Ofrecemos servicios en todos los campos petroleros del Golfo de México.</p>
                                    <div class="row">
                                        <div class="row row-cols-2 row-cols-md-4 g-4">
                                            <div class="icon" >
                                                <img src="img/servicios/icon_maren_01.png" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                  <p class="card-text">Perforación Direccional</p>
                                                </div>
                                            </div>
                                            <div class="icon" >
                                                <img src="img/servicios/icon_maren_02.png" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                  <p class="card-text">Fluidos de perforación</p>
                                                </div>
                                            </div>
                                            <div class="icon" >
                                                <img src="img/servicios/icon_maren_03.png" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                  <p class="card-text">Herramientas de perforación</p>
                                                </div>
                                            </div>
                                            <div class="icon" >
                                                <img src="img/servicios/icon_maren_04.png" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                  <p class="card-text">Cementaciones y registros</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Enlace para ir al sitio web -->
                                    <div >
                                        <a href="http://marenenergy.mx" class="u-block u-textCenter link-empresa" target="_blank">Ir al sitio web</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <!-- Empresa bistro 3 -->
         <div class="empresas-modal modal fade" id="empresa3_bistro" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="close-modal" data-bs-dismiss="modal"><img src="img/close-icon.jpg" width="30rem" height="30rem" alt="Close modal" /></div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="modal-body">
                                    <img class="img-fluid d-block mx-auto m-3" width="40%" src="img/empresas/bistro.png" alt="..." />
                                    <p>Somos expertos en alimentación y hotelería offshore. Ofrecemos personal especializado en la elaboración de alimentos y servicios generales de limpieza. Nuestros servicios incluyen avituallamiento de insumos, abarrotes y materias primas a cualquier tipo de unidad offshore.</p>
                                    <!-- Servicios -->
                                    <h5 class="text-uppercase">Servicios</h5>
                                    <p class="item-intro text-muted">Contamos con la experiencia en atención a clientes nacionales y extranjeros adecuándonos a sus necesidades. Actualmente operamos en los principales puertos del Golfo de México.</p>
                                    <div class="row">
                                        <div class="row row-cols-2 row-cols-md-4 g-4">
                                            <div class="icon" >
                                                <img src="img/servicios/icon_bistro_01.png" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                  <p class="card-text">Alimentación y Hotelería</p>
                                                </div>
                                            </div>
                                            <div class="icon" >
                                                <img src="img/servicios/icon_bistro_02.png" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                  <p class="card-text">Limpieza</p>
                                                </div>
                                            </div>
                                            <div class="icon" >
                                                <img src="img/servicios/icon_bistro_03.png" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                  <p class="card-text">Avituallamiento de Insumos</p>
                                                </div>
                                            </div>
                                            <div class="icon" >
                                                <img src="img/servicios/icon_bistro_04.png" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                  <p class="card-text">Abarrotes y Materias Primas</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Enlace para ir al sitio web -->
                                    <div >
                                        <a href="http://bistroalimentacion.com" class="u-block u-textCenter link-empresa" target="_blank">Ir al sitio web</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Empresa oceamar 4 -->
        <div class="empresas-modal modal fade" id="empresa4_oceamar" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="close-modal" data-bs-dismiss="modal"><img src="img/close-icon.jpg" width="30rem" height="30rem" alt="Close modal" /></div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="modal-body">
                                    <img class="img-fluid d-block mx-auto" src="img/empresas/oceamar.png" alt="..." />
                                    <p>Somos una agencia dedicada a la atención de barcos y plataformas offshore. Dentro de nuestra oferta integral se encuentran los siguientes servicios: agenciamiento, importación, exportación y logística de materiales y base de operaciones.</p>
                                    <!-- Servicios -->
                                    <h5 class="text-uppercase">Servicios</h5>
                                    <p class="item-intro text-muted">También ofrecemos renta y venta de estructuras de almacenaje tales como: contenedores fríos, contenedores secos, contenedores habitacionales, isotanques, entre otros.</p>
                                    <div class="row">
                                        <div class="row row-cols-2 row-cols-md-4 g-4">
                                            <div class="icon" >
                                                <img src="img/servicios/icon_oceamar_01.png" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                  <p class="card-text">Agenciamiento</p>
                                                </div>
                                            </div>
                                            <div class="icon" >
                                                <img src="img/servicios/icon_oceamar_02.png" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                  <p class="card-text">Base de Operaciones</p>
                                                </div>
                                            </div>
                                            <div class="icon" >
                                                <img src="img/servicios/icon_oceamar_03.png" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                  <p class="card-text">Importación, Exportación y Logística</p>
                                                </div>
                                            </div>
                                            <div class="icon" >
                                                <img src="img/servicios/icon_oceamar_04.png" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                  <p class="card-text">Venta y Rentade Contenedores</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Enlace para ir al sitio web -->
                                    <div >
                                        <a href="http://oceamar.com.mx" class="u-block u-textCenter link-empresa" target="_blank">Ir al sitio web</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Empresa enermar 5 -->
        <div class="empresas-modal modal fade" id="empresa5_enermar" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="close-modal" data-bs-dismiss="modal"><img src="img/close-icon.jpg" width="30rem" height="30rem" alt="Close modal" /></div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="modal-body">
                                    <img class="img-fluid d-block mx-auto" src="img/empresas/enermar.png" alt="..." />
                                    <p>Somos proveedores de diésel marino para barcos y plataformas offshore. Suministramos combustible a petroleras, traders, brokers, agencias, patios de trabajo y plantas industriales.</p>
                                    <!-- Servicios -->
                                    <h5 class="text-uppercase">Servicios</h5>
                                    <p class="item-intro text-muted">Contamos con barcos especializados para el transporte de combustible hasta instalaciones offshore. Operamos en todos los puertos del Golfo de México y damos servicio las 24 horas, los 365 días del año.</p>
                                    <div class="row">
                                        <div class="row row-cols-2 row-cols-md-4 g-4">
                                            <div class="icon" >
                                                <img src="img/servicios/icon_enermar_01.png" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                  <p class="card-text">Suministro Offshore</p>
                                                </div>
                                            </div>
                                            <div class="icon" >
                                                <img src="img/servicios/icon_enermar_02.png" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                  <p class="card-text">Suministro por Pipas</p>
                                                </div>
                                            </div>
                                            <div class="icon" >
                                                <img src="img/servicios/icon_enermar_03.png" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                  <p class="card-text">Estaciones</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Enlace para ir al sitio web -->
                                    <div >
                                        <a href="http://enermar.com.mx" class="u-block u-textCenter link-empresa" target="_blank">Ir al sitio web</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Empresa presco 6 -->
        <div class="empresas-modal modal fade" id="empresa6_presco" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="close-modal" data-bs-dismiss="modal"><img src="img/close-icon.jpg" width="30rem" height="30rem" alt="Close modal" /></div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="modal-body">
                                    <img class="img-fluid d-block mx-auto m-3" width="35%" src="img/empresas/presco.png" alt="..." />
                                    <p>Suministramos personal especializado para la industria offshore. Nos hemos posicionado en el mercado energético en servicios de reclutamiento, capacitación, pago de nómina, suministro de herramientas, ropa de trabajo y equipo de protección personal.</p>
                                    <!-- Servicios -->
                                    <h5 class="text-uppercase">Servicios</h5>
                                    <p class="item-intro text-muted">Disponemos de la capacidad tecnológica, recursos y alianzas estratégicas necesarias para llevar nuestras soluciones a cualquier parte de México y el mundo.</p>
                                    <div class="row">
                                        <div class="row row-cols-2 row-cols-md-4 g-4">
                                            <div class="icon" >
                                                <img src="img/servicios/icon_presco_01.png" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                  <p class="card-text">Reclutamiento</p>
                                                </div>
                                            </div>
                                            <div class="icon" >
                                                <img src="img/servicios/icon_presco_02.png" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                  <p class="card-text">Equipo de Protección Personal</p>
                                                </div>
                                            </div>
                                            <div class="icon" >
                                                <img src="img/servicios/icon_presco_03.png" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                  <p class="card-text">Capacitación</p>
                                                </div>
                                            </div>
                                            <div class="icon" >
                                                <img src="img/servicios/icon_presco_04.png" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                  <p class="card-text">Suministro de Herramientas</p>
                                                </div>
                                            </div>
                                            <div class="icon" >
                                                <img src="img/servicios/icon_presco_05.png" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                  <p class="card-text">Pago de Nómina</p>
                                                </div>
                                            </div>
                                            <div class="icon" >
                                                <img src="img/servicios/icon_presco_06.png" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                  <p class="card-text">Ropa de Trabajo</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Enlace para ir al sitio web -->
                                    <div >
                                        <a href="http://presco.mx" class="u-block u-textCenter link-empresa" target="_blank">Ir al sitio web</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Empresa valaren 7 -->
        <div class="empresas-modal modal fade" id="empresa7_valaren" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="close-modal" data-bs-dismiss="modal"><img src="img/close-icon.jpg" width="30rem" height="30rem" alt="Close modal" /></div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="modal-body">
                                    <img class="img-fluid d-block mx-auto m-3" width="35%"  src="img/empresas/valaren.png" alt="..." />
                                    <p>Nos dedicamos a llevar a nuestros clientes donde necesitan estar, cuando necesitan estar, de manera segura y confiable.</p>
                                    <!-- Servicios -->
                                    <h5 class="text-uppercase">Servicios</h5>
                                    <p class="item-intro text-muted"></p>
                                    <!-- Enlace para ir al sitio web -->
                                    <div >
                                        <a href="http://valaren.com.mx/" class="u-block u-textCenter link-empresa" target="_blank">Ir al sitio web</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Empresa varadero zavala 8 -->
        <div class="empresas-modal modal fade" id="empresa8_varadero_zavala" data-bs-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="close-modal" data-bs-dismiss="modal"><img src="img/close-icon.jpg" width="30rem" height="30rem" alt="Close modal" /></div>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="modal-body">
                                    <img class="img-fluid d-block mx-auto m-3" src="img/empresas/varadero_zavala.png" alt="..." />
                                    <p>Ofrecemos servicios de mantenimiento y reparación de barcos abastecedores, utilitarios, lanchas de pasaje, remolcadores y chalanes, tanto en dique seco como a flote. Fabricamos estructuras metálicas, maquinados de piezas de diferentes materiales, alineamos y reparamos ejes y propelas.</p>
                                    <!-- Servicios -->
                                    <h5 class="text-uppercase">Servicios</h5>
                                    <p class="item-intro text-muted">Contamos con más de 50 años de experiencia en el sector, infraestructura, equipo y personal técnico especializado.</p>
                                    <div class="row">
                                        <div class="row row-cols-2 row-cols-md-4 g-4">
                                            <div class="icon" >
                                                <img src="img/servicios/icon_varadero_zavala_01.png" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                  <p class="card-text"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Enlace para ir al sitio web -->
                                    <div >
                                        <a href="http://varaderoszavala.com" class="u-block u-textCenter link-empresa" target="_blank">Ir al sitio web</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <!-- * *                               SB Forms JS                               * *-->
    <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>

</body>
</html>