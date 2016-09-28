<?php
/**
* Clase para formar páginas públicas, son diferentes a formar páginas privadas
* por que tienen diferentes validaciones de usuarios
*/

class conexion {
	private static $conexion;
//FUNCIONES QUE SE UTILIZAN EN EL DESARROLLO DEL PROYECTO
	private static function connect() {
        $host = '127.0.0.1';
        $database = 'jugueton';
        $username = 'williamscg';
		$password = '';
		$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "set names utf8");
		self::$conexion = null;
		try {
			self::$conexion = new PDO("mysql:host=".$host."; dbname=".$database, $username, $password, $options);
			self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); }
		catch(PDOException $exception) {
			die($exception->getMessage()); } }

	private static function desconnect() {
		self::$conexion = null; }

	public static function ejecutar($consulta, $valores) {
		self::connect();
		$statement = self::$conexion->prepare($consulta);
		$resultado = $statement->execute($valores);
		self::desconnect();
		return $resultado; }

	public static function obtenerFila($consulta, $valores = null) {
		self::connect();
		$statement = self::$conexion->prepare($consulta);
		$statement->execute($valores);
		self::desconnect();
		return $statement->fetch(PDO::FETCH_BOTH); }

	public static function obtenerValor($consulta, $indice, $valores = null) {
		self::connect();
		$statement = self::$conexion->prepare($consulta);
		$statement->execute($valores);
		self::desconnect();
		$fila = $statement->fetch(PDO::FETCH_BOTH);
		return $fila[$indice];

	}

	public static function obtenerFilas($consulta, $valores = null) {
		self::connect();
		$statement = self::$conexion->prepare($consulta);
		$statement->execute($valores);
		self::desconnect();
		return $statement->fetchAll(PDO::FETCH_BOTH); }

}

/**
* Clase de seguridad, se encargará de comprobar permisos y validar acceso de cada sesión, y evitar multi sesiones
*/
class seguridad extends conexion
{
	public static function haySesionIniciada(){
		return true;
		if (isset($_COOKIE['IDSSN']) && isset($_COOKIE['USSSN'])) {
			$us = $_COOKIE['USSSN'];
			$ps = $_COOKIE['IDSSN'];
			$sql = "SELECT id_empleado FROM empleados WHERE (usuario_empleado = ? AND id_sesion = ?);";
			$valores = array($us, $ps);
			$filas = self::obtenerFilas($sql, $valores);
			return !empty($filas);
		}
		return false;
	}

	public static function cerrarSesion(){
		setcookie("IDSSN", '', 1, '/admin/');
		setcookie("USSSN", '', 1, '/admin/');
	}

	public static function iniciarSesion($usuario) {
		$ids = md5(uniqid().$usuario);
		setcookie("IDSSN", $ids, time() + (7 * 24 * 60 * 60), '/admin/');
		setcookie("USSSN", strtoupper($usuario), time() + (7 * 24 * 60 * 60), '/admin/');

		$sql = "UPDATE empleados SET id_sesion = ? WHERE usuario_empleado = ?;";
		$res = pagina::ejecutar($sql, array($ids, $usuario));
		if ($res)
			header('Location: '.pagina::raiz());
	}

	public static function obtenerControles(){
		return '';
	}
}

class pagina extends seguridad {
	public static function raiz() { //ruta de la carpeta raíz, por si se usan rutas estáticas
			return 'https://jugueton-williamscg.c9users.io/admin/';
		// return 'http://localhost/';
		}

