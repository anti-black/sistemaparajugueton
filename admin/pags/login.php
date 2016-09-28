<?php $N_FORM = 0;
require "../lib/pagina.php";
function existeUsuario()
{
	$sql = "SELECT COUNT(*) AS total FROM empleados;";
	$res = pagina::obtenerFila($sql);
	foreach ($res as $var => $valor)
		if ($valor == 0 || $valor == '0')
			return false;
		else
			return true;
}

if (!existeUsuario())
	header("Location: crear_primer_usuario.php");

$errores = $usuario = $contra = '';

if (!empty($_POST)) {
	$_POST = pagina::validarForm($_POST);
	$usuario = isset($_POST['usuario']) ? $_POST['usuario'] : '';
	$contra = isset($_POST['contra']) ? $_POST['contra'] : '';
	$contra = md5(password_hash($contra, PASSWORD_DEFAULT));
	if (empty($usuario) || empty($contra))
		$errores .= 'No ha rellenado campos.';
	else{
		$sql = "SELECT id_empleado FROM empleados WHERE usuario_empleado = ? AND contra_empleado = ?;";
		$valores = array(strtolower($usuario), $contra);
		$fila = pagina::obtenerFila($sql, $valores);
		if ($fila[0] > 0)
			$errores .= 'Compruebe, usuario o contraseña incorrecta.';
		else
			pagina::iniciarSesion($usuario);
	}

}
pagina::header('Mantenimiento', false); ?>

<div class="container">
	<div class="row">
		<center>
			<h2>Bienvenido Administrador</h2>
		</center>
		<br>
		<center>
			<img src="http://jugueton.com.sv/wp-content/themes/jugueton_theme/images/logo.png">
		</center>
		<form class='row' method='post' id="login" novalidate="novalidate" autocomplete="off" onpaste="return false" oncut="return false" oncopy="return false">
			<div class='row'>
				<!--Ingresamos el correo del cliente-->
				<div class='input-field col m6 offset-m3 s12'>
					<i class='material-icons prefix'>person</i>
					<input id="u" name="usuario" type="text" class="validate" length="25" required <?php echo "value='$usuario'"; ?>>
					<label for='u' class="active">Usuario</label>
				</div>
				<!--Se ingresa la contraseña del cliente-->
				<div class='input-field col m6 offset-m3 s12'>
					<i class='material-icons prefix'>lock_outline</i>
					<input id="clave" name="contra" type="password" class="validate" length="25" required>
					<label for='clave' class="active">Contraseña</label>
				</div>
			</div>
			<center>
				<button type='submit' class='btn light-green darken-1'><i class='material-icons right'>done</i>Aceptar</button>
			</center>
		</form>
	</div>

		<?php echo (strlen($errores) > 0 ) ? "
			<div class='row'>
				<div class='card-panel red col s12 m8 l6 offset-m2 offset-l3'>
					<h4 class='white-text'>Errores</h4>
					<p class='white-text'>$errores</p>
				</div>
			</div>" : '' ;
		 ?>
	</div>
<?php pagina::footer(); ?>