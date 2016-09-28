<?php
require("../lib/page1.php");
require("../lib/validator.php");
require("../lib/database.php");

function imagen($id){
  $data = Database::getRow("SELECT  imagen FROM imagenes_productos WHERE id_producto = ?", array($id));
  if (empty($data))
    return 'http://placehold.it/350x150';
  else
    return 'data:img/*;base64,'.$data[0];
}

Page::header("Catalogo");
?>
<div class='container col m6 offset-m3 s12'>
  <div class ="row">
  <br/>
  <br/>
  <?php
  $data = Database::getRows("SELECT *
FROM productos, categorias
WHERE productos.id_categoria = categorias.id_categoria
AND categoria =  'niños'", array());
    if($data != null)
    {
      $niños = "";
      //Este es el formato que tendran todos los productos en el index
      foreach ($data as $row)
      {
        $id = $row['id_producto'];
        $imagen = imagen($id);
        $niños .= "
       <div class='card col m6 l4 s12'>
        <div class='card-image waves-effect waves-block waves-light'>
          <img class='activator' src='".$imagen."'/>
        </div>
        <div class='card-content'>
          <span class='card-title activator grey-text text-darken-4'>$row[nombre_producto]<i class='material-icons right'>more_vert</i></span>
        </div>
        <br>
        <div class='card-reveal'>
          <span class='card-title grey-text text-darken-4'>$row[descripcion_producto]<i class='material-icons right'>close</i></span>
          <p>$$row[precio_normal_producto]</p>
          <p><a href='detalleproductosesion.php?prod=$id'  class='btn green darken-2'><i class='material-icons right'>add</i>ver más</a></p>
        </div>
      </div>
      ";

    }
    print($niños);
  }
  else
  {
    print("<div class='card-panel yellow'><i class='material-icons left'>warning</i>No hay productos disponibles en este momento.</div>");
  }

      ?>
      </div>
      </div>
<?php
Page::footer();
?>