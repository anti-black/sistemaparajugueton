<?php
require("../page1.php");
page::header("Venta");

$imprimir = true;

$_POST = Validator::validateForm($_POST);
$DUI = $_POST['dui'];

if (!empty($DUI)) {

}

?>
<br/><br/>
    <div class="row">
        <table class="responsive-table">
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Producto</th>
                    <th>Detalles</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Precio Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <form method='post' autocomplete="off" onpaste="return false" oncut="return false" oncopy="return false">
<?php
$filas = Database::getRows(
    "SELECT nombre_producto, descripcion_producto, cantidad_producto, precio_normal_producto, cantidad_pagada
    FROM productos INNER JOIN (detalles_ventas INNER JOIN ventas ON detalles_ventas.id_venta = ventas.id_venta)
    ON productos.id_producto = detalles_ventas.id_producto WHERE ventas.id_venta = (SELECT MAX(id_venta) FROM ventas WHERE id_cliente = ?);",
    array($_SESSION['id_cliente']));
$ptotal = $item = 0;
if (empty($filas))
  echo "
            <tr>No hay productos en tu carrito.</tr>";
else{
  foreach ($filas as $fila) {
    $ventaF = Database::getRow('SELECT * FROM ventas WHERE id_venta = (SELECT MAX(id_venta) FROM ventas WHERE id_cliente = ?);', array($_SESSION['id_cliente']));
    $item++;
    $ptotal += $fila['cantidad_pagada'];
    $estado = ($fila['existencias_producto'] == '0') ? 'Inexistente' : ($fila['existencias_producto'] < $fila['cantidad'] ? "Exedido(hay sólo $fila[existencias_producto])" : 'En existencia') ;
    $precio = round($fila[3] / $fila[2], 2);
    $fila = "
                        <tr>
                            <td>$item</td>
                            <td>$fila[nombre_producto]</td>
                            <td>$fila[descripcion_producto]</td>
                            <td>$fila[cantidad_producto]</td>
                            <td>$$fila[precio_normal_producto]</td>
                            <td>$$fila[cantidad_pagada]</td>
                        </tr>";
    echo $fila;
    }
    $ptotal = '$'.round($ptotal, 2);
    echo "
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>$ptotal</td>
                        </tr>";
}
?>
                    </form>
                </tr>
            </tbody>
        </table>
    <div class="row">
        <div class="col s12 m6 l4">
            <form>
				<div class="input-field col s11">
					<input placeholder="Documento Universal de la Imaginación" id="dui" name="dui" type="text" class="validate" length="20" required>
					<label for="dui">DUI</label>
				</div>
			    <button type='submit' class='btn blue right'><i class='material-icons left'>save</i>Guardar</button>
            </form>
        </div>
<?php
$btn = '
        <div class="col s12 m6 l4">
            <h4>Procede a pagar tu compra</h4>
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                <input type="hidden" name="cmd" value="_s-xclick">
                <input type="hidden" name="hosted_button_id" value="QDC4LQGW8A5Q4">
                <input type="hidden" name="currency_code" value="USD">
                <input type="hidden" name="item_name" value="'.'">
                <input type="hidden" name="amount" value="'.$ptotal.'">
                <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
            </form>
        </div>
';
echo $imprimir ? $btn : '';
?>
        <div class="col s12 m6 l4">

        </div>
    </div>
</div>

<?php
page::footer();
?>