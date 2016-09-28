
<?php
require("../page1.php");

function imagen($id){
  //$data = Database::getRow("SELECT imagen FROM imagenes_productos WHERE id_producto = ?", array($id));
  $data = Database::getRow("SELECT imagen FROM productos WHERE id_producto = ?;", array($id));
  if (empty($data))
    return 'http://placehold.it/350x150';
  else
    return 'data:img/*;base64,'.$data[0];
}

Page::header("");
?>
<div class=''>
    <div class ="row">
<div style ="float:left;
color:#00b0ff;">

</style><h3>Catálogo</h3></div>
<br><br><br>
<form method='post' class='row' autocomplete="off" onpaste="return false" oncut="return false" oncopy="return false">
	<div class='input-field col s6 m4'>
		<i class='material-icons prefix'>search</i>
		<input id='buscar' type='text' name='buscar' class='validate'/>
		<label for='buscar'>Búsqueda</label>
	</div>
	<div class='input-field col s6 m4'>
		<button type='submit' class='btn grey left'><i class='material-icons right'>pageview</i></button>
	</div>

</form>
    <div class='col s12 m12'>
        <div class="collection collecFlot">
            <a href='#!' class='collection-item active'>Clasificaciones</a>

                <?php
      	$sql = "SELECT * FROM clasificaciones WHERE estado = 1";
      	$params = array(null);
      	$data = Database::getRows($sql, $params);
        if($data != null)
        {
          $slider = "";
          foreach($data as $row)
		      {
              $slider .= "<a href='#!' class='collection-item'>$row[clasificacion]</a>";
		      }
		      print($slider);
        }
      ?>
            </div>
        </div>
    <div class="col s12 m12 l12">
<?php
//busqueda y listado de productos

if(!empty($_POST))
{
    $search = trim($_POST['buscar']);
    $sql = "SELECT * FROM productos WHERE estado = '1' AND existencias_producto > 0 AND nombre_producto LIKE ? ORDER BY nombre_producto";
    $params = array("%$search%");
}
else
{
    $sql = "SELECT * FROM productos WHERE estado = '1' AND existencias_producto > 0 ORDER BY nombre_producto";
    $params = null;
}
$data = Database::getRows($sql, $params);

if(!empty($data))
{
    $products = "";
    //Este es el formato que tendran todos los productos en el index
    foreach ($data as $row)
    {
        $precio =   $row['estado_oferta'] ?
                    "<p><del>Precio Normal$$row[precio_normal_producto]</del></p><p>Precio de oferta $$row[precio_oferta_producto]</p>" :
                    "<p>Precio Normal$$row[precio_normal_producto]</p>";
        $id = $row['id_producto'];
        $imagen = imagen($id);
        $products .= "
        <div class='col m6 l4 s12'>
            <div class='card'>
                <div class='card-image waves-effect waves-block waves-light'>
                    <img class='activator' src='".$imagen."'/>
                </div>
                <div class='card-content'>
                    <span class='activator black-text text-darken-4'>$row[nombre_producto]<i class='material-icons right'>more_vert</i></span>
                </div>
                <div class='card-reveal'>
                    <span class='card-title black-text text-darken-4'>$row[nombre_producto]<i class='material-icons right'>close</i></span>
                    <p>$row[descripcion_producto]</p>
                    $precio
                    <p><a href='detallepro.php?prod=$id' target='_blank' class='btn green darken-2'><i class='material-icons right'>add</i>ver más</a></p>
                    ".(Page::iniciado() ? "<p><a onclick=\"agregar('$id');\"  class='btn green darken-2'><i class='material-icons right'>add_shopping_cart</i>Agregar al carrito</a></p>" : '')."
                </div>
            </div>
        </div>";
    }
    print($products);
}
else print("<div class='card-panel yellow'><i class='material-icons left'>warning</i>No hay productos disponibles en este momento.</div>");

?>
        </div>


    </div>
</div>

<script type="text/javascript">
function agregar(id) {
    $.ajax({
        type:'POST',
        url:'mascarrito.php', //archivo del calculo
        data: { id : id },
        success:function(data){
            switch (data) {
                case '-1':
                    Materialize.toast('El artículo ya está agregado.', 4000);
                    break;
                case '1':
                    Materialize.toast('agregado correctamente.', 4000);
                    break;
                default:
                    Materialize.toast('Error desconocido.', 8000);
                    break;
            }
            cargar($('#buscar').val());
        }
    });
}
</script>
<?php Page::footer(); ?>

















