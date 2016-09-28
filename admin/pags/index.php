<?php $N_FORM = 0;
require "../lib/pagina.php";
function existeUsuario()
{
	$sql = "SELECT COUNT(*) AS total FROM empleados;";
	$res = pagina::obtenerFilas($sql);
    //echo var_dump($res);
	return ($res['todos'] == '0');
}

// if (!existeUsuario())
//     header("Location: crear_primer_usuario.php");

echo pagina::header('Inicio', true);
 ?>

<div class="container">
	<div class="row">
<!--INSERTAR GRÁFICOS AQUÍ-->

<!-- script del grafivo -->
    <div class= "col m12">
<div id="container2" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<p></p>

</div>
<div  class="row">
    <div class= "col m4">

    <div id="container3" style="height: 400px"></div>

        </div>
        <div class= "col m4">
            <div id="container4" style="min-width: 310px; height: 400px; max-width: 600px; margin: 0 auto"></div>
        </div>
        <div class="col m4">
            <div id="container5" style="min-width: 310px; max-width: 400px; height: 400px; margin: 0 auto"></div>
        <br>
        <br>
        </div>
        <p></p>
        <p></p>
        <br>
        <br>
        <div class="row">
        <div class="col m12">
            <div id="container6" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
        </div>
    </div>
</div>

<!-- TERMINA EL PRIMER GRAFICO -->


<!-- COMIENZA EL PRIMERO -->
<?php
echo pagina::footer();
?>

<script src='https://code.highcharts.com/highcharts.js'></script>
<script src='https://code.highcharts.com/modules/exporting.js'></script>

<script type="text/javascript">
    $(document).ready(mostrarResultados(2016));   //muestra las ventas por default 2016
                function mostrarResultados(año){
                    $.ajax({
                        type:'POST',
                        url:'proceso.php', //archivo del calculo
                        data:'año='+año,
                        success:function(data){ //devuelve el json data
                            var valores = eval(data);  //Convierte los valores en arreglos
                            var e   = valores[0];
                            var f   = valores[1];
                            var m   = valores[2];
                            var a   = valores[3];
                            var ma  = valores[4];
                            var j   = valores[5];
                            var jl  = valores[6];
                            var ag  = valores[7];
                            var s   = valores[8];
                            var o   = valores[9];
                            var n   = valores[10];
                            var d   = valores[11];
                            $(function () {
                                $('#container2').highcharts({
                                    chart: {
                                        type: 'column'
                                    },
                                    title: {
                                        text: 'Total Ventas por Mes'
                                    },
                                    subtitle: {
                                        text: 'Jugueton- Juguesal S.S.'
                                    },
                                    xAxis: {
                                        categories: [
                                            'Jan',
                                            'Feb',
                                            'Mar',
                                            'Apr',
                                            'May',
                                            'Jun',
                                            'Jul',
                                            'Aug',
                                            'Sep',
                                            'Oct',
                                            'Nov',
                                            'Dec'
                                        ],
                                        crosshair: true
                                    },
                                    yAxis: {
                                        min: 0,
                                        title: {
                                            text: 'Cantidad ($)'
                                        }
                                    },
                                    tooltip: {
                                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                            '<td style="padding:0"><b>{point.y:.1f} $</b></td></tr>',
                                        footerFormat: '</table>',
                                        shared: true,
                                        useHTML: true
                                    },
                                    plotOptions: {
                                        column: {
                                            pointPadding: 0.2,
                                            borderWidth: 0
                                        }
                                    },
                                    series: [{
                                        name: 'Enero',
                                        data: [e]

                                    }, {
                                        name: 'Febrero',
                                        data: [f]

                                    }, {
                                        name: 'Marzo',
                                        data: [m]

                                    }, {
                                        name: 'Abril',
                                        data: [a]

                                    },
                                    {
                                        name: 'Mayo',
                                        data: [ma]

                                    },
                                    {
                                        name: 'Junio',
                                        data: [j]

                                    },
                                    {
                                        name: 'Julio',
                                        data: [jl]

                                    },
                                    {
                                        name: 'Agosto',
                                        data: [ag]

                                    },
                                    {
                                        name: 'Septiembre',
                                        data: [s]

                                    },
                                    {
                                        name: 'Octubre',
                                        data: [o]

                                    },
                                    {
                                        name: 'Noviembre',
                                        data: [n]

                                    },
                                    {
                                        name: 'Diciembre',
                                        data: [d]

                                    }]
                                });
                            });
                        }
                    });
                    return false;
                }
