<?php require "../lib/pagina.php";
$_POST = pagina::validarForm($_POST);
$filas = array(); $fila = array(0, 0, 0, 0);
$encontrado = false;
$ahora = 0;
foreach ($_POST as $indice => $valor) {
    if ($valor == 'on') {
        $ahora = $indice;
        $encontrado = true;
    } elseif($encontrado) {
        $PN = $_POST['pn'.$ahora]; $PO = $_POST['po'.$ahora]; $PA = $_POST['pa'.$ahora];
        array_push($filas, array($ahora, $PN, $PO, $PA));
        $encontrado = false;
    }
}
foreach ($filas as $reg) {
    $ID = $reg[0]; $PN = $reg[1]; $PO = $reg[2]; $PA = $reg[3];
    if (!empty($PN)) pagina::ejecutar("UPDATE productos SET precio_normal_producto = ? WHERE codigo = ?;", array($PN, $ID));
    if (!empty($PO)) pagina::ejecutar("UPDATE productos SET precio_oferta_producto = ? WHERE codigo = ?;", array($PO, $ID));
    if (!empty($PA)) pagina::ejecutar("UPDATE productos SET precio_afiliado_producto=? WHERE codigo = ?;", array($PA, $ID));
}
header('Location: precios.php?ex=1');
?>