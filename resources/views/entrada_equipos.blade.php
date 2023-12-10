<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Equipos</title>
    <style>
        /* * {
            font-family: Arial, Helvetica, sans-serif;
        } */
        @page {
            margin: 50px 25px;
            /* Establece los márgenes de la página */
            counter-increment: page;
            /* Incrementa el contador de páginas */
            content: "Página " counter(page);
            /* Muestra el número de página */
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        .center-table {
            margin: 0 auto;
            border-collapse: collapse;
            border: 1px solid black;
            margin-bottom: 10px;
        }

        .center-table h4 {
            text-align: center;
            color: #005D94;
            font-family: Arial, Helvetica, sans-serif;
            /* letra */
            font-size: 16px;
        }

        .center-table .subt {
            text-align: center;
            margin-top: -12px;
            color: #005D94;
            font-family: Arial, Helvetica, sans-serif;
            /* letra */
            font-size: 12px;
        }

        .subt1 {
            text-align: center;
            color: #005D94;
            font-family: Arial, Helvetica, sans-serif;
            /* letra */
            font-size: 12px;
        }

        .subt2 {
            text-align: center;
            padding-top: 5px;
            color: #005D94;
            font-family: Arial, Helvetica, sans-serif;
            /* letra */
            font-size: 12px;
        }

        .subt3 {
            text-align: center;
            margin-top: -5px;
            color: #005D94;
            font-family: Arial, Helvetica, sans-serif;
            /* letra */
            font-size: 12px;
        }

        .center-table h5 {
            text-align: center;
            color: #005D94;
            font-family: Arial, Helvetica, sans-serif;
            /* letra */
            font-size: 13px;
        }

        .center-table h3 {
            text-align: center;
            color: #007FFF;
            font-family: "Arial MT";
            font-size: 16px;
        }

        .center-table td {
            line-height: 6px;
        }

        .imgk {
            text-align: center;
            vertical-align: middle;
            width: 10PX;
            height: 10PX;
        }

        .center-table1 {
            margin: 0 auto;
            border-collapse: collapse;
            border: 1px solid black;
            width: 75%;
            margin-bottom: 10px;
        }

        .center-table1 p {
            text-align: center;
        }

        .center-table2 {
            margin: 0 auto;
        }

        .center-table2 p {
            font-family: sans-serif;
            padding: 10px
        }

        .footer {
            text-align: center;
            vertical-align: middle;
            width: 150px;
            height: 150px;
        }

        .footer1 {
            margin-left: 10px;
        }

        .footer p {
            text-align: center;
        }

        .footer1 p {

            align-items: center;
            text-align: center;
            justify-content: center;
        }

        .justi {
            text-align: justify;
        }

        .center-table1 {
            text-align: center;
        }
    </style>
</head>

<body>
    @csrf
    <div style="text-align: center; margin-bottom: 10px;">
        <table style="width: 100%;" border="1" class="center-table">
            <tr>
                <td class="imgk"><img src="https://i1.wp.com/seindelperu.com/wp-content/uploads/2019/01/cropped-SEINDEL-PERU-01-crop.png?fit=1574%2C369&ssl=1" width="500" height="10%"></td>
                <td style="padding: 0px; margin: 0px;" rowspan="2">
                    <p class="subt1">Versión 01</p>
                    <p class="subt1">Página 1</p>
                </td>
            </tr>
            <tr>
                <td style="padding: 0px; margin: 0px;">
                    <p class="subt1">Suministros e Inversiones Del Perú E. I. R. L</p>
                </td>
            </tr>
        </table>
    </div>

    <br>
    <div style="text-align: right; margin-bottom: 10px;">
        <p style="margin: 0;">Fecha del Reporte: {{ date('Y-m-d') }}</p>
        <p style="margin: 0;">Hora del Reporte: {{ date('H:i:s') }}</p>
    </div>
    <h3 style="text-align: center;">Reporte de Equipos y Productos de Entrada</h3>
    <!-- <div style="text-align: right; margin-bottom: 10px;">
        <p style="margin: 0;">Fecha del Reporte: {{ date('Y-m-d') }}</p>
        <p style="margin: 0;">Hora del Reporte: {{ date('H:i:s') }}</p>
    </div> -->
    @if(count($datos) > 0)
    <table border="1" class="center-table1">
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
                <td>{{ $detalle['nom_producto'] }} </td>
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
    <br>
    <script>
        // Agrega este script para actualizar el número de página en cada página
        window.onload = function() {
            var pageCounter = 1;
            var pageSpan = document.getElementById('page');
            pageSpan.innerHTML = pageCounter;
            window.onafterprint = function() {
                pageCounter++;
                pageSpan.innerHTML = pageCounter;
            }
        }
    </script>
</body>

</html>