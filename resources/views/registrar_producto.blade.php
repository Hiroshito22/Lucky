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
<form action="{{ route('registrar_producto') }}" method="post" id="formularioProductos" enctype="multipart/form-data">
    @csrf
    <div class="container" style="background-color: #A5FFEF;">
        <br>
        <h2 class="text-center" style="color: red;">REGISTRA TODOS LOS PRODUCTOS AL SISTEMA</h2>
        <div class="d-flex justify-content-center align-items-center" style="height: 10vh;">
            <button type="button" class="btn btn-primary" onclick="enviarFormulario()" style="width: 60%;">Guardar Producto</button>
        </div>
        <div class="form-group"></div>
        <hr>
        <div class="row">
            <aside class="col-sm-4">
                <div class="card">
                    <article class="card-body">
                        <h4 class="card-title mb-4 mt-1">Crear Producto</h4>
                        <form id="formularioProductos">
                            <div class="form-group">
                                <label>Nombre del Producto</label>
                                <input name="nom_producto" id="nom_producto" class="form-control" placeholder="Producto" type="text">
                            </div>
                            <div class="form-group">
                                <label>Descripcion del Producto</label>
                                <input name="descripcion" id="descripcion" class="form-control" placeholder="Descripcion" type="text">
                            </div>
                            <div class="form-group">
                                <label>Cantidad del Producto</label>
                                <input name="cantidad" id="cantidad" class="form-control" placeholder="0" type="number">
                            </div>
                            <div class="form-group">
                                <label>Código del Producto</label>
                                <input name="codigo" id="codigo" class="form-control" placeholder="codigo" type="text">
                            </div>
                            <div class="form-group">
                                <label>Marca del Producto</label>
                                <select class="form-control" id="marca_id" name="marca_id">
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

                        </form>

                    </article>
                </div>
                <br>
            </aside>
            <aside class="col-sm-4">
                <div class="card">
                    <article class="card-body">
                        <h4 class="card-title mb-4 mt-1">Crear Producto</h4>
                        <form id="formularioProductos">
                            <div class="form-group">
                                <label>Nombre del Producto</label>
                                <input name="nom_producto" id="nom_producto" class="form-control" placeholder="Producto" type="text">
                            </div>
                            <div class="form-group">
                                <label>Descripcion del Producto</label>
                                <input name="descripcion" id="descripcion" class="form-control" placeholder="Descripcion" type="text">
                            </div>
                            <div class="form-group">
                                <label>Cantidad del Producto</label>
                                <input name="cantidad" id="cantidad" class="form-control" placeholder="0" type="number">
                            </div>
                            <div class="form-group">
                                <label>Código del Producto</label>
                                <input name="codigo" id="codigo" class="form-control" placeholder="codigo" type="text">
                            </div>
                            <div class="form-group">
                                <label>Marca del Producto</label>
                                <select class="form-control" id="marca_id" name="marca_id">
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

                        </form>

                    </article>
                </div>
                <br>
            </aside>
            <aside class="col-sm-4">
                <div class="card">
                    <article class="card-body">
                        <h4 class="card-title mb-4 mt-1">Crear Producto</h4>
                        <form id="formularioProductos">
                            <div class="form-group">
                                <label>Nombre del Producto</label>
                                <input name="nom_producto" id="nom_producto" class="form-control" placeholder="Producto" type="text">
                            </div>
                            <div class="form-group">
                                <label>Descripcion del Producto</label>
                                <input name="descripcion" id="descripcion" class="form-control" placeholder="Descripcion" type="text">
                            </div>
                            <div class="form-group">
                                <label>Cantidad del Producto</label>
                                <input name="cantidad" id="cantidad" class="form-control" placeholder="0" type="number">
                            </div>
                            <div class="form-group">
                                <label>Código del Producto</label>
                                <input name="codigo" id="codigo" class="form-control" placeholder="codigo" type="text">
                            </div>
                            <div class="form-group">
                                <label>Marca del Producto</label>
                                <select class="form-control" id="marca_id" name="marca_id">
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

                        </form>

                    </article>
                </div>
                <br>
            </aside>

            <div class="col-sm-4">
                <button class="btn btn-primary" id="agregarProducto">Agregar otro producto</button>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                // Manejar el clic en el botón "Agregar otro producto"
                $("#agregarProducto").click(function() {
                    // Clona el primer aside y agrega la copia después del último aside
                    var nuevoAside = $("aside:first").clone();
                    nuevoAside.find("input, select").val(''); // Limpiar valores de los campos
                    nuevoAside.insertAfter("aside:last");
                });
            });

            function enviarFormulario() {
                var formData = new FormData(document.getElementById('formularioProductos'));
                // Realizar la solicitud AJAX para enviar los datos al servidor
                $.ajax({
                    url: '/registrar_producto',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
                        window.location.href = '{{ route("registrar_producto") }}';
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            }
        </script>
</form>



<br>