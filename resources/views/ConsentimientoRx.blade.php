<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <style>
        .logo-medical {
            width: 125px;
            height: 125px;
            display: inline;
            background-color: violet;
        }

        .title {
            text-align: center;
            display: inline-flex;
            margin-left: 90px;
            font-family: Arial, Helvetica, sans-serif;
            font-weight: bold;
        }

        .title-2 {
            font-family: Arial, Helvetica, sans-serif;
            text-align: center;
            margin-top: -20px;
        }

        .field {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            font-weight: bolder;
            border: 0px;
        }

        .tabla-datos {
            margin-top: -15px;
        }

        .tabla-fila2 {
            margin-top: -3px;
        }
    </style>
    <fieldset class="field">
        <img class="logo-medical" src="https://media.licdn.com/dms/image/C4E0BAQGdGg80HfBiDA/company-logo_200_200/0/1605032440553?e=2147483647&v=beta&t=6dCmjP7cAX4UqPCjV7Y01uRfvlwJzscRd1OHnCTKYpo" alt="">
        <h2 class="title">
            <u>
                CONSENTIMIENTO INFORMADO RX
            </u>
        </h2>
        <h2 class="title-2">
            CONSENTIMIENTO INFORMADO PARA TOMA DE RADIOGRAFÍAS
        </h2>

        <p style="margin-left: 3px;"> Datos de identificación </p>
        <table class="tabla-datos">
            <tr>
                <td>
                    <p> Nombre: </p>
                </td>
                <td><?php echo $nombre ?></td>
            </tr>
            <tr>
                <td>
                    <p class="tabla-fila2">Edad:</p>
                </td>
                <td>
                    <p class="tabla-fila2"><?php echo $edad ?></p>
                </td>
                <td>
                    <p class="tabla-fila2">Sexo:</p>
                </td>
                <td>
                    <p class="tabla-fila2"><?php echo $sexo ?></p>
                </td>
                <td>
                    <p style="margin-left:160px; margin-top:-2px;"> No. Documento:</p>
                </td>
                <td>
                    <p class="tabla-fila2"><?php echo $nroDocumento ?></p>
                </td>
            </tr>
        </table>
        <p style="text-align:justify; font-weight:normal; line-height:18px;">
            Yo, <?php echo $nombre ?>, identificado con DNI N°<?php echo $nroDocumento ?> actuando en mi propio nombre
            declaro que he sido suficientemente informado en terminos claros y comprensibles por el profesional
            respectivo acerca de la toma de la RADIOGRAFIA. <br>
            ¿En qué consiste? A usted se le va realizar una exploración radiológica que utiliza radiación ionizante, en
            forma de rayos X, para proporcionar una información diagnóstica que nos ayudará a identificar y tratar mejor
            su enfermedad si fuera asi el caso. El paciente adoptara la postura mas idónea, dependiendo de la zona
            estudiar permaneciendo inmovil durante un corto periodo de tiempo necesario para obtener la imagen
            (normalmente unos segundos) <br>
            ¿Como se realiza? El tecnólogo lo ubicara correctamente, en el cual usted adoptara algunas posiciones
            sugerids por el profesional tomandose una serie de proyecciones que permitira llevar a cabo el procedimiento
            solicitado. Se trata de una prueba diagnostica que permite visualizar el interior de una zona del cuerpo
            utilizando rayos X y procesando las imágenes por ordenador midiendo la absorción de los rayos X por los
            diferentes tejidos. <br>
            ¿Que molestias puede provocar? Las molestias ocasionadas sólo serán las relacionadas con la posición que
            se tenga que adoptar para realizar el examen <br>
            ¿Que riesgos puede ocasionar? A pesar que las dosis empleadas son las minimas, para poder obtener la
            imagen hay que tener en cuenta que se utilizan radiaciones ionizante. Se le ha indicado un procedimiento en
            el que se utilizan rayos X. El riesgo potencial de la radiación incluye una ligera elevación de riesgo de padecer
            cancer dentro de algunos años. Este riesgo es menor del 0.5% por lo que se puede considerar muy bajo. Los
            rayos X pueden ser perjudiciales para el desarrollo del feto. Por lo que se esta contraindicando, en el caso de
            embarazo, si está o cree que puede estar embarazada, por favor comuniqueselo al tecnólogo médico que atenderá. <br>
            El profesional me ha indicado la necesidad de la toma de la radiografía, para el diagnostico, tratamiento
            control de mi patología, por lo cual me ha interrogado si estoy en embarazo caso fuera ese mi estado me ha
            explicado claramente lo siguiente: Los rayos X son potencialmente peligrosos para el feto, no obstante, con
            los aparatos y las técnicas actuales, la cantidad de radiación que se recibe es minima. <br>
            Certifico que he leído y comprendido perfectamente lo anterior y que todos los espacios en blanco han sido
            completados antes de mi firma y que me encuentro en libertad de expresar mi libre albedrío y por lo tanto
            autorizo. <br><br>
            SI ____ NO____estoy embarazada. <br><br>
            SI ____ NO____la toma de radiografía. <br> <br>
            Fecha: <?php echo $fecha ?>
        </p>
        <div>
            <table align="right" style="border-collapse:collapse; border:solid">
                <tr >
                    <td style="border-bottom:solid; width:200px;">
                        <p style="text-align:center">Firma del paciente</p>
                    </td>
                    <td style="border-bottom:solid; border-left:solid; width:200px;">
                        <p style="text-align:center">Huella digital</p>
                    </td>
                </tr>
                <tr>
                    <td style="height: 100px;">
                        <p></p>
                    </td>
                    <td style="height: 100px; border-left:solid">
                        <p></p>
                    </td>
                </tr>
            </table>
        </div>


    </fieldset>
</body>

</html>