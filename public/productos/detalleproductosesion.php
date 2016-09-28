<?php
//toma el valor de la fecha y hora actual
ini_set("date.timezone","America/El_Salvador");
//enlace del formato de la pagina
require("../page1.php");
//Encabezado de la pagina
function imagen($id){
  $data = Database::getRow("SELECT imagen FROM imagenes_productos WHERE id_producto = ?", array($id));
  if (empty($data))
    return 'http://placehold.it/350x150';
  else
    return 'data:img/*;base64,'.$data[0];
}

Page::header("Detalle Producto");
?>

<?php

if(empty($_GET['prod']))
{
  //si hay un id va a proceder, de lo contrario te enviara a la pagina de inicio
  $id = null;
  $comentario = null;

}
else
{
//En esta condicion seleccionamos todos los comentarios de la tabla
 $id = $_GET['prod'];

  $sql = "SELECT * FROM comentarios WHERE id_producto = ?";
  $params = array($id);
  $data = Database::getRow($sql, $params);
  $comentario = $data['comentario'];


}

if(!empty($_POST))
{
  $_POST = Validator::validateForm($_POST);
  $comentario = $_POST['comentario'];

  if($comentario == "")
  {
    $comentario = null;
  }

  try
  {
   if($comentario == "")
   {
    throw new Exception("Datos incompletos.");
  }

  else
  {
        	$sql = "INSERT INTO comentarios (comentario,  id_producto, id_cliente) VALUES(?,?,?)";//Y el id del producto? commo se a que producto le hice el cometario
            $params = array($comentario,$id,$_SESSION['id_cliente']);//porque selecciona? XD no tenes presionado algo?NOXD
            Database::executeRow($sql, $params);
          header("location: index.php");
          }

        }
        catch (Exception $error)
        {
          print("<div class='card-panel red'><i class='material-icons left'>error</i>".$error->getMessage()."</div>");
        }
      }




     //$id = $_GET['id'];
     $sql = "SELECT * FROM productos INNER JOIN categorias ON productos.id_categoria = categorias.id_categoria WHERE id_producto = ?";
     $params = array($_GET['prod']);

     $data = Database::getRow($sql, $params);
     if($data != null)
     {
       $id = $data['id_producto'];
      $imagen = imagen($data['id_producto']);
      $tabla = 	"
      <div id ='izquierda' class = ' col m6 offset-m3 s12'>
        <img src='$imagen'>
        <p><b>Nombre</b> $data[nombre_producto]</p>
        <p><b>Precio($)</b> $data[precio_normal_producto]</p>
        <p><b>Categoria</b> $data[categoria]</p>
        <p><a href='mascarrito.php?id=$id'  class='btn green darken-2'><i class='material-icons right'>add_shopping_cart</i>Agregar al carrito</a></p>
      </div>
      ";
      print($tabla);
    }
    else
    {
      print("<div class='card-panel yellow'><i class='material-icons left'>warning</i>No hay registros.</div>");
    }
    ?>
    <script type="text/javascript">
      function theFunction () {
       alert('Producto agregado exitosamente');
       return true;
     }
   </script>

   <div class='row'>
    <div>
      <div class='col s12'>
        <ul class='tabs'>
          <li class='tab col m3 s12'><a class='blue-text' href='#voted'>Comentarios</a></li>
          <li class='tab col m3 s12'><a class='blue-text' href='#posts'>Deja tu comentario</a></li>
          <div class='indicator blue' style='z-index:1'></div>
        </ul>
      </div>
      <div id='voted' class='col s12'>
        <?php
        $sql1 = "SELECT CONCAT(s.nombre_cliente, ' ',s.apellido_cliente) as nombre, c.comentario FROM comentarios c INNER JOIN productos p ON c.id_producto = p.id_producto INNER JOIN clientes s ON s.id_cliente = c.id_cliente WHERE p.id_producto = ? ORDER BY c.id_comentario DESC";
        $params1 = array($id);
        $data1 = Database::getRows($sql1, $params1);
        $tabla1 = "";
        if($data1 != null)
        {
          foreach($data1 as $row1)
          {
            $tabla1 .= "
            <div id = 'comentario'>
              <ul>
                <li>
                  <div style = 'margin-right:750px;'><br>
                    <i class='material-icons'>account_circle
                    </i><h6><b>$row1[nombre]</b></h6>
                  </div>
                  <div  id ='adentro'style = 'margin-right:450px;'>
                    <p>$row1[comentario]</p>
                    <p>$row1[fecha_comentado]</p>
                  </div>
                </li>
              </ul>
            </div>";

          }
        }
        else
        {
         $tabla1 .= "<ul class='collection'>
         <li class='collection-item avatar'>
           <div style = ' margin-right:10px;'>
            <img src='img/advertencia.png' alt='' >
          </div>
          <div>
            <b><h3>En este momento no hay comentarios disponibles</h3></b>
          </div>


        </li>
      </ul>";



    }
    print($tabla1);
    ?>
  </div>
  <div id='posts' class='col s12'>
    <p>
      <form method='post' class='row'>
        <div class='row'>
          <div class='input-field col s12 m6'>
          	<i class='material-icons prefix'>add</i>
          	<textarea id='comentario' type='text' name='comentario' class='validate' length='50' maxlenght='250' style = 'margin:0px 0px 0px 42px; width:920px; height:112px; resize:none;'/></textarea>

          </div>

        </div>
        <button type='submit' class='btn light-green darken-1'><i class='material-icons right'>send</i>Enviar</button>
      </form>


    </div>

  </div>
</div>

<?php
Page::footer();
?>