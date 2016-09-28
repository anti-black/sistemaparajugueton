<?php require("../lib/pagina.php");
if (isset($_POST['e'])) {
    $_POST = pagina::validarForm($_POST);
    $var = pagina::URLD64($_POST['e']);
    if (pagina::ejecutar('DELETE FROM categorias WHERE md5(id_categoria) = ?  AND (SELECT COUNT(*) FROM productos WHERE productos.id_categoria = categorias.id_categoria) = 0;', array($var)))
        echo '1';
    else echo '0';
} elseif (isset($_POST['o']) && isset($_POST['x'])) {
    $_POST = pagina::validarForm($_POST);
    $var = pagina::URLD64($_POST['o']);
    if (pagina::ejecutar('UPDATE categorias SET estado = ? WHERE md5(id_categoria) = ?;', array($_POST['x'] == 0 ? 0 : 1, $var)))
        echo '1';
    else echo '0';
} elseif (isset($_POST['n']) && isset($_POST['o'])) {
    $_POST = pagina::validarForm($_POST);
    $var = $_POST['n'];
    $var2 = pagina::URLD64($_POST['o']);
    $fila = pagina::obtenerFilas("SELECT * FROM categorias WHERE categoria LIKE ? AND md5(id_categoria) <> ?;", array($var, $var2));
    if (!empty($fila))
        echo '0';
    else echo '1';
} else echo '0';
?>