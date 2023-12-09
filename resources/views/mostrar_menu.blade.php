<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Principal</title>
    <!-- Agrega los enlaces a Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8sh+Wy6p1C5E9rJHQ7pb6AlAiSJuqF5mF84QJ8" crossorigin="anonymous">
    <!-- Agrega tu propio CSS personalizado aquí -->
    <style>
        body {
            padding-top: 56px; /* Ajusta la posición del contenido debajo del navbar */
        }
        .navbar {
            background-color: #2A9C91; /* Color de fondo del navbar */
        }
        .navbar-brand, .navbar-nav .nav-link {
            color: #ffffff; /* Color del texto del navbar */
        }
        .navbar-brand:hover, .navbar-nav .nav-link:hover {
            color: #a8a8a8; /* Color del texto al pasar el mouse */
        }
    </style>
</head>
<body>

<!-- Barra de navegación -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">Suministros e Inversiones Del Perú E. I. R. L</a>
        <!-- Botón de hamburguesa para dispositivos móviles -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Menú de navegación -->
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Acerca de</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Servicios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contacto</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Contenido principal -->
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <!-- Aquí va el contenido de tu página -->
            <h1 class="mt-5">¡Bienvenido!</h1>
            <p>Este es el contenido principal de tu página.</p>
        </div>
    </div>
</div>

<!-- Scripts de Bootstrap (Asegúrate de incluir jQuery y Popper.js antes de Bootstrap) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-i3q2D8VPtVlxLMp2aebfZl/zBq7UARtUxcAq3/ohw4XEiGRQRb9M0aVzpgvhsg" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8sh+Wy6p1C5E9rJHQ7pb6AlAiSJuqF5mF84QJ8" crossorigin="anonymous"></script>

</body>
</html>