</script>


<!-- SEGUNDO GRAFICO -->

		<script type="text/javascript">

 $(document).ready(mostrarResultados(2016));   //muestra las ventas por default 2016
                function mostrarResultados(año){
                    $.ajax({
                        type:'POST',
                        url:'proceso2.php', //archivo del calculo
                        data:'año='+año,
                        success:function(data){ //devuelve el json data

                            var valores = eval(data);  //Convierte los valores en arreglos

                            var e   = valores[0];
                            var f   = valores[1];
                            var m   = valores[2];
                            var a   = valores[3];
                            var ma  = valores[4];
                            var j   = valores[5];
                            var jl  = valores[6];
                            var ag  = valores[7];
                            var s   = valores[8];
                            var o   = valores[9];
                            var n   = valores[10];
                            var d   = valores[11];
 $(function () {
    $('#container3').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45
            }
        },
        title: {
            text: 'Clientes Registrados por mes'
        },
        subtitle: {
            text: 'Jugueton - Juguesal S.S'
        },
        plotOptions: {
            pie: {
                innerSize: 100,
                depth: 45
            }
        },
        series: [{
            name: 'Registrados',
            data: [
                ['Enero', e],
                ['Febrero', f],
                ['Marzo', m],
                ['Abril', a],
                ['Mayo', ma],
                ['Junio', j],
                ['Julio', jl],
                ['Agosto', ag],
                ['Septiembre', s],
                ['Octubre', o],
                ['Noviembre', n],
                ['Diciembre', d]
            ]
        }]
                                });
                            });
                        }
                    });
                    return false;
                }
		</script>




		<!-- INICIA TERCER GRAFICOOOOOO -->

<script type="text/javascript">
 $(document).ready(mostrarResultados(2016));   //muestra las ventas por default 2016
                function mostrarResultados(año){
                    $.ajax({
                        type:'POST',
                        url:'proceso3.php', //archivo del calculo
                        data:'año='+año,
                        success:function(data){ //devuelve el json data

                            var valores = eval(data);  //Convierte los valores en arreglos

                            var e   = valores[0];
                            var f   = valores[1];
                            var m   = valores[2];
                            var a   = valores[3];
                            var ma  = valores[4];
                            var j   = valores[5];
                            var jl  = valores[6];
                            var ag  = valores[7];
                            var s   = valores[8];
                            var o   = valores[9];
                            var n   = valores[10];
                            var d   = valores[11];
$(function () {
    $('#container4').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'Sesiones iniciadas por mes'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'sesiones iniciadas',
            data: [
                ['Enero', e],
                ['Febrero', f],
                ['Marzo', m],
                ['Abril',a],
                ['Mayo',ma],
                ['Junio', j],
                ['Julio', jl],
                ['Agosto', ag],
                ['Septiembre', s],
                ['Octubre', o],
                ['Noviembre', n],
                ['Diciembre', d]
            ]
        }]
                                });
                            });
                        }
                    });
                    return false;
                }
</script>


