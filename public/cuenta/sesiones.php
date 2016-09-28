<?php
require("../page1.php");
if (isset($_GET['br'])) {
	$sql = 'DELETE FROM sesiones WHERE id_sesion = ? AND id_cliente = ?;';
	$valores = array($_GET['br'], $_SESSION['id_cliente']);
	Database::executeRow($sql, $valores);
	header('Location: sesiones.php');
}
page::header("Sesiones");
?>
    <br/>
    <div class="row">
<?php
$filas = Database::getRows("SELECT * FROM sesiones WHERE id_cliente = ? ORDER BY ultimo DESC;", array($_SESSION['id_cliente']));
foreach ($filas as $fila) {
	$actual = $fila['codigo'] == $_SESSION['clave'] ? 'Sesión Actual' : 'Sesión' ;
	$navegador = $fila['navegador'];
	$sistema = $fila['sistema'];
	$ultimo = date('j/n/Y H:i:s', strtotime($fila['ultimo']));
	$cerrar = "<a href='?br=".$fila['id_sesion']."'>Cerrar sesión</a>";
	$sesion = "
		<div class='col s12 m6 l4'>
			<div class='card blue-grey darken-3'>
				<div class='card-content white-text'>
					<span class='card-title'>$actual</span>
					<p>Sistema: $sistema</p>
					<p>Navegador: $navegador</p>
					<p>Último acceso: $ultimo</p>
				</div>
				<div class='card-action'>
					$cerrar
				</div>
			</div>
		</div>";
	echo $sesion;
} ?>
    </div>
<?php
page::footer();
?>