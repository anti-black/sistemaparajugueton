<?php
require("../page1.php");

function imagen($id){
  $data = Database::getRow("SELECT imagen FROM imagenes_productos WHERE id_producto = ?", array($id));
  if (empty($data))
    return 'http://placehold.it/350x150';
  else
    return 'data:img/*;base64,'.$data[0];
}

Page::header("Catalogo");
?>


<?php Page::footer(); ?>