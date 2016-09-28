<?php
require "../lib/pagina.php";

function existeUsuario() {
	$sql = "SELECT COUNT(*) AS total FROM empleados;";
	$res = pagina::obtenerFila($sql);
	foreach ($res as $var => $valor){
		if ($valor == 0 || $valor == '0')
			return false;
		else
			return true;
		print_r($res);
	}
}

// if (existeUsuario())
// 	header('Location: '.pagina::raiz());

$errores = $nombreR = $apellidoR = $correo = $usuario = $contra = $contra2 = ''; $Sucursal = null;

function crearPrimerEmpleado($valores)
{
	$sql = 'INSERT INTO empleados(nombre_empleado, apellido_empleado, correo_empleado, usuario_empleado, contra_empleado, id_sucursal) VALUES (?,?,?,?,?,?);';
	$res = pagina::ejecutar($sql, $valores);
	if ($res)
		header('Location: '.pagina::raiz());
}

if (!empty($_POST)){
	$_POST = pagina::validarForm($_POST);
	$nombreR = isset($_POST['nombreR']) ? $_POST['nombreR'] : '';
	$apellidoR = isset($_POST['apellidoR']) ? $_POST['apellidoR'] : '';
	$correo = isset($_POST['correo']) ? $_POST['correo'] : '';
	$usuario = isset($_POST['usuario']) ? $_POST['usuario'] : '';
	$contra = isset($_POST['contra']) ? $_POST['contra'] : '';
	$contra2 = isset($_POST['contra2']) ? $_POST['contra2'] : '';
	$Sucursal = isset($_POST['Sucursal']) ? $_POST['Sucursal'] : '0';
	if (!preg_match("/^[a-zA-Z \x7f-\xff]{1,100}$/", $nombreR))
		$errores .= '<br>'.'El nombre contiene carateres no válido o la longitud no es la correcta (1-100).';
	if (!preg_match("/^[a-zA-Z \x7f-\xff]{1,200}$/", $apellidoR))
		$errores .= '<br>'.'El apellido contiene carateres no válido o la longitud no es la correcta (1-200).';
	if (!filter_var($correo, FILTER_VALIDATE_EMAIL))
		$errores .= '<br>'.'El correo no es válido.';
	if (!preg_match("/^[a-zA-Z][a-zA-Z_0-9]{4,24}$/", $usuario))
		$errores .= '<br>'.'El nombre de usuario contiene carateres no válido o la longitud no es la correcta (5-25).';
	if (!($contra == $contra2))
		$errores .= '<br>'.'La contraseña y la comprobación de contraseña no son iguales.';
	else if (!(strlen($contra) >= 5 && strlen($contra) <= 25))
		$errores .= '<br>'.'La contraseña no posee la longitud correcta (5-25).';
	if ($Sucursal == '0' || empty(pagina::obtenerFila('SELECT * FROM sucursales WHERE id_sucursal = ?', array($Sucursal))))
		$errores .= '<br>'.'Error en la seleccion de la sucursal.';
	if (!(strlen($errores) > 0))
		crearPrimerEmpleado(array($nombreR, $apellidoR, strtolower($correo), strtolower($usuario), md5(password_hash($contra, PASSWORD_DEFAULT)), $Sucursal));
}

pagina::header('Inicio');
 ?>
	<div class="container row">
		<div class="col s12 m8 l6">
			<div class="card-panel">
				<h4 class="header2">No existe un usuario, cree uno.</h4>
				<div class="row">
					<form method="post" class="col s12" autocomplete="off" onpaste="return false" oncut="return false" oncopy="return false">
						<div class="row">
							<div class="input-field col s12">
								<i class="material-icons prefix">account_circle</i>
								<input id="n" name="nombreR" type="text" class="validate" length="100" required <?php echo "value='$nombreR'"; ?>>
								<label for="n">Nombres</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s12">
								<i class="material-icons prefix">account_circle</i>
								<input id="a" name="apellidoR" type="text" class="validate" length="200" required  <?php echo "value='$apellidoR'"; ?>>
								<label for="a">Apellidos</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s12">
								<i class="material-icons prefix">email</i>
								<input id="e" name="correo" type="email" class="validate" required  <?php echo "value='$correo'"; ?>>
								<label for="e">Correo electrónico</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s12">
								<i class="material-icons prefix">account_circle</i>
								<input id="u" name="usuario" type="text" class="validate" length="25" required  <?php echo "value='$usuario'"; ?>>
								<label for="u">Nombre de usuario</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s12">
								<i class="material-icons prefix">lock_outline</i>
								<input id="p1" name="contra" type="password" class="validate" length="25" required>
								<label for="p1">Contraseña</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s12">
								<i class="material-icons prefix">lock_outline</i>
								<input id="p2" name="contra2" type="password" class="validate" length="25" required>
								<label for="p2">Confirme contraseña</label>
							</div>
						</div>
						<div class="row">
							<div class="input-field col s12">
								<?php pagina::armarCombo('Sucursal', $Sucursal, 'SELECT * from sucursales;'); ?>
							</div>
						</div>
						<div class="row">
							<a href="../sucs/crear.php" class="btn blue waves-effect waves-light left">Agregar sucursal</a>
							<button class="btn green waves-effect waves-light right" type="submit" name="action">Crear
								<i class="mdi-content-send right"></i>
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="col s12 m4 l6">
			<div class="row">
				<div class="col s12">
					 <div class="card-panel grey lighten-2">
					 	NOTAS:
					 	El nombre de usuario debe de empezar por una letra, puede contener numeros y guión bajo, debe de ser de entre 5 y 25 caracteres.
					 	Y la contraseña debe de ser de entre 5 y 25 caracteres.
					 </div>
				</div>
				<?php echo strlen($errores) > 0 ? "
				<div class='col s12'>
					 <div class='card-panel red lighten-2'>
					 	<h4 class='white-text'>Erores</h4>
					 	<p class='white-text'>
					 		$errores
					 	</p>
					 </div>
				</div>" : '';
				 ?>
			</div>
		</div>
	</div>

<?php
pagina::footer('');
?>
