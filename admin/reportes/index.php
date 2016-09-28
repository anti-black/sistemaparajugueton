<?php
require("../lib/pagina.php");
echo Pagina::header("Reportes");
?>
<div class="container">
    <h1>Reportes</h1>
    <div class="row">
        <div class="col s12">
            <div class="col s12 card teal z-depth-2">
                <h4 class="white-text">Reporte de registro de nuevas cuentas</h4>
                <div class="col s12 row">
                    <div class="col s12 card white z-depth-4">
                        <p>Todos los clientes que se han registrado dentro de éste año, se mostrarán en el documento.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <form id="rep1" class="col s12">
                    <p>Elija el interbalo de tiempo, no importa como lo tome se obtendrá su reporte dentro de ese rango. Según el modo que elija así se le mostrarán la información,
                    el modo de recuentosolo le dará el numero de clientes registrados ese día, mientras que el modo de información le dará información personal de los clientes dentro de esas fechas</p>
                    <div class="row">
                        <div class="input-field col s12 m6 l4">
                            <input id="inter0" type="date" class="datepicker" name='inter0' value='01/01/<?php echo date('Y'); ?>'>
                            <label for="inter0">Desde</label>
                        </div>
                        <div class="input-field col s12 m6 l4">
                            <input id="inter1" type="date" class="datepicker" name='inter1' value='<?php echo date('d/m/Y'); ?>'>
                            <label for="inter1">Hasta</label>
                        </div>
                        <div class="col s12 m6 l4">
                            <p>
                                <input class="with-gap" name="modo" type="radio" id="recu" value="0"  checked="checked" />
                                <label for="recu">Modo de recuento</label>
                            </p>
                            <p>
                                <input class="with-gap" name="modo" type="radio" id="info" value="1" />
                                <label for="info">Modo de información.</label>
                            </p>
                            <button class="btn waves-effect waves-light right" type="submit" name="action">Imprimir
                                <i class="material-icons right">print</i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col s12">
            <div class="col s12 card teal z-depth-2">
                <h4 class="white-text">Reporte de productos en escasez</h4>
                <div class="col s12 row">
                    <div class="col s12 card white z-depth-4">
                        <p>Todos los productos que cumplan con la cantidad mínima se les tomará como escasos y los podrás ver en el documento,
                        si éste resulta vació quiere decir que no hay productos escasos.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <form id="rep2" class="col s12">
                    <p>Elige una cantidad para tomarla como mínima, si hay productos con menos que eso aparecerán en el documento.</p>
                    <div class="row">
                        <div class="input-field col s12 m6 l4">
                            <input id="cantidad" name="cantidad" type="number" value="0" min="0" max="500" class="validate">
                            <label for="cantidad">Cantidad mínima</label>
                        </div>
                        <div class="col s12 m6 l4">
                            <p>
                                <input class="with-gap" name="incluyente" type="radio" id="mostrado" value="0"  checked="checked" />
                                <label for="mostrado">Muestra los productos ocultos</label>
                            </p>
                            <p>
                                <input class="with-gap" name="incluyente" type="radio" id="oculto" value="1" />
                                <label for="oculto">Ignora los productos ocultos</label>
                            </p>
                        </div>
                        <div class="col s12 m6 l4">
                            <button class="btn waves-effect waves-light right" type="submit" name="action">Imprimir
                                <i class="material-icons right">print</i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col s12">
            <div class="col s12 card teal z-depth-2">
                <h4 class="white-text">Análisis de experiencia de usuario</h4>
                <div class="col s12 row">
                    <div class="col s12 card white z-depth-4">
                        <p>El sistemas puede almacenar los diferentes sistemas operativos y los navegadores que se conectan para iniciar sesión del lado de público del sistema.
                        Elija los diferentes filtros para personalizar los resultados</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <form action="analisis_ux.php" method="post" enctype='multipart/form-data' id="rep3" class="col s12">
                    <p>Elije el sistema operativo y navegador que quieres que aparezca en el reporte.</p>
                    <div class="row">
                        <div class="input-field col s12 m6 l4">
                            <select multiple name="so[]">
                                <option value="" disabled selected>Todos</option>
                                <option value="1">Windows 10</option>
                                <option value="2">Windows 8.1</option>
                                <option value="3">Windows 8</option>
                                <option value="4">Windows 7</option>
                                <option value="5">Windows Vista</option>
                                <option value="6">Windows Server</option>
                                <option value="7">Windows XP</option>
                                <option value="8">Mac OS</option>
                                <option value="9">Linux</option>
                                <option value="10">Ubuntu</option>
                                <option value="11">iPhone</option>
                                <option value="12">iPod</option>
                                <option value="13">iPad</option>
                                <option value="14">Android</option>
                                <option value="15">BlackBerry</option>
                                <option value="16">Mobile</option>
                                <option value="17">Desconocido</option>
                            </select>
                            <label>Sistemas operativos</label>
                        </div>
                        <div class="input-field col s12 m6 l4">
                            <select multiple name="na[]">
                                <option value="" disabled selected>Todos</option>
                                <option value="1">InternetExplorer</option>
                                <option value="2">Firefox</option>
                                <option value="3">Safari</option>
                                <option value="4">Chrome</option>
                                <option value="5">Edge</option>
                                <option value="6">Opera</option>
                                <option value="7">Netscape</option>
                                <option value="8">Maxthon</option>
                                <option value="9">Konqueror</option>
                                <option value="10">Navegador Móvil</option>
                                <option value="11">Desconocido</option>
                            </select>
                            <label>Sistemas operativos</label>
                        </div>
                        <div class="col s12 m6 l4">
                            <button class="btn waves-effect waves-light right" type="submit">Imprimir
                                <i class="material-icons right">print</i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col s12">
            <div class="col s12 card teal z-depth-2">
                <h4 class="white-text">Ventas pendientes de validar.</h4>
                <div class="col s12 row">
                    <div class="col s12 card white z-depth-4">
                        <p>Imprime todos los comentarios de un producto dado junto con su comentador y la fecha y hora, en orden cronológico inverso (del más nuevo al más viejo)</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <form action="comentarios.php" method="post" enctype='multipart/form-data' id="rep3" class="col s12">
                    <p>Se mostrarán todas los comentarios según el productos elegido.</p>
                    <div class="row">
                        <div class="col s12 m6 l4">
                            <div class="input-field col s11">
                                <select id="prod" name="prod">
                                    <option value="" disabled selected>Elije el producto</option>
                                </select>
                                <label>Productos</label>
                            </div>
                            <div class="input-field col s11" id="preloaderX"></div>
                        </div>
                        <div class="col s12 m6 l4">
                            <div class="input-field col s12">
                                <input id="nombreP" type="text" onkeyup="buscar();" class="validate">
                                <label for="nombreP">Nombre del producto</label>
                            </div>
                        </div>
                        <div class="col s12 m6 l4">
                            <button class="btn waves-effect waves-light right" type="submit">Imprimir
                                <i class="material-icons right">print</i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php echo Pagina::footer(); ?>
