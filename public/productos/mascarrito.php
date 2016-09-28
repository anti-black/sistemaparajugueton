<?php require("../page1.php");
function precioP($ide) {
    $sql = "SELECT precio_normal_producto FROM productos WHERE id_producto = ?;";
    $valores = array($ide);
    $fila = Database::getRow($sql, $valores);
    return $fila[0];
}
$id_prod = $_POST['id'];
$id = $_SESSION['id_cliente'];
if (empty($id)) exit();
$precio = precioP($id_prod);
$sql = "INSERT INTO carrito(id_producto, id_cliente, cantidad, precio_total) VALUES(?,?,1,?);";
$valores = array($id_prod, $id, $precio);
$data = Database::getRow("SELECT * FROM carrito WHERE id_producto = ? AND id_cliente = ?;", array($id_prod, $id));
if (!empty($data)) echo '-1';
elseif (Database::executeRow($sql, $valores)) echo '1';
else echo '0';
?>