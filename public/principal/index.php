<?php
require("../page1.php");
 page::header("");

    if(isset($_SESSION['nombre_cliente']))
    { //toma el valor del nombre del cliente que inicio sesion
      if(isset($_SESSION['estado_sesion']) && $_SESSION['estado_sesion'])
      {
        print("<h5>Hola $_SESSION[nombre_cliente], ya tiene una sesion iniciada</h5>");
      }
    }
?>

<h3><center>-----Descubre las novedades-----</center></h3>
<div class="container">
    <div class="row">

      <div class='col s12 m12'>
            <div class="collection collecFlot">
                <a href='#!' class='collection-item active'>Categorias</a>

                <?php
      	$sql = "SELECT * FROM categorias WHERE estado = 1";
      	$params = array(null);
      	$data = Database::getRows($sql, $params);
        if($data != null)
        {
          $slider = "";
          foreach($data as $row)
		      {
              $slider .= "<a href='#!' class='collection-item'>$row[categoria]</a>";
		      }
		      print($slider);
        }
      ?>
            </div>
        </div>

  <div  class="slider">
    <ul class="slides">
      <?php
      	$sql = "SELECT * FROM slider ORDER BY id_slider DESC LIMIT 3";
      	$params = array(null);
      	$data = Database::getRows($sql, $params);
        if($data != null)
        {
          $slider = "";
          foreach($data as $row)
		      {
              $slider .= "<li><img src='data:image/*;base64,$row[imagen]'></li>";
		      }
		      print($slider);
        }
      ?>
    </ul>
  </div>

  <h5>Marcas</h5>
  <div class="owl-carousel">
    <?php
      	$sql = "SELECT * FROM marcas WHERE estado = 1";
      	$params = array(null);
      	$data = Database::getRows($sql, $params);
        if($data != null)
        {
          $slider = "";
          foreach($data as $row)
		      {
              $slider .= "<div><img src='data:image/*;base64,$row[img_marca]'></div>";
		      }
		      print($slider);
        }

      ?>

</div>



    </div>
    <div class="container-fluid">
  <div class="row">
    <h4>Últimas noticias</h4>
    <?php
$data = Database::getRows("SELECT * FROM noticias ORDER BY id_noticia DESC LIMIT 3");
if($data != null)
{
  $noticias = "";
  //Este es el formato que tendran todos los productos en el index
  foreach ($data as $row)
  {//
    $id = $row['id_noticia'];
    $imagen = 'data:img/*;base64,'.$row['imagen_pri'];
    $noticias .="

  <div class='col s12 m4'>
    <div class='card horizontal'>
      <div class='card-image'>
          <img src='$imagen'/>
      </div>
      <div class='card-stacked'>
        <div class='card-content'>
          <p>$row[titulo]</p>
        </div>
        <div class='card-action'>
          <a href='noticias/detallenot.php?id=$id'>Ver más</a>
        </div>
      </div>
    </div>
  </div>";
    }
    print($noticias);
  }
  else
  {
    print("<div class='card-panel yellow'><i class='material-icons left'>warning</i>No hay noticias en este momento.</div>");
  }
      ?>
</div>
</div>
    </div>
<?php
page::footer();
?>