<!-- INICIA CUARTO GRAFICOOOOOO -->
<script type="text/javascript">
$(document).ready(mostrarResultados(2016));   //muestra las ventas por default 2016
                function mostrarResultados(año){
                    $.ajax({
                        type:'POST',
                        url:'proceso4.php', //archivo del calculo
                        data:'año='+año,
                        success:function(data){ //devuelve el json data
                            var valores = eval(data);  //Convierte los valores en arreglos
                            var e   = valores[0];
                            var f   = valores[1];
                            var m   = valores[2];
                            var a   = valores[3];
                            var ma  = valores[4];
                            var j   = valores[5];
                            var jl  = valores[6];
                            var ag  = valores[7];
                            var s   = valores[8];
                            var o   = valores[9];
                            var n   = valores[10];
                            var d   = valores[11];

$(function () {
    $('#container5').highcharts({
        chart: {
            type: 'pie',
            options3d: {
                enabled: true,
                alpha: 45,
                beta: 0
            }
        },
        title: {
            text: 'Usuarios registrados por mes'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 35,
                dataLabels: {
                    enabled: true,
                    format: '{point.name}'
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'usuarios registrados',
            data: [
                ['Enero', e],
                ['Febrero', f],
                ['Marzo',m],
                ['Abril',a],
                ['Mayo',ma],
                ['Junio',j],
                ['Julio',jl],
                ['Agosto',ag],
                ['Septiembre',s],
                ['Octubre',o],
                ['Noviembre',n],
                ['Diciembre',d]
            ]
        }]
                                });
                            });
                        }
                    });
                    return false;
                }
</script>


<!-- INICIA EL QUINTO GRAFICO -->

<script type="text/javascript" >
 $(document).ready(mostrarResultados(2016));   //muestra las ventas por default 2016
                function mostrarResultados(año){
                    $.ajax({
                        type:'POST',
                        url:'proceso6.php', //archivo del calculo
                        data:'año='+año,
                        success:function(data){ //devuelve el json data
                            var valores = eval(data);  //Convierte los valores en arreglos
                            var e   = valores[0];
                            var f   = valores[1];
                            var m   = valores[2];
                            var a   = valores[3];
                            var ma  = valores[4];
                            var j   = valores[5];
                            var jl  = valores[6];
                            var ag  = valores[7];
                            var s   = valores[8];
                            var o   = valores[9];
                            var n   = valores[10];
                            var d   = valores[11];
                            $(function () {
                                $('#container6').highcharts({
                                    chart: {
                                        type: 'column'
                                    },
                                    title: {
                                        text: 'Total Productos Vendidos por Mes'
                                    },
                                    subtitle: {
                                        text: 'Jugueton- Juguesal S.S.'
                                    },
                                    xAxis: {
                                        categories: [
                                            'Jan',
                                            'Feb',
                                            'Mar',
                                            'Apr',
                                            'May',
                                            'Jun',
                                            'Jul',
                                            'Aug',
                                            'Sep',
                                            'Oct',
                                            'Nov',
                                            'Dec'
                                        ],
                                        crosshair: true
                                    },
                                    yAxis: {
                                        min: 0,
                                        title: {
                                            text: 'Cantidad ($)'
                                        }
                                    },
                                    tooltip: {
                                        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                                        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                            '<td style="padding:0"><b>{point.y:.1f} $</b></td></tr>',
                                        footerFormat: '</table>',
                                        shared: true,
                                        useHTML: true
                                    },
                                    plotOptions: {
                                        column: {
                                            pointPadding: 0.2,
                                            borderWidth: 0
                                        }
                                    },
                                    series: [{
                                        name: 'Enero',
                                        data: [e]

                                    }, {
                                        name: 'Febrero',
                                        data: [f]

                                    }, {
                                        name: 'Marzo',
                                        data: [m]

                                    }, {
                                        name: 'Abril',
                                        data: [a]

                                    },
                                    {
                                        name: 'Mayo',
                                        data: [ma]

                                    },
                                    {
                                        name: 'Junio',
                                        data: [j]

                                    },
                                    {
                                        name: 'Julio',
                                        data: [jl]

                                    },
                                    {
                                        name: 'Agosto',
                                        data: [ag]

                                    },
                                    {
                                        name: 'Septiembre',
                                        data: [s]

                                    },
                                    {
                                        name: 'Octubre',
                                        data: [o]

                                    },
                                    {
                                        name: 'Noviembre',
                                        data: [n]

                                    },
                                    {
                                        name: 'Diciembre',
                                        data: [d]

                                    }]
                                });
                            });
                        }
                    });
                    return false;
                }
</script>