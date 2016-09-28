<?php
require("../page1.php");
Page::header("");
?>

<div class="container-fluid">
  <div class="row">

<?php
$data = Database::getRows("SELECT * FROM noticias WHERE estado = 1");
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
          <a href='detallenot.php?id=$id'>Ver más</a>
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
<?php
Page::footer();
?>