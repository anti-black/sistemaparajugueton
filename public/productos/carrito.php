<?php
require("../page1.php");

function nivelador($id, $acomprar){
    $data = Database::getRow('SELECT existencias_producto FROM productos WHERE id_producto = (SELECT p.id_producto FROM carrito c INNER JOIN productos p ON c.id_producto = p.id_producto WHERE md5(c.id_carrito) = ?);', array($id));
    $cantidad = $data['existencias_producto'];
    $final = ($cantidad == '0') ? 0 : ($cantidad < $acomprar ? $cantidad : $acomprar);
    return $final;
}

$ptotal = 0; $imprimir = false;
if (isset($_POST['del']))
    Database::executeRow('DELETE FROM carrito WHERE md5(id_carrito) = ? AND id_cliente = ?;', array($_POST['del'], $_SESSION['id_cliente']));
elseif (isset($_POST['sv'])) {
    foreach ($_POST as $id => $val) {
        if ($id == 'sv') continue;
        $preprecio = Database::getRow( 'SELECT p.precio_normal_producto FROM carrito c INNER JOIN productos p ON c.id_producto = p.id_producto WHERE md5(c.id_carrito) = ?;', array($id));
        $val = $val > 10 ? 10 : $val < 1 ? 1 : $val;
        $val = round($val, 0);
        $precio = $preprecio[0] * $val;
        Database::executeRow('UPDATE carrito SET cantidad = ?, precio_total = ? WHERE md5(id_carrito) = ?;', array($val, $precio, $id));
    }
}
elseif (isset($_POST['comprar'])) {
    foreach ($_POST as $id => $val) {
        if ($id == 'comprar') continue;
        $val = nivelador($id, $val);
        $preprecio = Database::getRow('SELECT p.precio_normal_producto FROM carrito c INNER JOIN productos p ON c.id_producto = p.id_producto WHERE md5(c.id_carrito) = ?;', array($id));
        if ($val == 0) {
            Database::executeRow('DELETE FROM carrito WHERE md5(id_carrito) = ? AND id_cliente = ?;', array($_POST['del'], $_SESSION['id_cliente']));
            continue;
        }
        $val = $val > 10 ? 10 : $val < 1 ? 1 : $val;
        $val = round($val, 0);
        $precio = $preprecio[0] * $val;
        Database::executeRow('UPDATE carrito SET cantidad = ?, precio_total = ? WHERE md5(id_carrito) = ?;', array($val, $precio, $id));
    }
    //SELECT id_carrito, id_producto, id_cliente, cantidad, precio_total FROM carrito
    //SELECT id_detalle_ventas, id_venta, id_producto, cantidad_producto, cantidad_pagada FROM detalles_ventas
    $total = Database::getRows('SELECT * FROM carrito WHERE id_cliente = ?;', array($_SESSION['id_cliente']));
    if (!empty($total)){
        $venta = 'CTXL'.strtoupper(substr(md5(uniqid()), 0, 8));
        Database::executeRow('INSERT INTO ventas(id_cliente, codigo_venta, fecha_venta) VALUES (?, ?, CURRENT_TIMESTAMP);', array($_SESSION['id_cliente'], $venta));
        $ventaF = Database::getRow('SELECT * FROM ventas WHERE id_venta = (SELECT MAX(id_venta) FROM ventas WHERE id_cliente = ?);', array($_SESSION['id_cliente']));
        $IDventa = $ventaF['id_venta'];
        foreach ($total as $registo){
            Database::executeRow(
                'INSERT INTO detalles_ventas(id_venta, id_producto, cantidad_producto, cantidad_pagada) VALUES (?, ?, ?, ?); DELETE FROM carrito WHERE id_carrito = ?;',
                array($IDventa, $registo['id_producto'], $registo['cantidad'], $registo['precio_total'], $registo['id_carrito']));
            $ptotal += $registo['precio_total'];
        }
        Database::executeRow('UPDATE ventas SET cantidad_a_pagar_total = ?, cantidad_a_pagar_total_final = ? WHERE = ?;', array($ptotal, $IDventa));
        header('Location: venta.php');
    }
}
page::header("Carrito");
?>
<br/>
<br/>
<div class="container">
    <div class="row">
        <table class="responsive-table">
            <thead>
                <tr>
                    <th>Número</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Precio Total</th>
                    <th>Estado</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <form method='post' autocomplete="off" onpaste="return false" oncut="return false" oncopy="return false">
<?php
$filas = Database::getRows("SELECT * FROM carrito WHERE  id_cliente = ?;", array($_SESSION['id_cliente']));
$ptotal = $item = 0;
if (empty($filas))
  echo "
            <tr>No hay productos en tu carrito.</tr>";
else{
  foreach ($filas as $fila) {
    $item++;
    $ptotal += $fila[3];
    $estado = ($fila['existencias_producto'] == '0') ? 'Inexistente' : ($fila['existencias_producto'] < $fila['cantidad'] ? "Exedido(hay sólo $fila[existencias_producto])" : 'En existencia') ;
    $precio = round($fila[3] / $fila[2], 2);
    $botones = "<button class='btn waves-effect waves-light' type='submit' name='del' value='$fila[0]'><i class='material-icons'>delete</i></button>";
    $fila = "
                        <tr>
                            <td>$item</td>
                            <td>$fila[1]</td>
                            <td><div class='input-field col s12'><input type='number' class='validate' min='1' max='10' name='$fila[0]' value='$fila[2]'></div></td>
                            <td>$$precio</td>
                            <td>$$fila[3]</td>
                            <td>$estado</td>
                            <td>$botones</td>
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
                            <td>$ptotal</td>
                            <td><button class='btn waves-effect waves-light' type='submit' name='comprar' value='0'>Comprar</button></td>
                            <td><button class='btn waves-effect waves-light' type='submit' name='sv' value='0'>Guardar</button></td>
                        </tr>";
}
?>
                    </form>
                </tr>
            </tbody>
        </table>
    </div>
<?php
$btn = '
    <div class="row">
        <div class="col s12 m6 l4">
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
    </div>
';
echo $imprimir ? $btn : '';
?>
</div>

<?php
page::footer();
?>