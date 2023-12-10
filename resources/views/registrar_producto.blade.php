<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <title>Registrar</title>
    <style>
        body {
            background-image: url('https://manfric.com/wp-content/uploads/2023/02/tipos-aire-acondicionado-industrial-manfric.jpg');
        }
    </style>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
</head>

<body>
@csrf
    <div class="container" style="background-color: #A5FFEF;">
        <br>
        <h2 class="text-center" style="color: red;">REGISTRA TODOS LOS PRODUCTOS AL SISTEMA</h2>
        <div class="col-sm-offset-2 col-sm-10">
            <button type="button" class="btn btn-default" id="btnCancelar" style="background-color: #B92727;">Cancelar</button>
        </div>
        <form action="{{ route('registrar_producto') }}" method="post">
            @csrf
            <button type="submit" class="btn btn-primary" style="width: 60%;">Guardar Producto</button>
            <div class="row" id="productos-container">
                <aside class="col-sm-4">
                    <div class="card">
                        <article class="card-body">
                            <h4 class="card-title mb-4 mt-1">Crear Producto</h4>
                            <div class="form-group">
                                <label for="productos[0][nom_producto]">Nombre del Producto</label>
                                <input name="productos[0][nom_producto]" class="form-control" placeholder="Producto" type="text">
                            </div>
                            <div class="form-group">
                                <label for="productos[0][descripcion]">Descripción del Producto</label>
                                <input name="productos[0][descripcion]" class="form-control" placeholder="Descripción" type="text">
                            </div>
                            <div class="form-group">
                                <label for="productos[0][cantidad]">Cantidad del Producto</label>
                                <input name="productos[0][cantidad]" class="form-control" placeholder="0" type="number">
                            </div>
                            <div class="form-group">
                                <label for="productos[0][codigo]">Código del Producto</label>
                                <input name="productos[0][codigo]" class="form-control" placeholder="codigo" type="text">
                            </div>
                            <div class="form-group">
                                <label for="productos[0][marca_id]">Marca del Producto</label>
                                <select class="form-control" name="productos[0][marca_id]">
                                    <option value="">Selecciona una Marca</option>
                                    <?php
                                    $conexion = new mysqli("localhost", "root", "", "lucky");

                                    if ($conexion->connect_error) {
                                        die("Conexión fallida: " . $conexion->connect_error);
                                    }

                                    $consulta = "SELECT id, nombre FROM marca";
                                    $resultado = $conexion->query($consulta);

                                    while ($fila = $resultado->fetch_assoc()) {
                                        echo "<option value='{$fila['id']}'>{$fila['nombre']}</option>";
                                    }
                                    $conexion->close();
                                    ?>
                                </select>
                            </div>
                        </article>
                    </div>
                    <br>
                </aside>

            </div>

        </form>
        <div class="col-sm-4">
            <button class="btn btn-primary" id="agregarProducto">Agregar otro producto</button>
        </div>

    </div>

    <script>
        $(document).ready(function() {
            var contador = 1; // Inicializar el contador

            // Manejar el clic en el botón "Agregar otro producto"
            $("#agregarProducto").click(function() {
                // Clona el primer aside y agrega la copia después del último aside
                var nuevoAside = $("aside:first").clone();
                nuevoAside.find("input, select").val(''); // Limpiar valores de los campos
                nuevoAside.find("[name^='productos[0]']").each(function() {
                    // Actualizar el nombre de los campos usando el nuevo índice
                    var nuevoNombre = $(this).attr("name").replace("[0]", "[" + contador + "]");
                    $(this).attr("name", nuevoNombre);
                });
                nuevoAside.appendTo("#productos-container");
                contador++; // Incrementar el contador
            });
        });
    </script>
    <script>
        document.getElementById('btnCancelar').onclick = function() {
            window.history.back();
        };
    </script>

</body>

</html>