	//'title' es para el título de la página. '$exige_cuenta' es un 'true' o 'false', es pasa validar y obligar al usuario a iniciar sesión.
	public static function header($title, $exige_cuenta = true){
		$hay = false; //indica si hay sesión iniciada
		$hay = self::haySesionIniciada(); //valida sesión

		if ($exige_cuenta && !$hay) //validación de obliga al usuario a iniciar sesión si la página lo requiere
			header("Location: ".(self::raiz())."pags/login.php");
			// print_r($_COOKIE);

		ini_set("date.timezone","America/El_Salvador"); //ajusta la ubicación de la zona horaria

		$archivoPadre = basename($_SERVER['PHP_SELF']);
		/*  Obtiene el nombre del archivo que mandó a llamar 'paguina.php'.
		 *  En caso que 'index.php' mada a llamar a 'otroarchivo.php' y ese llama a 'paguina.php' que tiene éste método
		 *  devolverá ----^ (el primer archivo en llamar a todo)
		 */

		$CONTROLES = self::obtenerControles();

		$raiz = self::raiz(); //variable que tien la ruta de inicio de la página
		//formato de las paginas
		$header = "
 <!DOCTYPE html>
 <html>
 <head>
 	<title>$title</title>
 	<meta charset='UTF-8'/>
 	<meta name='viewport' content='width=device-width, initial-scale=1'>
 	<meta http-equiv='X-UA-Compatible' content='IE=edge'>
 	<meta name='msapplication-tap-highlight' content='no'>
 	<link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>
 	<link href='../css/materialize.css' type='text/css' rel='stylesheet' media='screen,projection'>
 	<link href='../css/alteraciones.css' rel='stylesheet' type='text/css'>
 </head>
 <body id='ZERRATO'>".(($archivoPadre != 'login.php') ? "
    <header id='header' class='page-topbar'>
        <div class='navbar-fixed '>
            <nav class='teal lighten-1'>
                <div class='nav-wrapper'>
                    <ul class='left'>
                        <li>
                            <h1 class='logo-wrapper'>
                                <a href='./' class='brand-logo darken-1 center'>$title</a>
                            </h1>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
    <div id='main'>
        <div class='wrapper'>
            <aside id='left-sidebar-nav'>
                <ul id='slide-out' class='side-nav fixed leftside-navigation ps-container ps-active-y' style='width: 240px;'>
                    <li class='bold active'>
                        <a href='$raiz' class='waves-effect waves-cyan'>
                            <i class='mdi-action-dashboard'></i>
                            INICIO
                        </a>
                    </li>
                    <li class='no-padding'>
                        <ul class='collapsible collapsible-accordion'>
							<li><a href='../cats/'><i class='material-icons left'>list</i>Categorias</a></li>
							<li><a href='../claf/'><i class='material-icons left'>flag</i>Clasificaciones</a></li>
							<li><a href='../nots/'><i class='material-icons left'>content_paste</i>Noticias</a></li>
							<li><a href='../eventos/'><i class='material-icons left'>today</i>Eventos</a></li>
							<li><a href='../prod/'><i class='material-icons left'>extension</i>Productos</a></li>
							<li><a href='../clientes/'><i class='material-icons left'>face</i>Clientes</a></li>
							<li><a href='../comentarios/'><i class='material-icons left'>thumbs_up_down</i>Comentarios</a></li>
							<li><a href='../marcas/'><i class='material-icons left'>import_contacts</i>Marcas</a></li>
							<li><a href='../Slider/'><i class='material-icons left'>panorama</i>Slider</a></li>
							<li><a href='../sucs/'><i class='material-icons left'>place</i>Sucursales</a></li>
							<li><a href='../reportes/'><i class='material-icons left'>insert_drive_file</i>Reportes</a></li>
							<li><a href='../pags/cerrar.php'><i class='material-icons left'>person_outline</i>Cerrar sesión</a></li>
                            <!-- CONTROLES -->
                        	$CONTROLES
                        </ul>
                    </li>
                </ul>
                <a href='#' data-activates='slide-out' class='sidebar-collapse btn-floating btn-medium waves-effect waves-light hide-on-large-only cyan'>
                    <i class='material-icons'>menu</i>
                </a>
            </aside>
            <section id='content'>
                <div class='container'>" : '');
		return $header;
	}

