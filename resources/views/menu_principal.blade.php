<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu Principal</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
  <link rel="stylesheet" href="./css/main.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: sans-serif;
    }

    header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 2rem;
      background-color: #ececec;
    }

    .logo {
      max-width: 250px;
    }

    .nav-list {
      list-style-type: none;
      display: flex;
      gap: 1rem;
    }

    .nav-list li a {
      text-decoration: none;
      color: #1c1c1c;
    }

    .abrir-menu,
    .cerrar-menu {
      display: none;
    }

    @media screen and (max-width: 550px) {

      .abrir-menu,
      .cerrar-menu {
        display: block;
        border: 0;
        font-size: 1.25rem;
        background-color: transparent;
        cursor: pointer;
      }

      .abrir-menu {
        color: #1c1c1c;
      }

      .cerrar-menu {
        color: #ececec;
      }

      .nav {
        opacity: 0;
        visibility: hidden;
        display: flex;
        flex-direction: column;
        align-items: end;
        gap: 1rem;
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        background-color: #1c1c1c;
        padding: 2rem;
        box-shadow: 0 0 0 100vmax rgba(0, 0, 0, .5);
      }

      .nav.visible {
        opacity: 1;
        visibility: visible;
      }

      .nav-list {
        flex-direction: column;
        align-items: end;
      }

      .nav-list li a {
        color: #ecececec;
      }
    }
  </style>
</head>

<body>

  <header>
    <img class="logo" src="https://i1.wp.com/seindelperu.com/wp-content/uploads/2019/01/cropped-SEINDEL-PERU-01-crop.png?fit=1574%2C369&ssl=1" alt="Logo">
    <button id="abrir" class="abrir-menu"><i class="bi bi-list"></i></button>
    <nav class="nav" id="nav">
      <button class="cerrar-menu" id="cerrar"><i class="bi bi-x"></i></button>
      <ul class="nav-list">
        <li><a href="#">Inicio</a></li>
        <li><a href="#">Quiénes somos</a></li>
        <li><a href="#">Servicios</a></li>
        <li><a href="#">Qué hacemos</a></li>
        <li><a href="#">Contacto</a></li>
      </ul>
    </nav>
  </header>

  <script src="./js/main.js"></script>
</body>

</html>