<script type="text/javascript">
$("form#rep1").on("submit", function(event) {
    event.preventDefault();
    var Res = $(this).serialize();
    Res = 'registro_clientes.php?' + Res;
    window.location = Res;
}); $("form#rep2").on("submit", function(event) {
    event.preventDefault();
    var Res = $(this).serialize();
    Res = 'productos_escasos.php?' + Res;
    window.location = Res;
});
function buscar(){
    var nn = $('#nombreP').val().trim();
    try {
        $('#preloaderX').html('<div class="preloader-wrapper small active">' +
                        '<div class="spinner-layer spinner-green-only">' +
                            '<div class="circle-clipper left">' +
                                '<div class="circle"></div>' +
                            '</div>' +
                            '<div class="gap-patch">' +
                                '<div class="circle"></div>' +
                            '</div>' +
                            '<div class="circle-clipper right">' +
                                '<div class="circle"></div>' +
                            '</div>' +
                        '</div>' +
                    '</div>');
        $.ajax({
            type:'POST',
            url:'_productos.php',
            data: {n : nn},
            success:function(data){
                $('#prod').html(data);
                $('#preloaderX').html('');
                $('select').material_select();
            }
        });
    } catch (e) { Materialize.toast('Error', 8000, '', function(){ ULM = ''; }); }
}
buscar();
</script>