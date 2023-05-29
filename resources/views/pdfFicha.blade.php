<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" >
    <title>Reporte 01</title>
    <style>
        table{

            width: 100%;
            border: 1px solid black;
            font-family: Arial;
        }
        th{
            text-align: center;
            border-bottom: 0px;
            border: 1px solid black;
            font-family: Arial;
        }
        td{
            border: 1px solid black;
            WIDTH: 10%;
            HEIGHT: 8%;
            font-family: Arial;
        }
        .subtext{
            vertical-align: text-top;
            border: 1px solid black;
            WIDTH: 10%;
            HEIGHT: 85%;
            font-family: Arial;
        }
        .colum{
            font-family: Arial;
            border: 1px solid black;
        }
        .bar{
            justify-content: center;
            font-size: 100px;
            font-family: Arial;
        }
        .subtitulo{
            text-align: left;
            border: 1px solid black;
            font-size:10px;
            font-family: Arial;
        }
        .p{
            text-align:center;
            line-height: 0px;
            margin-top: -8%;
            font-weight: bold;
            text-decoration-color:black;
            text-decoration: underline;
            font-family: Arial;
        }
        @page{
            margin-left: 1cm;
            margin-right: 1cm;
        }
        .header{
            border: 0px;
            WIDTH: -1%;
            HEIGHT: 0%;
            font-family: Arial;
            font-size: 10px;
        }
        .header03{
            border: 0px;
            WIDTH: 22%;
            HEIGHT: 0%;
            font-family: Arial;
            font-size: 10px;
            text-indent: 0%;
        }
        .imgrh03{
            font-weight:normal;
            border: 0px;
            WIDTH: -10%;
            HEIGHT: 0%;
            font-size:10px;
            font-family: Arial;
            text-indent:-130%;
        }
        .head{
            width: 100%;
            border: 0px;
            margin-top: -8%;
            font-family: Arial;
        }
        .head01{
            width: 100%;
            border: 0px;
            margin-top: 1.5%;
            font-family: Arial;
        }
        .imgr{
            text-indent:40%;
            border: 0px;
            WIDTH: -5%;
            HEIGHT: 0%;
            font-size:10px;
            font-family: Arial;
            font-weight: bold;
        }
        .imgrh{
            font-weight:normal;
            border: 0px;
            WIDTH: 0%;
            HEIGHT: 0%;
            font-size:10px;
            font-family: Arial;
            text-indent:-2%;
        }
        .header01{
            text-align:right;
            border: 0px;
            HEIGHT: 0%;
            WIDTH: 60%;
            font-size:12px;
            font-family: Arial;
        }
        .header02{
            text-align:right;
            border: 0px;
            HEIGHT: 0%;
            WIDTH: 60%;
            font-weight: bold;
            font-size:11px;
            font-family: Arial;
        }
        .info{
            font-weight: bold;
            font-family: Arial;
        }
        .footer{
            position: fixed;
            font-family:Arial;
            color: darkgray;
            font-size: 10px;
            bottom: 0cm;
            left: 0cm;
            width: 100%;
            right: 0cm;
            height: 1%;
        }
        h4{
            text-align: center;
            width: 100%;
            font-family: Arial;
        }
        .cabezera{
            line-height: 11px;
            position: fixed;
            top: -85px;
            left: 0px;
            right: 0px;
            font-family: Arial;
        }
        body {
            margin-top: 14%;
            margin-left: 0%;
            margin-right: 0%;
            margin-bottom: 12%;
            font-family: Arial;
            }
        .parrf{
            line-height: 2px;
            text-indent:10%;
            font-family: Arial;
        }
        .parr{
            line-height: 2px;
        }
        .fecha{
            margin-top: -12.5%;
            margin-left: 92%;
            margin-right: 0%;
            margin-bottom: 0%;
            font-size:11px;
            font-family: Arial;
        }
        .hora{
            margin-top: -12.5%;
            margin-left: 22%;
            margin-right: 0%;
            margin-bottom: 0%;
            font-size:11px;
            line-height: 10px;
            font-weight: bold;
            font-family: "Arial";
        }
        img{
            margin-top: 3%;
        }
        .cuadro{
            vertical-align: text-top;
            font-family: Arial;
        }
    </style>
</head>

