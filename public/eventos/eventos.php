<?php
require("../page1.php");
Page::header("Eventos");
?>
<div class="container-fluid">
  <div class="row">
      <div class='row'>
<?php
 $data = Database::getRows("SELECT * FROM eventos WHERE estado = 1;", array());
    if($data != null)
    {
      $eventos = "";
      //Este es el formato que tendran todos los productos en el index
      foreach ($data as $row)
      {
        $id = $row['id_evento'];
        $eventos .= "
        <div class='col s12 m6'>
          <div class='card red darken-3'>
            <div class='card-content white-text'>
              <span class='card-title'>$row[nombre_evento]</span>
              <p><b>Lugar:</b> <br>$row[lugar]<br></p>
              <p><b>Fechas:</b><br></p>
         <p><b>Inicio:</b> $row[fecha_inicio]<br></p>
         <p><b>Fin:</b> $row[fecha_fin]</p>
            </div>

          </div>
        </div>
      ";
      }
    print($eventos);

  }
  else
  {
    print("<div class='card-panel yellow'><i class='material-icons left'>warning</i>No hay eventos cercanos en este momento.</div>");
  }
      ?>
      </div>


</div>
      </div>
      </div>

<?php
Page::footer();
?>