	public static function footer($otros = ''){
		$archivoPadre = basename($_SERVER['PHP_SELF']);
		$footer = '';
		$footer .= "
                </div>
            </section>
        </div>
    </div>
 	<script src='../js/jquery-2.2.3.min.js'></script>
 	<script src='../js/materialize.js'></script>
 	<script src='../js/alteraciones.js'></script>";
 		$footer .= $archivoPadre != 'login.php' ? "
 	<script src='/admin/auto_cerrado.js'></script>" : '';
 		$footer .= "
 		$otros
 	<script>
 		$(document).ready(function() {
 			$('.button-collapse').sideNav();
 			$('.materialboxed').materialbox();
 			$('select').material_select();
 			$('input, textarea').characterCounter();
		});
 	</script>
 </body>
 </html>";
		return $footer;
	}

	public static function armarCombo($nombre, $seleccionado, $sql, $valores = null){
		$data = self::obtenerFilas($sql, $valores);
		$combo = "<select name='$nombre'>";
		if($seleccionado == null)
			$combo .= "<option value='' disabled selected>Seleccione una opción</option>";
		foreach($data as $row) {
			$combo .= "<option value='$row[0]'";
			if($seleccionado == $row[0])
				$combo .= " selected";
			$combo .= ">$row[1]</option>";
		}
		$combo .= "</select>
				<label style='text-transform: capitalize;'>$nombre</label>";
		print($combo);
	}

	public static function existeRegistro($sql, $valores) {
		$filas = self::obtenerFilas($sql, $valores);
		var_dump($filas);
		echo ''.empty($filas);
		return 1;
	}

	public static function validarForm($arreglo) {
		foreach ($arreglo as $indice => $valor) {
			$valor = trim($valor);
			$valor = htmlspecialchars($valor);
			$arreglo[$indice] = $valor; }
		return $arreglo;
	}
	//especificaciones de validacion de imagen
	public static function validarImagen($archivo, $t = 'S')
	{
		$img_size = $archivo["size"];
	 	if($img_size <= 2147483648)
	 	{
	 		$img_type = $archivo["type"];
		 	if($img_type == "image/jpeg" || $img_type == "image/png")
			{
				$img_temporal = $archivo["tmp_name"];
				$img_info = getimagesize($img_temporal);
				$img_width = $img_info[0];
				$img_height = $img_info[1];
				switch ($t) {
					case 's':
					case 'S':
						if ($img_height > 144 && $img_width > 144)
							return '';
						else
							return 'Dimensiones inadecuadas.';
					case 'm':
					case 'M':
						if ($img_height > 360 && $img_width > 480)
							return '';
						else
							return 'Dimensiones inadecuadas.';
					case 'l':
					case 'L':
					default:
						if ($img_height > 480 && $img_width > 720)
							return '';
						else
							return 'Dimensiones inadecuadas.';
				}
			}
			else
				return 'Archivo de tipo no válido.';
	 	}
	 	else
	 		return 'Archivo muy grande.';
	}

	public static function convertirA64($archivo){
		return base64_encode(file_get_contents($archivo['tmp_name']));
	}

	public static function setCombo($name, $value, $query)
	{
		$data = Database::getRows($query, null);
		$combo = "<select name='$name' required>";
		if($value == null)
		{
			$combo .= "<option value='' disabled selected>Seleccione una opción</option>";
		}
		foreach($data as $row)
		{
			$combo .= "<option value='$row[0]'";
			if(isset($_POST[$name]) == $row[0] || $value == $row[0])
			{
				$combo .= " selected";
			}
			$combo .= ">$row[1]</option>";
		}
		$combo .= "</select>
		<label style='text-transform: capitalize;'>$name</label>";
		print($combo);
	}

	function URLA64($data) {
		return rtrim(strtr(base64_encode(pack('H*', $data)), '+/', '-_'), '=');
	}

	function URLD64($data) {
		return bin2hex(base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT)));
	}
}
?>