<!DOCTYPE html>
<html lang="en">

<head>
    <title></title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/style.css" rel="stylesheet">
</head>

<h1>Informe de Equipos de Salida</h1>

@if(count($datos) > 0)
<table border="1">
    <thead>
        <tr>
            <th>Producto</th>
            <th>Descripción</th>
            <th>Cantidad</th>
            <th>Código</th>
            <th>Marca</th>
        </tr>
    </thead>
    <tbody>
        @foreach($datos as $detalle)
        <tr>
            <td>{{ $detalle['nom_producto'] }}</td>
            <td>{{ $detalle['descripcion'] }}</td>
            <td>{{ $detalle['cantidad'] }}</td>
            <td>{{ $detalle['codigo'] }}</td>
            <td>{{ $detalle['marca'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<p>No hay datos disponibles para mostrar en el informe.</p>
@endif
</body>

</html>