<body>

    <div class="cabezera">
        <div>
            <img src="https://media.licdn.com/dms/image/C4E0BAQGdGg80HfBiDA/company-logo_200_200/0/1605032440553?e=2147483647&v=beta&t=6dCmjP7cAX4UqPCjV7Y01uRfvlwJzscRd1OHnCTKYpo"
             width="20%" height="12%"/>
        </div>
        <div><p class="p">FICHA DE RECORRIDO</p></div>
        <script type="text/php">
        if ( isset($pdf) ) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Arial");
                $pdf->text(525, 10, "Page $PAGE_NUM of $PAGE_COUNT", $font, 8);
            ');
        }
        </script>
        <div class="fecha">
            <?php
            $date = date('d/m/Y');
            echo ($date);
            ?>
            <div class="hora">
                <?php
                $hoy = date("H:i:s");
                echo ($hoy);
            ?>
            </div>
        </div>
        <div>
            <table class="head">
                <tbody class="">
                    <tr class="">
                        <td class="header01">Orden de atención: </td>
                        <td class="imgr">{{$ordenAtencion}} </td>
                    </tr>
                    <tr class="">
                        <td class="header02">EXAMEN ANUAL</td>
                        <td class="imgr"> </td>
                    </tr>
                </tbody>
            </table>
            <table class="head01">
                <tbody class="">
                    <tr class="info">
                        <td class="header">Trabajador:</td>
                        <td class="imgrh">{{$nombre}}, {{$apellido}}</td>
                        <td class="header03">Nro. Doc.:</td>
                        <td class="imgrh03">{{$doc}}</td>
                    </tr>
                    <tr class="info">
                        <td class="header">Ocupación:</td>
                        <td class="imgrh">{{$ocupacion}}</td>
                        <td class="header03">Edad:</td>
                        <td class="imgrh03">{{$edad}}</td>
                    </tr>
                    <tr class="info">
                        <td class="header">Empresa:</td>
                        <td class="imgrh">{{$empresa}}</td>
                        <td class="header03">Fecha: </td>
                        <td class="imgrh03">{{$fecha}}</td>
                    </tr>
                    <tr class="">
                        <td class="header">Plan:</td>
                        <td class="imgrh">{{$plan}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="footer">
        <p><h4>"Cuidemos el medio ambiente. Por favor no imprima este documento si no es necesario"</h4></p>
    </div>
    <main>
        <table class="">
            <thead class="">
                <tr class="colum">
                    <th>Servicio</th>
                    <th>Firma</th>
                </tr>
            </thead>
            <tbody class="">
                <tr class="subtitulo">
                    <td class="cuadro">* EVALUACIÓN OCUPACIONAL</td>
                    <td> </td>
                </tr>
                <tr class="subtitulo">
                    <td class="cuadro">* LABORATORIO <p></p> <p class="parrf">Hemograma</p>
                        <p class="parrf">Glucosa</p><p class="parrf">Colesterol</p>
                        <p class="parrf">Triglicéridos</p><p class="parrf">Examen completo de horina</p>
                    </td>
                    <td> </td>
                </tr>
                <tr class="subtitulo">
                    <td class="cuadro">* AUDIOMETRÍA</td>
                    <td> </td>
                </tr>
                <tr class="subtitulo">
                    <td class="cuadro">* RAYOS X - TORAX</td>
                    <td> </td>
                </tr>
                <tr class="subtitulo">
                    <td class="cuadro">* ESPIROMETRÍA</td>
                    <td> </td>
                </tr>
                <tr class="subtitulo">
                    <td class="cuadro">* OFTALMOLOGÍA - COMPLETO/Ectoscopia</td>
                    <td> </td>
                </tr>
                <tr class="subtitulo">
                    <td class="cuadro">* ELECTROCARDIOGRAMA - MAYORES DE 40 AÑOS</td>
                    <td> </td>
                </tr>
                <tr class="subtitulo">
                    <td class="cuadro">* EXAMEN PSICOLÓGICO - Test de estrés laboral: De<p></p>
                        <p class="parr">Estimulo y Respuesta</p>
                        <p class="parr">Prueba Psicológica que evalua áreas cognitiva y afectiva,Test</p>
                        <p class="parr">de somnolencia,COHEN</p>
                    </td>
                    <td> </td>
                </tr>
                <tr class="subtitulo">
                    <td class="cuadro">* DECLARACIÓN JURADA DE TRABAJO EN ALTURA ESTRUCTURAL</td>
                    <td> </td>
                </tr>
                <tr class="subtitulo">
                    <td class="cuadro">* TRIAJE</td>
                    <td> </td>
                </tr>

                <tr class="subtitulo">
                    <td class="cuadro">* OTROS </td>
                    <td> </td>
                </tr>
                <tr class="subtitulo">
                    <td class="subtext">* DOC. ADJUNTOS </td>
                    <td class="subtext"> </td>
                </tr>

            </tbody>
        </table>
    </main>


</body>

</html>
