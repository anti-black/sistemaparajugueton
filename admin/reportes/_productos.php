<?php require("../lib/pagina.php");
$nombre = $_POST['n'];
$data = pagina::obtenerFilas("SELECT md5(id_producto), nombre_producto FROM productos WHERE estado = 1 AND nombre_producto LIKE ?;", array("%$nombre%"));
$combo = "<option value='' disabled selected>Elije el producto</option>";
foreach($data as $row) {
	$id = pagina::URLA64($row[0]);
	$combo .= "
    <option value='$id' selected>$row[1]</option>";
}
echo $combo;
?>