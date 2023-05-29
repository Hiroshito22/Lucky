<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historia Ocupacional</title>
    <style>
        .contenedor-padre{
            margin-bottom: -30px;
        }

        /**tabla de la cabecera*/
        .tabla-header {
            width: 100%; 
            height: 100px; 
            border: 1px solid black;
            border-collapse: collapse;
        }
        .tabla-header td{
            border: 1px solid black;
            text-align: center; 
            color: rgb(26, 125, 125);
        }

        /** */
        .identifcador {
            width: 100%;
            border: none;
        }
        .identifcador th {
            font-size: 16px;
        }

        th , td{
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
        }


        /** Segunda tabla-El cuadro*/
        /** -----------------------------------------------------------------*/
        .datos{
            width: 100%;
            border: 1px solid black;
            border-collapse: collapse;
        }
        .datos th {
            border: 1px solid black;
            
        }
        .datos td {
            border: 1px solid black;
            height: 45%;
        }

        /** Contenedores de la fecha y firmas*/
        .caja-padre {
            width: 100%;
            height: 100px;
            position: relative;
           

        }
        .caja-hijo-1 {
            position: absolute;
            width: 170px;
            height: 100px;
            top: 25px;
            left: 30%;
            
        }
        .caja-hijo-2 {
            position: absolute;
            width: 200px;
            height: 100px;
            left: 55%;
            
        }
        .caja-hijo-3 {
            position: absolute;
            width: 200px;
            height: 100px;
            left: 80%;
             
        }

        /** tabla de las fecha: Año Mes Dia*/
        .fecha-th {
            width: 170px;
            border: 1px solid black;
            border-collapse: collapse;
        }
        .fecha-th th{
            height: 17px;
            border: 1px solid black;
            
        }

        .fecha-td {
            width: 100%;
            height: 30px;
            top: 25px;
            text-align: center;
        }

        /** firma del trabajador*/
        .firma-trabajador-th {
            width: 100%;
            height: 30px;
        }
        .firma-trabajador-td {
            width: 100%;
            text-align: center;
            
        }

        /** Firma del medico*/
        .firma-medico-th {
            width: 100%;
            height: 30px;
        }
        .firma-medico-td{
            width: 100%;
            text-align: center;
        }

        
    </style>
</head>
<body>
    
    <div class="contenedor-padre">
        <header>
            <table class="tabla-header" >
                <tr>
                    <td><img src="https://www.mineraboroo.com/storage/datos-globales/August2022/QB30qh7lGgq18ezeVC4d-cropped.png" style="height: 30px; margin: 10px;"></td>
                    <td style="font-size: 12px;">MINERA BORBOO MISQUICHICA S.A. <br>
                    SALUD E HIGIENE OCUPACIONAL
                    </td>
                    <td rowspan="2" style="font-size: 10px;">Versión 01 <br>
                    Rev.01: 25 jul.2021 <br>
                    Pagina 1 de 2
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 10px;">MBM-SHO-FOR-002-A</td>
                    <td style="font-size: 10px;">FORMATO: FICHA MÉDICO OCUPACIONAL - ANEXO 16 - HISTORIA OCUPACIONAL</td>
                </tr>
            </table>
        </header>
        <table class="identifcador">
            <thead>
                <tr>
                    <th >HISTORIA OCUPACIONAL</th>
                </tr>
            </thead>
            <tbody>
                <table style="width: 100%;">
                    <tr>
                        <td colspan="2">Apellidos y Nombres:</td>
                        <td >__________________________________________________</td>
                        <td >N° Registro:</td>
                        <td >___________</td>
                        <td >Fecha Nacimiento:</td>
                        <td >_________</td>
                        <td > Sexo:</td>
                        <td >_____</td>
                    </tr>
                    <tr>
                        <td colspan="2">Lugar de Nacimiento:</td> 
                        <td >__________________________________________________</td>    
                        <td colspan="2">Lugar de procedencia:</td>
                        <td colspan="4">___________________________________________</td>
                    </tr>
                    <tr>
                        <td >Profesión:</td>
                        <td colspan="2">___________________________________________________________</td>
                        <td colspan="6"></td>
                    </tr>
                </table>
            </tbody>
        </table>
        <br>
        <table class="datos">
            <thead>
                <tr>
                    <th rowspan="2">Fecha de Inicio</th>
                    <th rowspan="2">Empresas</th>
                    <th rowspan="2">Altitud</th>
                    <th rowspan="2">Actividades de la <br> Empresa</th>
                    <th rowspan="2">Area de trabajo</th>
                    <th rowspan="2">Ocupación</th>
                    <th colspan="2">Tiempo de Trabajo</th>
                    <th rowspan="2">Peligros / Agentes <br> Ocupacionales</th>
                    <th colspan="1">Uso EPP</th>
                </tr>
                <tr>
                    <th>Subsuelo</th>
                    <th>Superficie</th>
                    <th>Tipo EPP</th>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </thead>
        </table>
        <br>
        <div class="caja-padre">
            <div class="caja-hijo-1">
                <table style="width: 100%;">
                    <thead>
                        <table class="fecha-th" >
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </table>
                    </thead>
                    <tbody>
                        <table class="fecha-td" >
                            <tr>
                                <td>Año</td>
                                <td>Mes</td>
                                <td>Día</td>
                            </tr>
                        </table>
                    </tbody>
                </table>
            </div>
    
            <div class="caja-hijo-2">
                <table style="width: 100%;">
                    <thead>
                        <table class="firma-trabajador-th">
                            <tr>
                                <th></th>
                            </tr>
                        </table>
                    </thead>
                    <hr>
                    <tbody>
                        <table class="firma-trabajador-td">
                            <tr>
                                <td>Firma del Trabajador</td>
                            </tr>
                        </table>
                    <tbody>
                </table>
            </div>
            <div class="caja-hijo-3">
                <table style="width: 100%;">
                    <thead>
                        <table class="firma-medico-th">
                            <tr>
                                <th></th>
                            </tr>
                        </table>
                    </thead>
                    <hr>
                    <tbody>
                        <table class="firma-medico-td">
                            <tr>
                                <td> Medico del Trabajo</td>
                            </tr>
                        </table>
                    <tbody>
                </table>
            </div>
        </div>
        <footer style="with: 100%; font-size: 10px;">
        Nota: Este documento ha sido elaborado y adaptado por el Área de Salud Ocupacional de MBM, tomando como referencia lo establecido en los Anexos del D.S.024-2016-EM; para la Evaluación Médica Ocupacional de los trabajadores en la Empresa.
        </footer>
    </div>

</body>
</html>